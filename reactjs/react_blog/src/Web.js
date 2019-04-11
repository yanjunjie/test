import React, {Component} from 'react';
import {Route, Switch} from "react-router-dom";
import {Home} from "./components/Home";
import {About} from "./components/About";
import {Contact} from "./components/Contact";
import {Products} from "./components/Products";
import ReduxTest from "./components/reduxTest";

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
                <ReduxTest/>
            </div>
        );
    }
}

export default Web;