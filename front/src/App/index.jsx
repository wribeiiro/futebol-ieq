import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Menu from "./components/Menu";
import Payment from "./components/Pages/Payment";
import Home from "./components/Pages/Home";
import NotFound from "./components/Pages/NotFound";
import SquadBuilder from "./components/Pages/SquadBuilder";
import Matches from "./components/Pages/Matches";
import Profile from "./components/Pages/Profile";
import './style.css';

const App = () => {
    return (
        <Router basename={'futebol-ieq/frontend'}>
            <Menu />
            <Routes>
                <Route path="/" element={<Payment />} />
                <Route path="/home" element={<Home />} />
                <Route path="/payment" element={<Payment />} />
                <Route path="/matches" element={<Matches />} />
                <Route path="/squad-builder" element={<SquadBuilder />} />
                <Route path="/profile" element={<Profile />} />
                <Route path="*" element={<NotFound />} />
            </Routes>
        </Router>
    );
};

export default App;
