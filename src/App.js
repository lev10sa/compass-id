// import router kit
import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import {
  Home,
  EventList,
  EventPartyAdd,
  PostList,
  PostEnView,
  PostIdView,
} from "./pages";
import { Navigation } from "./components";

const App = () => {
  return (
    <>
      <Router>
        <Navigation />
        <div className="main-page">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/events" element={<EventList />} />
            <Route path="/event-join/:id" element={<EventPartyAdd />} />
            <Route path="/posts" element={<PostList />} />
            <Route path="/post-view/en/:id" element={<PostEnView />} />
            <Route path="/post-view/id/:id" element={<PostIdView />} />
          </Routes>
        </div>
      </Router>
    </>
  );
};

export default App;
