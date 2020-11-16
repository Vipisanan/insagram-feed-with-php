import React, {Component} from 'react';
import { BrowserRouter, Switch, Route, Redirect } from 'react-router-dom';
import {Scrollbars} from 'react-custom-scrollbars';
import publicRoute from "../rotues/publicRoute";
import NavBar from "./core/NavBar";
import Footer from "./core/Footer";
import 'bootstrap/dist/css/bootstrap.min.css';

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            path: '/',
        };
    }
    NoMatch = () => {
        return (
            <div>
                <h3>URL not found!!</h3>
            </div>
        );
    };
    publicRoute = (route, index) => {
        return (
            <Route
                key={index}
                path={route.path}
                component={route.component}
                exact={route.exact}
            />
        );
    };
    componentDidMount() {
        const wHeight = window.innerHeight;
        this.setState({path: window.location.pathname, scrollBar: wHeight});
    }

    render() {
        const {scrollBar} = this.state;
        return (
            <BrowserRouter>
                <Scrollbars autoHeightMax={scrollBar} autoHeight={true} {...this.props}>
                    <NavBar/>
                    <Switch>
                        {/*<Route*/}
                        {/*    key={'welcome'}*/}
                        {/*    exact*/}
                        {/*    path="/"*/}
                        {/*    component={auth ? Dashboard : Welcome}/>*/}
                        {publicRoute.map((route, index) => this.publicRoute(route, index))}
                        <Route path="*">{this.NoMatch}</Route>
                    </Switch>
                    <Footer/>
                </Scrollbars>
            </BrowserRouter>
        );
    }
}

export default App;
