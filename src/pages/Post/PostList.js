// import dependencies
import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { Helmet } from "react-helmet";

// create the main function
const PostList = () => {
  // create the useState
  const [posts, setPosts] = useState([]); // state for Post list
  const [search, setSearch] = useState(""); // state for search
  const [isLoading, setIsLoading] = useState(true); // state for loading
  const [isEmpty, setIsEmpty] = useState(false);
  const [lang, setLang] = useState("id");

  // setting up useNavigate
  const navigat = useNavigate();

  const navigate = (val) => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
    navigat(val);
  };

  const handleClick = (val) => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
    navigate(`/post-view/${lang}/${val}`);
  };

  useEffect(() => {
    // create book loader callback function
    const getposts = async () => {
      try {
        if (!search) {
          let url = "";
          lang === "en"
            ? (url = `https://seg-server.vercel.app/api/posts/en`)
            : (url = `https://seg-server.vercel.app/api/posts/id`);
          lang === "id"
            ? (url = `https://seg-server.vercel.app/api/posts/id`)
            : (url = `https://seg-server.vercel.app/api/posts/en`);
          // modify URL based on backend
          const datas = await axios.get(url); // get datas from URL with axios
          datas.data.length === 0 ? setIsEmpty(true) : setIsEmpty(false);
          setPosts(datas.data);
          setIsLoading(false);
        } else {
          let url = "";
          lang === "en" && search !== ""
            ? (url = `https://seg-server.vercel.app/api/posts/en/key/${search}`)
            : (url = `https://seg-server.vercel.app/api/posts/id/key/${search}`);
          lang === "id" && search !== ""
            ? (url = `https://seg-server.vercel.app/api/posts/id/key/${search}`)
            : (url = `https://seg-server.vercel.app/api/posts/en/key/${search}`);
          // modify URL based on backend
          const datas = await axios.get(url); // get datas from URL with axios
          datas.data.length === 0 ? setIsEmpty(true) : setIsEmpty(false);
          setPosts(datas.data);
          setIsLoading(false);
        }
      } catch (error) {
        window.alert(error.message); // display error message
      }
    };

    getposts();
  }, [search, lang]); // dependency array with only `getposts`

  const langSet = (a, b) => {
    setLang(a);
    document.getElementById(a).classList.add("active");
    document.getElementById(b).classList.remove("active");
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

  const handleSearch = (e) => {
    e.preventDefault();
    setSearch(e.target.value);
  };

  const getHelm = (val) => {
    return (
      <>
        <Helmet>
          <title>Compass Publishing Indonesia | Posts</title>
          <meta
            name="description"
            content="List of Posts in Compass Publishing Indonesia"
          />
          <meta
            property="og:title"
            content="Compass Publishing Indonesia | Posts"
          />
          <meta
            property="og:description"
            content="List of Posts in Compass Publishing Indonesia"
          />
          <meta
            property="og:image"
            content="https://compasspubindonesia.com/logo192.png"
          />
          <meta
            property="og:url"
            content="https://compasspubindonesia.com/posts"
          />
        </Helmet>
      </>
    );
  };

  // render the display
  return (
    <>
      {getHelm()}
      <div className="container">
        <div className="section headline">
          <h4>Post List</h4>
          <button onClick={() => navigate(`/`)} className="btn">
            See Home
          </button>
          <div className="section">
            <input
              type="text"
              autoComplete="on"
              className="input"
              value={search} // set value from search state
              onInput={handleSearch} // update search state on change
              placeholder="Search posts..."
            />
          </div>
        </div>
        <div className="section lang">
          <span>Select Language:</span>
          <button
            type="button"
            onClick={() => langSet("id", "en")}
            id="id"
            className="active"
          >
            Indonesia
          </button>
          <button type="button" onClick={() => langSet("en", "id")} id="en">
            English
          </button>
        </div>
        {isLoading === true ? (
          <div className="section loading">Loading Post Database...</div> // display status when loading
        ) : isEmpty ? (
          <div className="section empty">No data...</div> // display status when loading
        ) : (
          // display table after loading

          <>
            {posts.map((post, index) => (
              <div onClick={() => handleClick(post._id)} className="event">
                {post.banner !== "" ? (
                  <>
                    <img src={post.banner} alt={post.banner} />
                  </>
                ) : (
                  <></>
                )}

                <div className="section caption">
                  {post.title !== "" ? (
                    <>
                      <h3 title={post.title}>{post.title.toUpperCase()}</h3>
                    </>
                  ) : (
                    <></>
                  )}

                  <p className="dip">{post.body}</p>

                  <button onClick={() => handleClick(post._id)} className="btn">
                    Read This post
                  </button>
                </div>
              </div>
            ))}
          </>
        )}
      </div>
      <div className="section"></div>
      <div className="section"></div>
    </>
  );
};

// export the main function
export default PostList;
