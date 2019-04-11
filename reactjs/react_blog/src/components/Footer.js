import React, {Component} from 'react';
class Footer extends Component {
    render() {
        return (
            <React.Fragment>
                {/*footer*/}
                <footer class="footer-emp-w3ls py-5">
                    <div class="container pt-lg-3">
                        <div class="row footer-top">
                            <div class="col-lg-4 col-sm-6 footer-grid-wthree">
                                <h4 class="footer-title text-uppercase mb-4">Who We Are</h4>
                                <div class="contact-info">
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium ipsum doloremque elit laudantium, totam rem
                                        aperiam, eaque ipsa quae. Excepteur ut occaecat proident, sunt voluptatem et accusantium doloremque elit dolor sit amet.</p>
                                    <h4 class="mt-3">Trusted by more than 1000+ people</h4>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 footer-grid-wthree mt-sm-0 mt-4">
                                <h3 class="footer-title text-uppercase mb-4">Latest News</h3>
                                <div class="contact-info">
                                    <div class="footer-style-w3ls">
                                        <h4 class="mb-2"><span class="fa mr-1 fa-twitter"></span> Sed ut piciatis unde natus</h4>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit volupta....</p>
                                        <p class="date">23 Nov 2018.</p>
                                    </div>
                                    <div class="footer-style-w3ls mt-3">
                                        <h4 class="mb-2"><span class="fa mr-1 fa-twitter"></span> Modi tempra incunt sit</h4>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit volupta....</p>
                                        <p class="date">24 Nov 2018.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 footer-grid-wthree mt-lg-0 mt-sm-5 mt-4">
                                <h3 class="footer-title text-uppercase mb-4">Contact Us</h3>
                                <div class="contact-info">
                                    <div class="footer-style-w3ls">
                                        <h4 class="mb-2"> <span class="fa mr-1 fa-map-marker"></span> Location</h4>
                                        <p>Marketing Agency, 5th cross, 4th building, New York City.</p>
                                    </div>
                                    <div class="footer-style-w3ls my-3">
                                        <h4 class="mb-2"><span class="fa mr-1 fa-phone"></span> Phone</h4>
                                        <p>+121 098 8907 9987</p>
                                    </div>
                                    <div class="footer-style-w3ls">
                                        <h4 class="mb-2"><span class="fa mr-1 fa-envelope-open"></span> Email</h4>
                                        <p><a href="mailto:info@example.com">info@example.com</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 footer-grid-wthree mt-lg-0 mt-sm-5 mt-4">
                                <h3 class="footer-title text-uppercase mb-4">Quick Links</h3>
                                <ul class="links list-unstyled">
                                    <li>
                                        <a class="" href="#home"> Home</a>
                                    </li>
                                    <li>
                                        <a class="" href="#about"> About Us</a>
                                    </li>
                                    <li>
                                        <a class="" href="#services"> Services</a>
                                    </li>
                                    <li>
                                        <a class="" href="#process">Process</a>
                                    </li>
                                    <li>
                                        <a class="" href="#portfolio">Portfolio</a>
                                    </li>
                                    <li>
                                        <a class="" href="contact.html">Contact us</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
                {/*//footer*/}
            </React.Fragment>
        );
    }
}

Footer.propTypes = {};

export default Footer;
