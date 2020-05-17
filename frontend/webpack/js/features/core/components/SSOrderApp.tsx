import React from 'react';
import ErrorBoundary from './errorBoundary';

const SSOrderApp: React.FC = props => {
    return (
        <React.StrictMode>
            <ErrorBoundary>{props.children}</ErrorBoundary>
        </React.StrictMode>
    );
};

export default SSOrderApp;
