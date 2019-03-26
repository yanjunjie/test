import React, { Component } from 'react';
import logo from '../logo.jpg';
import '../Style.css'

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
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Products</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </nav>
                    <div className="float_clear"></div>
                </div>
            </header>
        );
    }
}

export default Header;
