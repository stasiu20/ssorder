import LoginForm from '../user/components/loginForm';
import { render } from 'react-dom';
import SSOrderApp from '../core/components/SSOrderApp';
import React from 'react';
import { HashRouter as Router, Switch, Route, Link } from 'react-router-dom';
import ProtectedRoute from '../core/components/protectedRouter';
import PageLogin from './components/pageLogin';
import RestaurantsFetch from '../restaurant/components/restaurantsFetch';
import PageRestaurantMenu from './components/pageRestaurantMenu';
import PageMakeOrder from './components/pageMakeOrder';
import InitPWA from './components/initPwa';
import AppNavbar from './components/navbar';
import ToggleNavbarOnScroll from './components/toggleNavbarOnScroll';

$(function() {
    const $el = $('#react-pwa');

    render(
        <>
            <AppNavbar />
        </>,
        document.getElementById('react-navbar'),
    );

    render(
        <SSOrderApp>
            <ToggleNavbarOnScroll />
            <Router>
                <InitPWA>
                    <Switch>
                        <Route path="/login">
                            <PageLogin />
                        </Route>
                        <ProtectedRoute path="/order/:foodId" exact>
                            <PageMakeOrder />
                        </ProtectedRoute>
                        <ProtectedRoute path="/menu/:restaurant" exact>
                            <PageRestaurantMenu />
                        </ProtectedRoute>
                        <ProtectedRoute path="/">
                            <h2 className="text-center mb-4">
                                To co dziś zamawiamy?!
                            </h2>
                            <RestaurantsFetch />
                        </ProtectedRoute>
                    </Switch>
                </InitPWA>
            </Router>
        </SSOrderApp>,
        $el.get(0),
    );
});
