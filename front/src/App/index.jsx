import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Menu from "./components/Menu";
import Payment from "./components/Pages/Payment";
import Home from "./components/Pages/Home";
import NotFound from "./components/Pages/NotFound";
import Pages from "./components/Pages";

const App = () => {
    return (
        <Router>
            <Menu />
            <Routes>
                <Route path="/" element={<Pages><Home /></Pages>} />
                <Route path="/home" element={<Pages><Home /></Pages>} />
                <Route path="/payment" element={<Pages><Payment /></Pages>} />
                <Route path="*" element={<Pages><NotFound /></Pages>} />
            </Routes>
        </Router>
    );
};

export default App;
