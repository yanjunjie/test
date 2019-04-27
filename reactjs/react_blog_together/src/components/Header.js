import React, {Component} from 'react';
import PropTypes from 'prop-types';

class Header extends Component {
    render() {
        return (
            <React.Fragment>
                {/*header*/}
                <header class="py-4">
                    <div class="container">
                        <div id="logo">
                            <h1> <a href="index.html"><span class="fa fa-cloud" aria-hidden="true"></span> Digital</a></h1>
                        </div>
                        {/*nav*/}
                        <nav class="d-lg-flex">

                            <label for="drop" class="toggle"><span class="fa fa-bars" aria-hidden="true"></span></label>
                            <input type="checkbox" id="drop" />
                            <ul class="menu mt-2 ml-auto">
                                <li class=""><a href="index.html">Home</a></li>
                                <li class=""><a href="#about">About</a></li>
                                <li class="">
                                    {/*First Tier Drop Down*/}
                                    <label for="drop-2" class="toggle">Dropdown <span class="fa fa-angle-down" aria-hidden="true"></span> </label>
                                    <a href="#">Dropdown <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                    <input type="checkbox" id="drop-2"/>
                                    <ul class="inner-ul">
                                        <li><a href="#process">Marketing Process</a></li>
                                        <li><a href="#portfolio">Portfolio</a></li>
                                        <li><a href="#partners">Partners</a></li>
                                    </ul>
                                </li>
                                <li class=""><a href="team.html">Team Page</a></li>
                                <li class=""><a href="contact.html">Contact Page</a></li>
                            </ul>
                            <div class="login-icon ml-lg-2">
                                <a class="user" href="#popup3"> Login</a>
                            </div>
                        </nav>
                        <div class="clear"></div>
                        {/*//nav*/}
                    </div>
                </header>
                {/*//header*/}

                {/*banner*/}
                <div class="banner" id="home">
                    <div class="container">
                        <div class="row banner-text">
                            <div class="slider-info col-lg-6">
                                <div class="banner-info-grid mt-lg-5">
                                    <h2>Welcome To Digital Marketing Agency </h2>
                                    <p>Integer pulvinar leo id viverra feugiat. Pellentesque libero justo, semper at tempus vel, ultrices in ligula.
                                        Nulla ut sollicitudin velit. Sed porttitor orci vel fermentum maximus. Curabitur ut turpis massa.</p>
                                </div>
                                <a class="btn mr-2 text-capitalize" href="#popup1">read more </a>
                                <a class="btn text-capitalize" href="#popup2">watch video </a>
                            </div>
                            <div class="col-lg-6 col-md-8 mt-lg-0 mt-sm-5 mt-3 banner-image text-lg-center">
                                <img src="images/bannerpng.png" alt="" class="img-fluid"/>
                            </div>
                        </div>
                    </div>
                </div>
                {/*//banner*/}
            </React.Fragment>
        );
    }
}

Header.propTypes = {};

export default Header;
