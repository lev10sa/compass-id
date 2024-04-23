import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate, useParams } from "react-router-dom";

function EventPartyAdd() {
  // Fetches latest Event count for serie generation (Optional)

  const { id } = useParams();

  const [event, setEvent] = useState([]);

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
  });

  // Setting up useNavigate
  const navigate = useNavigate();

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
    e.preventDefault();

    const cleanedData = {
      ...eventData,
      event: event._id,
    };

    const formData = new FormData();
    formData.append("img", selectedFile);

    try {
      // Add the Event into database with axios
      await axios.post(
        `https://seg-server.vercel.app/api/parties`,
        cleanedData
      );
      await axios.post(
        `https://compasspubindonesia.com/media/api/bills/index.php`,
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );
      // Navigate to main page
      navigate(`/events`);
    } catch (error) {
      console.log(error.message); // Display error messages
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

        setEvent(datas.data);
      } catch (error) {
        console.log(error.message); // display error message
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

  const resetEvent = () => {
    setEventData({
      name: "",
      company: "",
      job: "",
      email: "",
      phone: "",
      address: "",
      file: "",
      event: "",
    });
  };

  return (
    <>
      <div className="party container">
        <div className="left">
          {event.name !== null ? (
            <div>
              <h3>{event.name}</h3>
            </div>
          ) : (
            <></>
          )}
          <div className="section"></div>
          {event.img !== null ? (
            <div className="section">
              <img src={event.img} alt={event.img} />
            </div>
          ) : (
            <></>
          )}
          {event.pic !== null ? (
            <div className="section">
              <p>
                <strong>Speaker:</strong>
              </p>
              <p>{event.pic}</p>
            </div>
          ) : (
            <></>
          )}
          {event.model !== null ? (
            <div className="section">
              <p>
                <strong>Role:</strong>
              </p>
              <p>{event.model}</p>
            </div>
          ) : (
            <></>
          )}
          {event.start !== null ? (
            <div className="section">
              <p>
                <strong>Time:</strong>
              </p>
              <p>{formatTime(event.start)}</p>
            </div>
          ) : (
            <></>
          )}
          {event.address !== null ? (
            <div className="section">
              <p>
                <strong>Location:</strong>
              </p>
              <p>{event.address}</p>
            </div>
          ) : (
            <></>
          )}
          {event.price !== null ? (
            <div className="section">
              <p>
                <strong>Price:</strong>
              </p>
              <p>{formatCurrency(event.price)}</p>
            </div>
          ) : (
            <></>
          )}
          {event.desc !== null ? (
            <div className="section">
              <p>
                <strong>Description:</strong>
              </p>
              <pre>{event.desc}</pre>
            </div>
          ) : (
            <></>
          )}
        </div>
        <div className="section"></div>
        <div className="section"></div>
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
                <label className="label">Name</label>
                <input
                  type="text"
                  autoComplete="on"
                  className="input"
                  id="name"
                  name="name"
                  value={eventData.name}
                  onChange={handleChange}
                  placeholder="Name"
                  required
                />
              </div>
              <div className="field">
                <label className="label">Occupation</label>
                <select
                  id="job"
                  name="job"
                  value={eventData.job}
                  onChange={handleChange}
                >
                  <option value="">--- Select Occupation ---</option>
                  <option value="Headmaster">Headmaster</option>
                  <option value="Teacher">Teacher</option>
                  <option value="Tutor">Tutor</option>
                  <option value="Parent">Parent</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div className="field">
                <label className="label">School/Organization</label>
                <input
                  type="text"
                  autoComplete="on"
                  className="input"
                  id="company"
                  name="company"
                  value={eventData.company}
                  onChange={handleChange}
                  placeholder="School/Organization"
                />
              </div>
              <div className="field">
                <label className="label">Email</label>
                <input
                  type="text"
                  autoComplete="on"
                  className="input"
                  id="email"
                  name="email"
                  value={eventData.email}
                  onChange={handleChange}
                  placeholder="Email"
                  required
                />
              </div>
              <div className="field">
                <label className="label">Phone</label>
                <input
                  type="text"
                  autoComplete="on"
                  className="input"
                  id="phone"
                  name="phone"
                  value={eventData.phone}
                  onChange={handleChange}
                  placeholder="Phone"
                  required
                />
              </div>
              <div className="field">
                <label className="label">City</label>
                <input
                  type="text"
                  autoComplete="on"
                  className="input"
                  id="address"
                  name="address"
                  value={eventData.address}
                  onChange={handleChange}
                  placeholder="City"
                  required
                />
              </div>
              <div className="field">
                <label className="label">Payment Evidence</label>
                <input
                  type="file"
                  autoComplete="on"
                  className="input"
                  id="img"
                  name="img"
                  onChange={handleFile}
                  placeholder="Payment Evidence"
                />
              </div>
              <div className="section">
                <div className="controls">
                  <button type="button" onClick={resetEvent} className="btn">
                    Reset
                  </button>
                  <button type="submit" className="btn">
                    Join
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div className="section"></div>
      <div className="section"></div>
    </>
  );
}

export default EventPartyAdd;
