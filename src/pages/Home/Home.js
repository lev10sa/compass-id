import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";

function Home() {
  const [currentTime, setCurrentTime] = useState(new Date());
  const [post, setpost] = useState([]);
  const [isEmpty, setIsEmpty] = useState(true);
  const [isLoading, setIsLoading] = useState(true);
  const [lang, setLang] = useState("en");
  const posts = post.slice(0, 4);

  const navigate = useNavigate();

  useEffect(() => {
    setCurrentTime(new Date());
    alr();

    const getpost = async () => {
      let url = "";
      lang === "en"
        ? (url = `https://seg-server.vercel.app/api/posts/en`)
        : (url = `https://seg-server.vercel.app/api/posts/id`);
      lang === "id"
        ? (url = `https://seg-server.vercel.app/api/posts/id`)
        : (url = `https://seg-server.vercel.app/api/posts/en`);
      try {
        const datas = await axios.get(url);
        datas.data.length !== 0 ? setIsEmpty(false) : setIsEmpty(true);
        setpost(datas.data);
        setIsLoading(false);
      } catch (error) {
        window.alert(error.message);
      }
    };

    getpost();
  }, [lang]);

  const alr = () => {
    return alert(
      "Welcome to Compass Publishing Indonesia, this website is still under construction, so perhaps some features wouldn't work correctly."
    );
  };

  const getGreeting = () => {
    const hours = currentTime.getHours();

    if (hours >= 5 && hours < 12) {
      return (
        <h5>
          <i style={{ marginRight: "10px" }} className="fas fa-cloud-sun"></i>{" "}
          Hello, Good Morning!
        </h5>
      );
    } else if (hours >= 12 && hours < 15) {
      return (
        <h5>
          <i style={{ marginRight: "10px" }} className="fas fa-sun"></i> Hello,
          Good Day!
        </h5>
      );
    } else if (hours >= 15 && hours < 18) {
      return (
        <h5>
          <i style={{ marginRight: "10px" }} className="fas fa-cloud-sun"></i>{" "}
          Hello, Good Afternoon!
        </h5>
      );
    } else if (hours >= 18 && hours < 21) {
      return (
        <h5>
          <i style={{ marginRight: "10px" }} className="fas fa-cloud-moon"></i>{" "}
          Hello, Good Evening!
        </h5>
      );
    } else if (hours >= 21 || hours < 5) {
      return (
        <h5>
          <i
            style={{ marginRight: "10px" }}
            className="fas fa-star-and-crescent"
          ></i>{" "}
          Hello, Good Night!
        </h5>
      );
    }
  };

  const greeting = getGreeting();

  const books = [
    {
      src: "https://www.compasspub.com/userfiles/item/20200903161644_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/Odyssey1/work/&prev=17%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/20230508105235_itm.png",
      url: "https://eb.compasspub.com/v2/?uri=books/Boost_English_1/work/&prev=23%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/2019041295137_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/interact_1/work/&prev=19%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/20200922145515_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/HangOut_Starter/work/&prev=19%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/20200922134819_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/NF1/work/&prev=21%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/2010052791452_itm.PNG",
      url: "https://eb.compasspub.com/v2/?uri=books/SoundsGreat_1/work/&prev=15%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/2022040811442_itm.jpg",
      url: "'https://eb.compasspub.com/v2/?uri=books/Ni_Hao_1/work/&prev=15%27",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/2018032617514_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/BigShow_1/work/&prev=15%27",
    },
    {
      src: "https://i.compasspub.com/userfiles/item/2023070595325_itm.jpg",
      url: "https://compasspubindonesia.com",
    },
  ];

  const partners = [
    {
      src: "/assets/img/partner/b.jpg",
      uri: "https://compasspub.com/eng",
    },
    {
      src: "/assets/img/partner/a.jpg",
      uri: "https://classboxenglish.com",
    },
    {
      src: "/assets/img/partner/c.jpg",
      uri: "https://global.playbigbox.com",
    },
    {
      src: "/assets/img/partner/e.jpg",
      uri: "https://mathpid.com",
    },
    {
      src: "/assets/img/partner/d.jpg",
      uri: "https://mathpid.com",
    },
  ];

  const icons = [
    {
      src: "fas fa-calendar-alt",
      url: "/events",
      label: "Event",
    },
    {
      src: "fas fa-file-alt",
      url: "/posts",
      label: "post",
    },
    {
      src: "fas fa-book",
      url: "/",
      label: "Book",
    },
    {
      src: "fas fa-question-circle",
      url: "/",
      label: "FAQ",
    },
  ];

  const langSet = (a, b) => {
    setLang(a);
    document.getElementById(a).classList.add("active");
    document.getElementById(b).classList.remove("active");
  };

  const formatTime = (dateString) => {
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
  };

  return (
    <>
      <div className="container">
        <div className="panel">
          <div className="headline">
            {greeting}
            <div className="section">
              <input
                type="text"
                autoComplete="on"
                className="input"
                placeholder="Search anything..."
              />
            </div>
          </div>
          <div className="section"></div>
          <div className="section icons">
            {icons.map((icon, index) => (
              <>
                <button
                  type="button"
                  onClick={() => navigate(icon.url)}
                  key={index}
                >
                  <span>
                    <i className={icon.src}></i>
                  </span>
                  <label>{icon.label}</label>
                </button>
              </>
            ))}
          </div>
        </div>
        <div className="section recom">
          <div className="section headline">
            <h5 style={{ float: "left" }}>Recommendation</h5>
            <button
              type="button"
              onClick={() => navigate("/")}
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
          {isLoading === true ? (
            <>
              <div className="section loading">
                <p>Loading data, please wait...</p>
              </div>
            </>
          ) : (
            <>
              <div className="section scrollList">
                {books.map((book, index) => (
                  <a href={book.url} target="_blank" rel="noreferrer">
                    <img src={book.src} alt="" key={index} />
                  </a>
                ))}
              </div>
            </>
          )}
        </div>
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
              className="active"
            >
              English
            </button>
            <button type="button" onClick={() => langSet("id", "en")} id="id">
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
                {posts.map((item, index) => (
                  <div
                    onClick={() => navigate(`/post-view/${lang}/${item._id}`)}
                    rel="noreferrer"
                    key={index}
                    className="panel"
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
                      onClick={() => navigate(`/post-view/${lang}/${item._id}`)}
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
        <div className="partner">
          <div className="section headline">
            <h5>Our Services</h5>
          </div>
          <div className="section thumbs">
            {partners.map((thumb, index) => (
              <>
                <a
                  href={thumb.uri}
                  target="
                _blank"
                >
                  <img src={thumb.src} alt={thumb.src} />
                </a>
              </>
            ))}
          </div>
        </div>
        <div className="section about">
          <div className="section headline">
            <h5>About Us</h5>
          </div>
          <div className="section">
            <p>
              <a
                href="https://compasspubindonesia.com"
                target="_blank"
                rel="noreferrer"
              >
                Compass Publishing Indonesia
              </a>{" "}
              is a representative from{" "}
              <a href="https://compasspub.com" target="_blank" rel="noreferrer">
                Compass Publishing
              </a>{" "}
              South Korea which produce innovative ELT solutions for teachers
              and their influence towards students since 1999. We provide all
              services related to ELT books, ELT digital books, ELT
              applications, and Top Class Education Webinar Services for
              Indonesian teachers upskill needs in curriculum insight, language
              skill, digital skill, and class psychology management. We
              positioned as Sahabat Guru Sepanjang Masa in order to develop the
              education quality in Indonesia. We motivate all to inspire to
              teach, inspire to learn.
            </p>
          </div>
        </div>
        <div className="section"></div>
      </div>
    </>
  );
}

export default Home;
