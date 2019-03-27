import React, {Component} from 'react';
import {BrowserRouter as Router, Route, Link, NavLink, Redirect, Switch} from "react-router-dom";
import {Home} from "./components/Home";
import {About} from "./components/About";
import {Contact} from "./components/Contact";
import {Products} from "./components/Products";

class Web extends Component {
    render() {
        return (
            <div>
                <Switch>
                    <Route path={"/"} exact component={Home}/>
                    <Route path={"/products"} component={Products}/>
                    <Route path={"/about"} component={About}/>
                    <Route path={"/contact"} component={Contact}/>
                    <Route path={"/something"} render={
                        () => {
                            return (<h1>This is something page</h1>);
                        }
                    }/>
                </Switch>
            </div>
        );
    }
}

export default Web;