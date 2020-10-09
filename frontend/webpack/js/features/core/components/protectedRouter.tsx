import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import { RouteProps } from 'react-router';
import authTokenService from '../services/authTokenService';

const ProtectedRoute: React.FC<RouteProps> = props => {
    const { children, ...rest } = props;
    return (
        <Route
            {...rest}
            render={({ location }): React.ReactNode =>
                authTokenService.isAuthenticated() ? (
                    children
                ) : (
                    <Redirect
                        to={{
                            pathname: '/login',
                            state: { from: location },
                        }}
                    />
                )
            }
        />
    );
};

export default ProtectedRoute;
