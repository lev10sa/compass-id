import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useParams } from "react-router-dom";

function PostEnView() {
  // Fetches latest Event count for serie generation (Optional)
  const [isLoading, setIsLoading] = useState(true); // state for loading
  const [isEmpty, setIsEmpty] = useState(false);

  const { id } = useParams();

  const [post, setPost] = useState([]);
  const [posts, setPosts] = useState([]);
  const [lang, setLang] = useState("en");
  const postp = posts.slice(0, 3);

  const langSet = (a, b) => {
    setLang(a);
    document.getElementById(a).classList.add("active");
    document.getElementById(b).classList.remove("active");
  };

  // Setting up useNavigate
  const navigate = useNavigate();

  // setting up useEffect to do tasks in real-time
  useEffect(() => {
    // create party loader callback function
    const getPost = async () => {
      try {
        let uri = "";
        lang === "en"
          ? (uri = `https://seg-server.vercel.app/api/posts/en`)
          : (uri = `https://seg-server.vercel.app/api/posts/id`);
        lang === "id"
          ? (uri = `https://seg-server.vercel.app/api/posts/id`)
          : (uri = `https://seg-server.vercel.app/api/posts/en`);
        const url = `https://seg-server.vercel.app/api/posts/en/id/${id}`; // modify URL based on backend
        const datas = await axios.get(url); // get datas from URL with axios
        const datap = await axios.get(uri); // get datas from URL with axios
        datas.data.length === 0 ? setIsEmpty(true) : setIsEmpty(false);
        setPost(datas.data);
        setPosts(datap.data);
        setIsLoading(false);
      } catch (error) {
        window.alert(error.message); // display error message
      }
    };

    getPost(); // dependency array with only `search`
  }, [id, lang, isLoading]); // dependency array with only `getParty`

  const handleClick = (val) => {
    navigate(`/post-view/${lang}/${val}`);
    setIsLoading(true);
    window.location.hash = "banner";
  };

  const selMain = (value) => {
    document.getElementById("main").src = document.getElementById(
      `main-${value}`
    ).src;
  };

  function formatTime(dateString) {
    // Create a new Date object from the provided dateString
    const date = new Date(dateString);

    // Define arrays for day names and month names
    const daysOfWeek = [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
    ];
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];

    // Get the day of the week, month, day, and year from the Date object
    const dayOfWeek = daysOfWeek[date.getDay()];
    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    // Get the hours and minutes from the Date object
    const hours = date.getHours();
    const minutes = date.getMinutes();

    // Format the time as "HH.MM"
    const time = `${hours < 10 ? "0" : ""}${hours}.${
      minutes < 10 ? "0" : ""
    }${minutes}`;

    // Return the formatted date string
    return `${dayOfWeek}, ${day} ${month} ${year}. ${time} WIB`;
  }

  return (
    <>
      <div className="party container">
        {isLoading === true ? (
          <div className="section loading">Loading post database...</div> // display status when loading
        ) : isEmpty ? (
          <div className="section empty">No data...</div> // display status when loading
        ) : (
          <>
            <div className="section">
              <div className="section headline">
                <h4>Post View</h4>
                <button onClick={() => navigate(`/posts`)} className="btn">
                  See Posts
                </button>
              </div>
              <div className="posts section" key={post._id}>
                <div className="film">
                  <img src={post.banner} alt={post.banner} id="main" />
                  <div className="panel">
                    <img
                      src={post.banner}
                      alt={post.banner}
                      id="main-0"
                      onClick={() => selMain(0)}
                      className="active"
                    />
                    {post.fileList.map((file, index) => (
                      <img
                        src={file.url}
                        alt={file.url}
                        key={index + 1}
                        id={`main-${index + 1}`}
                        onClick={() => selMain(index + 1)}
                      />
                    ))}
                  </div>
                </div>
                <div className="section"></div>
                <div className="section sub">
                  <h2>{post.title.toUpperCase()}</h2>
                  <p>{formatTime(post.date)}</p>
                </div>
                <pre
                  className="section"
                  dangerouslySetInnerHTML={{ __html: post.body }}
                />
                <div className="section"></div>
                <p>
                  <strong>Category:</strong> {post.category}
                </p>
                <p>
                  <strong>Tags:</strong> {post.tags}
                </p>
              </div>
            </div>
            <div className="section"></div>
            <div className="section"></div>
            <div className="section post">
              <div className="section headline">
                <h5 style={{ float: "left" }}>Latest Posts</h5>
                <button
                  type="button"
                  onClick={() => navigate("/posts")}
                  style={{
                    borderRadius: "10px",
                    background: "transparent",
                    color: "#111",
                    border: "1px hidden",
                    paddingLeft: "5px",
                    paddingRight: "5px",
                    float: "right",
                  }}
                  className="btn"
                >
                  <span style={{ marginRight: "10px" }}>See More</span>&#10095;
                </button>
              </div>
              <div className="section lang">
                <span>Select Language:</span>
                <button
                  type="button"
                  onClick={() => langSet("en", "id")}
                  id="en"
                  className={`${lang === "en" ? "active" : ""}`}
                >
                  English
                </button>
                <button
                  type="button"
                  onClick={() => langSet("id", "en")}
                  id="id"
                  className={`${lang === "id" ? "active" : ""}`}
                >
                  Indonesian
                </button>
              </div>
              {isLoading === true ? (
                <>
                  <div className="section loading">
                    <p>Loading data, please wait...</p>
                  </div>
                </>
              ) : isEmpty === true ? (
                <>
                  <div className="section empty">
                    <p>No data...</p>
                  </div>
                </>
              ) : (
                <>
                  <div className="scrollList">
                    {postp.map((item, index) => (
                      <div
                        onClick={() => handleClick(item._id)}
                        rel="noreferrer"
                        key={index}
                        className="panel section"
                      >
                        <img src={item.banner} alt={item.banner} />
                        <h3>{item.title.toUpperCase()}</h3>
                        <p>
                          <strong>Date:</strong> {formatTime(item.date)}
                        </p>
                        <p>
                          <strong>Category:</strong> {item.category}
                        </p>
                        <p>
                          <strong>Tags:</strong> {item.tags}
                        </p>
                        <button
                          type="button"
                          onClick={() => handleClick(item._id)}
                          className="btn"
                        >
                          Read This post
                        </button>
                      </div>
                    ))}
                  </div>
                </>
              )}
            </div>
          </>
        )}
      </div>
      <div className="section"></div>
      <div className="section"></div>
    </>
  );
}

export default PostEnView;
