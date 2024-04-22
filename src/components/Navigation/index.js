// import dependencies
import React from "react";
import { useNavigate } from "react-router-dom";

// create the main function
const Navigation = () => {
  // setting up useNavigate
  const navigate = useNavigate();

  const openMenu = () => {
    document.getElementById("sidenav").classList.toggle("active");
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
          <button className="menu" onClick={openMenu}>
            <i className="fas fa-bars"></i>
          </button>
        </div>
      </div>
      <div className="section banner">
        <img src="/assets/img/banner/a.jpg" alt="" />
      </div>
      <div className="sidenav-wrapper" id="sidenav">
        <div className="plain" onClick={openMenu}></div>
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
