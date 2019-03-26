import React, {Component} from 'react';
import '../Style.css';

class Footer extends Component{
    render() {
        return (
            <footer className={'footer_area'}>
                <div className="container footer">
                    <p>Copy Right &copy; 2019, All Rights Reserved</p>
                </div>
            </footer>
        );
    }
}

export default Footer;
