import React, {Component} from 'react';
import {createStore} from "redux";

class ReduxTest extends Component {
    render() {

        // step 02: reducer (state n action)
        const reducer = function (state, action) {

            if (action.type === "ATTACK") {
                return action.payload;
            }
            if (action.type === "GREENATTACK") {
                return action.payload;
            }

            return state;
        };

        // step 01: store (reducer n state)
        const store = createStore(reducer, 'Peace');

        // step 03: Subscribe
        store.subscribe(()=>{
            console.log('Store is now', store.getState());
        });

        // step 04: dispatch action
        store.dispatch({type:'ATTACK', payload:'Iron Man'});
        store.dispatch({type:'GREENATTACK', payload:'Green Attack'});

        return (
            <div>

            </div>
        );
    }
}

export default ReduxTest;