import React from "react";
import {
    Routes, Route
} from "react-router-dom";

import Home from "../pages/Home/Home";
import Loyalty from "../pages/Loyalty/Index";

export default function RoutePath() {

    return (
        <>
            <Routes>
                <Route exact path='/' element={<Home />} />
                <Route exact path='/loyalty-program' element={<Loyalty />} />

            </Routes>
        </>
    )
}
