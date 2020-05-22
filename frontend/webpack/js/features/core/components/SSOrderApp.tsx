import React from 'react';
import ErrorBoundary from './errorBoundary';
import { Provider } from 'react-redux';
import { store } from '../redux';

const SSOrderApp: React.FC = props => {
    return (
        <React.StrictMode>
            <ErrorBoundary>
                <Provider store={store}>{props.children}</Provider>
            </ErrorBoundary>
        </React.StrictMode>
    );
};

export default SSOrderApp;
