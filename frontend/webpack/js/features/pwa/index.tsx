import LoginForm from '../user/components/loginForm';
import { render } from 'react-dom';
import SSOrderApp from '../core/components/SSOrderApp';
import React from 'react';
import { HashRouter as Router, Switch, Route, Link } from 'react-router-dom';
import ProtectedRoute from '../core/components/protectedRouter';
import PageLogin from './components/pageLogin';
import RestaurantsFetch from '../restaurant/components/restaurantsFetch';

$(function() {
    const $el = $('#react-pwa');

    render(
        <SSOrderApp>
            <Router>
                <Switch>
                    <Route path="/login">
                        <PageLogin />
                    </Route>
                    <ProtectedRoute path="/">
                        <h2 className="text-center mb-4">
                            To co dziś zamawiamy?!
                        </h2>
                        <RestaurantsFetch />
                    </ProtectedRoute>
                </Switch>
            </Router>
        </SSOrderApp>,
        $el.get(0),
    );
});
