import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import { RouteProps } from 'react-router';
import { useServiceContainer } from '../context/serviceContainer';

const ProtectedRoute: React.FC<RouteProps> = props => {
    const container = useServiceContainer();
    const { children, ...rest } = props;
    return (
        <Route
            {...rest}
            render={({ location }): React.ReactNode =>
                container.authTokenService.isAuthenticated() ? (
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
