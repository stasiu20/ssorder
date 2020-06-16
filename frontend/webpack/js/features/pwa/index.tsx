import LoginForm from '../user/components/loginForm';
import { render } from 'react-dom';
import SSOrderApp from '../core/components/SSOrderApp';
import React from 'react';
import { HashRouter as Router, Switch, Route, Link } from 'react-router-dom';
import RestaurantCardsCollection from '../restaurant/components/restaurantCardCollection';
import ProtectedRoute from '../core/components/protectedRouter';

$(function() {
    const $el = $('#react-pwa');

    render(
        <SSOrderApp>
            <Router>
                <Switch>
                    <Route path="/login">
                        <LoginForm
                            initialValues={{
                                username: '',
                                password: '',
                            }}
                        />
                    </Route>
                    <ProtectedRoute path="/">
                        <h2 className="text-center mb-4">
                            To co dziś zamawiamy?!
                        </h2>
                        <RestaurantCardsCollection restaurants={[]} />
                    </ProtectedRoute>
                </Switch>
            </Router>
        </SSOrderApp>,
        $el.get(0),
    );
});
