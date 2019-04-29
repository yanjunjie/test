import React, {Component} from 'react';

class Home extends Component {
    render() {
        return (
            <React.Fragment>
                <section class="about py-5" id="home">
                    <div class="container py-lg-5 py-sm-3">
                        <div class="row">
                            <div class="col-lg-3 about-left">
                                <h3 class="heading mb-lg-5 mb-4">Home</h3>
                            </div>
                            <div class="col-lg-5 col-md-7 about-text">
                                <h3>Welcome To Our Home Page </h3>
                                <p class="mt-3">Integer pulvinar leo id viverra feugiat. Pellentesque libero justo, semper at tempus vel, ultrices in ligula. Nulla uter sollicitudin velit. Sed porttitor orci vel ferm.</p>
                                <p class="mt-2">Integer pulvinar leo id viverra feugiat. Pellentesque libero justo, semper at tempus vel, ultrices in ligula. Nulla uter sollicitudin velit. Sed porttitor orci vel fermentum elit maximus. Curabitur ut turpis massa in condimentum libero. Pellentesque maximus.</p>
                            </div>
                            <div class="col-lg-4 col-md-5 about-img">
                                <img src="images/1.png" alt="" class="img-fluid"/>
                            </div>
                        </div>
                    </div>
                </section>
            </React.Fragment>
        );
    }
}

export default Home;