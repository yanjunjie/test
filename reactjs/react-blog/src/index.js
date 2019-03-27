import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import './Style.css';
import {BrowserRouter as Router, Route, Link, NavLink, Redirect, Switch} from "react-router-dom";
import App from './App';
import * as serviceWorker from './serviceWorker';
import Header from "./components/Header";
import Footer from "./components/Footer";
import Web from "./Web";


ReactDOM.render(
    <Router>
        <React.Fragment>
            <Header />
            <Web />
            <Footer />
        </React.Fragment>
    </Router>
    , document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
//serviceWorker.unregister();
serviceWorker.register();
