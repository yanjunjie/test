import React, { Component } from 'react';
import logo from '../logo.jpg';
import {NavLink} from "react-router-dom";
//import '../Style.css'

class Header extends Component {
    render() {
        return(
            <header className={'header_area'}>
                <div className="container">
                    <div className="logo">
                        <a href="/"><img src={logo} alt="logo"/></a>
                    </div>
                    <nav className={'main_nav'}>
                        <ul>
                            <li><NavLink to="/" activeStyle={{color:"green"}} exact>Home</NavLink></li>
                            <li><NavLink to="/products" activeStyle={{color:"green"}} exact>Products</NavLink></li>
                            <li><NavLink to="/about" activeStyle={{color:"green"}} exact>About</NavLink></li>
                            <li><NavLink to="/contact" activeStyle={{color:"green"}} exact>Contact</NavLink></li>
                        </ul>
                    </nav>
                    <div className="float_clear"></div>
                </div>
            </header>
        );
    }
}

export default Header;
