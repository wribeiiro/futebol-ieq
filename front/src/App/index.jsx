import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Menu from "./components/Menu";
import Payment from "./components/Pages/Payment";
import Home from "./components/Pages/Home";
import NotFound from "./components/Pages/NotFound";

const App = () => {
    return (
        <Router>
            <Menu />
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/home" element={<Home />} />
                <Route path="/payment" element={<Payment />} />
                <Route path="*" element={<NotFound />} />
            </Routes>
        </Router>
    );
};

export default App;
