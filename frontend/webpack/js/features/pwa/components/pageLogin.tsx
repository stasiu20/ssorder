import React from 'react';
import LoginForm from './loginForm';
import { Redirect } from 'react-router-dom';
import { useAuthStatus } from '../hooks';

const PageLogin: React.FC = () => {
    const isAuthenticated = useAuthStatus();
    return (
        <>
            {isAuthenticated ? (
                <Redirect
                    to={{
                        pathname: '/',
                    }}
                />
            ) : (
                <LoginForm
                    initialValues={{
                        username: '',
                        password: '',
                    }}
                />
            )}
        </>
    );
};

export default PageLogin;
