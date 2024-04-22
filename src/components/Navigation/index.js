// import dependencies
import React from "react";
import { useNavigate } from "react-router-dom";

// create the main function
const Navigation = () => {
  // setting up useNavigate
  const navigate = useNavigate();
  let isClicked = false;

  const closeSidenav = () => {
    if (isClicked === true) {
      document.getElementById("sidenav").style.display = "none";
      isClicked = false;
    } else if (isClicked === false) {
      document.getElementById("sidenav").style.display = "block";
      isClicked = true;
    }
  };

  // display of the navbar
  return (
    <>
      <div className="navbar shdw">
        <div className="logo">
          <button onClick={() => navigate(`/`)}>
            <img src="/logo.png" alt="" />
          </button>
        </div>
        <div className="tabs">
          <button onClick={() => navigate(`/`)}>
            <i className="fas fa-home"></i> <span>Home</span>
          </button>
          <button onClick={() => navigate(`/events`)}>
            <i className="fas fa-calendar-alt"></i> <span>Event</span>
          </button>
          <button className="menu" onClick={closeSidenav}>
            <i className="fas fa-bars"></i>
          </button>
        </div>
      </div>
      <div className="section banner">
        <img src="/assets/img/banner/a.jpg" alt="" />
      </div>
      <div className="sidenav-wrapper" id="sidenav">
        <div className="plain" onClick={closeSidenav}></div>
        <div className="sidenav">
          <img src="/logo.png" alt="" />
          <button onClick={() => navigate(`/`)}>
            <i className="fas fa-home"></i> <span>Home</span>
          </button>
          <button onClick={() => navigate(`/events`)}>
            <i className="fas fa-calendar-alt"></i> <span>Event</span>
          </button>
        </div>
      </div>
    </>
  );
};

// export the main function
export default Navigation;
