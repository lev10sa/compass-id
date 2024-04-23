import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

function Home() {
  const [currentTime, setCurrentTime] = useState(new Date());

  const navigate = useNavigate();

  useEffect(() => {
    setCurrentTime(new Date());
    alr();
  }, []);

  const alr = () => {
    return alert(
      "Welcome to Compass Publishing Indonesia, this website is still under construction, so perhaps some features wouldn't work correctly."
    );
  };

  const getGreeting = () => {
    const hours = currentTime.getHours();

    if (hours >= 5 && hours < 12) {
      return (
        <h4>
          <i className="fas fa-cloud-sun"></i> Good Morning!
        </h4>
      );
    } else if (hours >= 12 && hours < 15) {
      return (
        <h4>
          <i className="fas fa-sun"></i> Good Day!
        </h4>
      );
    } else if (hours >= 15 && hours < 18) {
      return (
        <h4>
          <i className="fas fa-cloud-sun"></i> Good Afternoon!
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
      url: "javascript:popEbook('https://eb.compasspub.com/v2/?uri=books/Ni_Hao_1/work/&prev=15%27)",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/2018032617514_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/BigShow_1/work/&prev=15%27",
    },
    {
      src: "https://i.compasspub.com/userfiles/item/2023070595325_itm.jpg",
      url: "https://compasspubindonesia.com",
    },
    {
      src: "https://www.compasspub.com/userfiles/item/20211006135227_itm.jpg",
      url: "https://eb.compasspub.com/v2/?uri=books/Splash_1/work/&prev=21%27",
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

  const socials = [
    {
      src: "https://static.xx.fbcdn.net/rsrc.php/yT/r/aGT3gskzWBf.ico?_nc_eui2=AeFGwtFgLdVIHM7LBnFuKvT_rSiY817De8atKJjzXsN7xqi8ECKJdfPZh9_pxx_g-_0wOCb9xZ5iP9uVJIRjdb8O",
      url: "https://facebook.com/compasspubindonesia",
    },
    {
      src: "https://static.cdninstagram.com/rsrc.php/v3/yG/r/De-Dwpd5CHc.png",
      url: "https://instagram.com/compasspubindonesia",
    },
    {
      src: "https://static.licdn.com/aero-v1/sc/h/akt4ae504epesldzj74dzred8",
      url: "https://www.linkedin.com/company/compass-publishing-indonesia",
    },
    {
      src: "https://www.youtube.com/s/desktop/050e6796/img/favicon_144x144.png",
      url: "https://www.youtube.com/@compasspubindonesia",
    },
    {
      src: "https://sf16-sg.tiktokcdn.com/obj/eden-sg/uvkuhyieh7lpqpbj/pwa/192x192.png",
      url: "https://www.tiktok.com/@compasspubindonesia?is_from_webapp=1&sender_device=pc",
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
              <a href={book.url} target="_blank" rel="noreferrer">
                <img src={book.src} alt="" key={index} />
              </a>
            ))}
          </div>
        </div>
        <div className="section about">
          <div className="section headline">
            <h5>Publication</h5>
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
        <div className="section partner">
          <div className="section headline">
            <h5>Partnership</h5>
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
        <div className="section"></div>
      </div>
      <div className="section footer">
        <div className="container section">
          <div className="section">
            {socials.map((soc, index) => (
              <>
                <a
                  href={soc.url}
                  target="
                _blank"
                  key={index}
                >
                  <img src={soc.src} alt="" />
                </a>
              </>
            ))}
          </div>
          <div className="section">
            <p>&copy; 2024 - PT Solusi Edukasi Gemilang</p>
          </div>
        </div>
      </div>
    </>
  );
}

export default Home;
