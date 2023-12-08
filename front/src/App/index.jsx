import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Menu from "./components/Menu";
import Payment from "./components/Pages/Payment";
import Home from "./components/Pages/Home";
import NotFound from "./components/Pages/NotFound";
import SquadBuilder from "./components/Pages/SquadBuilder";
import './style.css';

const App = () => {
    return (
        <Router>
            <Menu />
            <Routes>
                <Route path="/" element={<Payment />} />
                <Route path="/home" element={<Home />} />
                <Route path="/payment" element={<Payment />} />
                <Route path="/matches" element={<Home />} />
                <Route path="/squad-builder" element={<SquadBuilder />} />
                <Route path="*" element={<NotFound />} />
            </Routes>
        </Router>
    );
};

export default App;
