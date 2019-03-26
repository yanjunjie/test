import React, {Component} from 'react';
import {BrowserRouter as Router, Route, Link, NavLink, Redirect, Switch,withRouter} from "react-router-dom";
//import Route from 'react-router-dom/Route';
import {Home} from "./components/Home";
import {About} from "./components/About";
import {Contact} from "./components/Contact";
import {Products} from "./components/Products";

class Web extends Component {
    render() {
        return (
            <Router>
                <Switch>
                    <Route path={"/"} exact strict component={Home}/>
                    <Route path={"/products"} exact strict component={Products}/>
                    <Route path={"/about"} exact strict component={About}/>
                    <Route path={"/contact"} exact strict component={Contact}/>
                    <Route path={"/something"} exact strict render={
                        () => {
                            return (<h1>This is something page</h1>);
                        }
                    }/>
                </Switch>
            </Router>
        );
    }
}

export default Web;