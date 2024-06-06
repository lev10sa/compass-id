// import dependencies
import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

// create the main function
const Navigation = () => {
  const [currentIndex, setCurrentIndex] = useState(0);

  const images = [
    {
      url: "/assets/img/banner/c.jpg",
      class: "",
    },
    {
      url: "/assets/img/banner/d.jpg",
      class: "",
    },
    {
      url: "/assets/img/banner/e.jpg",
      class: "",
    },
    {
      url: "/assets/img/banner/a.jpg",
      class: "",
    },
    {
      url: "/assets/img/banner/b.jpg",
      class: "",
    },
  ];

  // setting up useNavigate
  const navigat = useNavigate();

  const navigate = (val) => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
    navigat(val);
  };

  const openMenu = () => {
    document.getElementById("sidenav").classList.toggle("active");
  };

  useEffect(() => {
    const intervalId = setInterval(() => {
      setCurrentIndex((prev) => (prev + 1) % images.length);
      document.getElementById("images").classList.remove("active");
      document.getElementById("images").classList.add("active");
    }, 15000);

    return () => clearInterval(intervalId);
  }, [images.length]);

  const handleNext = () => {
    setCurrentIndex((prev) =>
      prev === images.length - 1 ? prev - images.length + 1 : prev + 1
    );
    document.getElementById("images").classList.remove("active");
    document.getElementById("images").classList.add("active");
  };

  const handlePrev = () => {
    setCurrentIndex((prev) =>
      prev === 0 ? prev + images.length - 1 : prev - 1
    );
    document.getElementById("images").classList.remove("active");
    document.getElementById("images").classList.add("active");
  };

  // display of the navbar
  return (
    <>
      <div className="navbar">
        <div className="logo">
          <button onClick={() => navigate(`/`)}>
            <img src="/logo.png" alt="logo" />
          </button>
        </div>
        <div className="tabs">
          <button className="menu" onClick={openMenu}>
            <i className="fas fa-bars"></i>
          </button>
        </div>
        <div className="tabi">
          <button
            className="btn"
            onClick={() => window.open("https://wa.me/6285174448002", "_blank")}
          >
            <i className="fas fa-headset"></i> <span>Contact Us</span>
          </button>
        </div>
        <div className="taba">
          <button onClick={() => navigate(`/`)}>
            <i className="fas fa-home"></i> <span>Home</span>
          </button>
          <button onClick={() => navigate(`/events`)}>
            <i className="fas fa-calendar-alt"></i> <span>Event</span>
          </button>
          <button onClick={() => navigate(`/posts`)}>
            <i className="fas fa-file-alt"></i> <span>post</span>
          </button>
          <button onClick={() => navigate(`/books`)}>
            <i className="fas fa-book"></i> <span>Book</span>
          </button>
          <button onClick={() => navigate(`/`)}>
            <i className="fas fa-question-circle"></i> <span>FAQ</span>
          </button>
        </div>
      </div>
      <div id="banner" className="section banner">
        <img
          src={images[currentIndex].url}
          alt={images[currentIndex].url}
          className="animate__animated animate__fadeIn active"
          id="images"
          key={currentIndex}
        />
        <button className="prev" onClick={handlePrev}>
          &#10094;
        </button>
        <button className="next" onClick={handleNext}>
          &#10095;
        </button>
      </div>
      <div id="sidenav">
        <div className="plain sidenav-wrapper" onClick={openMenu}></div>
        <div className="sidenav animate__animated animate__slideInLeft">
          <img src="/logo.png" alt="logo" />
          <div className="header">NAVIGATION</div>
          <button onClick={() => navigate(`/`)}>
            <span>Home</span> <i className="fas fa-home"></i>
          </button>
          <button onClick={() => navigate(`/events`)}>
            <span>Event</span> <i className="fas fa-calendar-alt"></i>
          </button>
          <button onClick={() => navigate(`/posts`)}>
            <span>post</span> <i className="fas fa-file-alt"></i>
          </button>
          <button onClick={() => navigate(`/books`)}>
            <span>Book</span> <i className="fas fa-book"></i>
          </button>
          <button onClick={() => navigate(`/`)}>
            <span>FAQ</span> <i className="fas fa-question-circle"></i>
          </button>
        </div>
      </div>
    </>
  );
};

// export the main function
export default Navigation;
