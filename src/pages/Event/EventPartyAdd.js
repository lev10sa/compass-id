import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useParams } from "react-router-dom";
import { Helmet } from "react-helmet";

function EventPartyAdd() {
  // Fetches latest Event count for serie generation (Optional)
  const [isLoading, setIsLoading] = useState(true); // state for loading
  const [isEmpty, setIsEmpty] = useState(false);

  const { id } = useParams();

  const [event, setEvent] = useState({
    title: "",
    pic: "",
    model: "",
    img: "",
    desc: "",
    start: "",
    end: "",
    group: "",
    address: "",
    price: "",
  });

  const [selectedFile, setSelectedFile] = useState(null);
  const [eventData, setEventData] = useState({
    name: "",
    company: "",
    job: "",
    email: "",
    phone: "",
    address: "",
    file: "",
    event: "",
    room: "",
  });

  // Setting up useNavigate
  const navigat = useNavigate();

  const navigate = (val) => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
    navigat(val);
  };

  const handleChange = (event) => {
    // For non-file inputs, set the value directly
    setEventData({
      ...eventData,
      [event.target.name]: event.target.value,
    });
  };

  const handleFile = (event) => {
    setSelectedFile(event.target.files[0]);
    // Access the filename from the selected file
    const fileDir = "https://compasspubindonesia.com/media/api/bills/img/";
    const file = event.target.files[0];
    const filename = fileDir + file.name;
    setEventData({
      ...eventData,
      file: filename,
    });
  };

  const AddEvent = async (e) => {
    document.getElementById("submit").type = "reset";
    document.getElementById("submit").textContent =
      "Saving data, please wait..";

    e.preventDefault();

    const cleanedData = {
      ...eventData,
      event: event._id,
    };

    const formData = {
      title: event.title,
      group: event.group,
      start: event.start,
      end: event.end,
      name: eventData.name,
      email: eventData.email,
    };

    const formiData = new FormData();
    formiData.append("img", selectedFile);

    if (
      event !== "" &&
      eventData !== "" &&
      formData !== "" &&
      formiData !== ""
    ) {
      try {
        // Add the Event into database with axios
        await axios.post(
          `https://seg-server.vercel.app/api/parties`,
          cleanedData
        );

        await axios.post(
          `https://compasspubindonesia.com/media/api/bills/index.php`,
          formiData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        await axios.post(
          `https://compasspubindonesia.com/media/api/mails/index.php`,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        // Navigate to main page
        alert(
          `Halo ${eventData.name}! Anda berhasil terdaftar dalam acara ${event.title}! Silakan tunggu informasi lebih lanjut terkait acara ini yang akan kami kirim melalui email.`
        );

        navigate(`/events`);
      } catch (error) {
        window.alert(error.message); // Display error messages
      }
    } else {
      alert("Please fill the blanks.. | Silakan isi bagian yang kosong..");
    }
  };

  // create currency format function
  function formatCurrency(number) {
    // define options for formatting
    const options = {
      style: "currency", // set currency
      currency: "IDR", // set currency code for Indonesian Rupiah (IDR)
      minimumFractionDigits: 2, // set minimum decimal places to 2
      maximumFractionDigits: 2, // set maximum decimal places to 2
    };

    // use toLocaleString() with the defined options
    return new Intl.NumberFormat("id-ID", options).format(number);
  }

  // setting up useEffect to do tasks in real-time

  useEffect(() => {
    // create party loader callback function
    const getEvent = async () => {
      try {
        const url = `https://seg-server.vercel.app/api/events/id/${id}`; // modify URL based on backend
        const datas = await axios.get(url); // get datas from URL with axios
        datas.data.length === 0 ? setIsEmpty(true) : setIsEmpty(false);
        setIsLoading(false);
        setEvent(datas.data);
      } catch (error) {
        window.alert(error.message); // display error message
      }
    };

    getEvent(); // dependency array with only `search`
  }, [id]); // dependency array with only `getParty`

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

  const seePeg = () => {
    document.getElementById("see").style = "display: none;";
    document.getElementById("peg").style = "display: block;";
  };

  const unseePeg = () => {
    document.getElementById("see").style = "display: block;";
    document.getElementById("peg").style = "display: none;";
  };

  const handleCopy = () => {
    const uri = `https://www.compasspubindonesia.com/event-join.php?id=${event._id}`;
    const copied = navigator.clipboard.writeText(uri);
    if (copied) {
      document.getElementById("fab").classList.add("active");
      document.getElementById("lbs").innerText = "Link Copied";
    }
  };

  return (
    <>
      <Helmet>
        <title>{event.title} | Compass Publishing Indonesia</title>
        <meta name="description" content={`${event.desc}`} />
        <meta
          property="og:url"
          content={`https://www.compasspubindonesia.com/event-join/${event._id}`}
        />
        <meta
          property="og:title"
          content={`${event.title} | Compass Publishing Indonesia`}
        />
        <meta property="og:description" content={`${event.desc}`} />
        <meta property="og:image" content={`${event.img}`} />
      </Helmet>
      <div className="party container">
        {isLoading === true ? (
          <div className="section loading">Loading Event Database...</div> // display status when loading
        ) : isEmpty ? (
          <div className="section empty">No data...</div> // display status when loading
        ) : (
          <>
            <div className="left">
              {event.title !== "" ? (
                <div>
                  <h3>{event.title}</h3>
                </div>
              ) : (
                <></>
              )}
              <div className="section"></div>
              {event.img !== "" ? (
                <div className="section">
                  <img
                    src={event.img}
                    alt={event.img}
                    onClick={() => window.open(event.img, "_blank")}
                  />
                </div>
              ) : (
                <></>
              )}
              <div className="section"></div>
              <button type="button" onClick={seePeg} className="btni" id="see">
                See Description
              </button>
              <div id="peg">
                <div
                  style={{
                    width: "100%",
                    padding: "1rem 5px",
                    textAlign: "center",
                    borderBottom: "1px solid #111",
                  }}
                >
                  <h4>Event Description</h4>
                </div>
                <div className="section"></div>
                {event.pic !== "" ? (
                  <div className="section">
                    <p>
                      <strong>Speaker:</strong>
                    </p>
                    <p>{event.pic}</p>
                  </div>
                ) : (
                  <></>
                )}
                {event.model !== "" ? (
                  <div className="section">
                    <p>
                      <strong>Role:</strong>
                    </p>
                    <p>{event.model}</p>
                  </div>
                ) : (
                  <></>
                )}
                {event.start !== "" ? (
                  <div className="section">
                    <p>
                      <strong>Time:</strong>
                    </p>
                    <p>{formatTime(event.start)}</p>
                  </div>
                ) : (
                  <></>
                )}
                {event.address !== "" ? (
                  <div className="section">
                    <p>
                      <strong>Location:</strong>
                    </p>
                    <p>{event.address}</p>
                  </div>
                ) : (
                  <></>
                )}
                {event.price !== "" ? (
                  <div className="section">
                    <p>
                      <strong>Price:</strong>
                    </p>
                    <p>{formatCurrency(event.price)}</p>
                  </div>
                ) : (
                  <></>
                )}
                {event.desc !== "" ? (
                  <div className="section">
                    <p>
                      <strong>Description:</strong>
                    </p>
                    <pre>{event.desc}</pre>
                  </div>
                ) : (
                  <></>
                )}
                <button
                  type="button"
                  onClick={unseePeg}
                  className="btni"
                  id="unsee"
                >
                  See Less
                </button>
              </div>
              <div className="section"></div>
              {event.price !== 0 ? (
                <div>
                  <p>
                    Untuk mendaftar, silakan lakukan pembayaran via transfer ke
                    no. rekening BCA atas nama PT. SOLUSI EDUKASI GEMILANG,
                    berikut ini:
                    <br />
                    <br />
                    BCA - 4685015898
                    <br />
                    PT. Solusi Edukasi Gemilang
                  </p>
                </div>
              ) : (
                <></>
              )}
              <div className="section"></div>
              <div className="section"></div>
              <div className="section"></div>
            </div>
          </>
        )}

        {isLoading === true ? (
          <></> // display status when loading
        ) : isEmpty ? (
          <></> // display status when loading
        ) : (
          <div className="right">
            <div className="section headline">
              <h4>Join Event</h4>
              <button onClick={() => navigate(`/events`)} className="btn">
                See Events
              </button>
            </div>
            <div className="section">
              <form onSubmit={AddEvent} className="form">
                <div className="field">
                  <label className="label">Name | Nama</label>
                  <input
                    type="text"
                    autoComplete="on"
                    className="input"
                    id="name"
                    name="name"
                    value={eventData.name}
                    onChange={handleChange}
                    placeholder="Name | Nama"
                    required
                  />
                </div>
                <div className="field">
                  <label className="label">Occupation | Pekerjaan</label>
                  <select
                    id="job"
                    name="job"
                    value={eventData.job}
                    onChange={handleChange}
                    required
                  >
                    <option value="">
                      --- Select Occupation | Pilih Pekerjaan ---
                    </option>
                    <option value="Headmaster">
                      Headmaster | Kepala Sekolah
                    </option>
                    <option value="Teacher">Teacher | Guru</option>
                    <option value="Tutor">Tutor | Tutor</option>
                    <option value="Parent">Parent | Orang Tua</option>
                    <option value="Other">Other | Lainnya</option>
                  </select>
                </div>
                <div className="field">
                  <label className="label">
                    School/Organization | Sekolah/Organisasi
                  </label>
                  <input
                    type="text"
                    autoComplete="on"
                    className="input"
                    id="company"
                    name="company"
                    value={eventData.company}
                    onChange={handleChange}
                    placeholder="School/Organization | Sekolah/Organisasi"
                    required
                  />
                </div>
                <div className="field">
                  <label className="label">Email | Email</label>
                  <input
                    type="text"
                    autoComplete="on"
                    className="input"
                    id="email"
                    name="email"
                    value={eventData.email}
                    onChange={handleChange}
                    placeholder="Email | Email"
                    required
                  />
                </div>
                <div className="field">
                  <label className="label">
                    {" "}
                    WhatsApp / Phone | WhatsApp / Telepon
                  </label>
                  <input
                    type="text"
                    autoComplete="on"
                    className="input"
                    id="phone"
                    name="phone"
                    value={eventData.phone}
                    onChange={handleChange}
                    placeholder="Phone | Telepon"
                    required
                  />
                </div>
                <div className="field">
                  <label className="label">City | Kota</label>
                  <input
                    type="text"
                    autoComplete="on"
                    className="input"
                    id="address"
                    name="address"
                    value={eventData.address}
                    onChange={handleChange}
                    placeholder="City | Kota"
                    required
                  />
                </div>
                <div className="field">
                  <label className="label">Attendance | Kehadiran</label>
                  <select
                    id="room"
                    name="room"
                    value={eventData.room}
                    onChange={handleChange}
                    required
                  >
                    <option value="">
                      --- Select Attendance | Pilih Kehadiran ---
                    </option>
                    <option value="Online">Online | Daring</option>
                    <option value="Onsite">Onsite | Luring</option>
                  </select>
                </div>
                {event.price !== 0 ? (
                  <div className="field">
                    <label className="label">
                      Proof of Payment | Bukti Pembayaran
                    </label>
                    <br />
                    <label style={{ fontSize: "10pt" }}>
                      Please attach your proof of payment bank slip transfer |
                      Sisipkan bukti slip pembayaran
                    </label>
                    <input
                      type="file"
                      autoComplete="on"
                      className="input"
                      id="img"
                      name="img"
                      onChange={handleFile}
                      placeholder="Proof of Payment | Bukti Pembayaran"
                      required
                    />
                  </div>
                ) : (
                  <></>
                )}
                <div className="section">
                  <div className="controls forms">
                    <button type="submit" className="btn" id="submit">
                      Join This Event
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        )}
      </div>
      <div className="section"></div>
      <div className="section"></div>
      <button
        type="button"
        onClick={() => handleCopy()}
        className="fab"
        id="fab"
      >
        <span id="lbs">Share</span> <i className="fas fa-share-alt"></i>
      </button>
    </>
  );
}

export default EventPartyAdd;
