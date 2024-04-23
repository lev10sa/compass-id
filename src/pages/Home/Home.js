import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

function Home() {
  const [currentTime, setCurrentTime] = useState(new Date());

  const navigate = useNavigate();

  useEffect(() => {
    const intervalId = setInterval(() => {
      setCurrentTime(new Date());
    }, 1000);
    return () => clearInterval(intervalId);
  }, []);

  const getGreeting = () => {
    const hours = currentTime.getHours();

    if (hours >= 5 && hours < 12) {
      return (
        <h4>
          <i className="fas fa-cloud-sun"></i> Good Morning!
        </h4>
      );
    } else if (hours >= 12 && hours < 18) {
      return (
        <h4>
          <i className="fas fa-sun"></i> Good Afternoon!
        </h4>
      );
    } else if (hours >= 18 && hours < 21) {
      return (
        <h4>
          <i className="fas fa-cloud-moon"></i> Good Evening!
        </h4>
      );
    } else if (hours >= 21 || hours < 5) {
      return (
        <h4>
          <i className="fas fa-star-and-crescent"></i> Good Night!
        </h4>
      );
    }
  };

  const greeting = getGreeting();

  const books = [
    {
      url: "https://i.compasspub.com/userfiles/item/20231122132720_itm.png",
    },
    {
      url: "https://i.compasspub.com/userfiles/item/20231212144942_itm.jpg",
    },
    {
      url: "https://i.compasspub.com/userfiles/item/20231117142036_itm.png",
    },
    {
      url: "https://i.compasspub.com/userfiles/item/20231212145035_itm.jpg",
    },
    {
      url: "https://i.compasspub.com/userfiles/item/2023080994546_itm.png",
    },
    {
      url: "https://i.compasspub.com/userfiles/item/2023102511058_itm.jpg",
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
      url: "/",
      label: "Article",
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

  return (
    <>
      <div className="container">
        <div className="panel">
          <div className="section headline">
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
            <h5>Recommendation</h5>
          </div>
          <div className="section scrollList">
            {books.map((book, index) => (
              <>
                <img src={book.url} alt="" key={index} />
              </>
            ))}
          </div>
        </div>
        <div className="section about">
          <div className="section headline">
            <h5>Publication</h5>
          </div>
          <div className="section">
            <p>
              In 1999, Compass Publishing published its inaugural textbook
              English for Everyday Activity, commencing our journey into the in
              ELT Publishing market. Since that first step, we have stayed
              committed to our philosophy of "English Education for a better
              life". We hold this belief to be true as it has motivated us to
              continuously develop quality academic matterials.
            </p>
          </div>
        </div>
        <div className="section partner">
          <div className="section headline">
            <h5>Partnership</h5>
          </div>
          <div className="section thumbs">
            <img
              src="https://www.wjcompass.com/eng/front/image/main/btn_menu01_on.png"
              alt=""
            />
            <img
              src="https://www.wjcompass.com/kor/front/image/main/btn_menu02_on.png"
              alt=""
            />
            <img
              src="https://www.wjcompass.com/kor/front/image/main/btn_menu03_on.png"
              alt=""
            />
          </div>
        </div>
        <div className="section"></div>
      </div>
    </>
  );
}

export default Home;
