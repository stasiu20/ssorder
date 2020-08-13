import React from 'react';
import ErrorBoundary from './errorBoundary';
import { Provider } from 'react-redux';
import { store } from '../redux';
import { IntlProvider } from 'react-intl';
import { getMessages } from '../translations/pl';
import { AppCtxProvider } from '../context/app';
import { ServiceContainerCtxProvider } from '../context/serviceContainer';

const SSOrderApp: React.FC = props => {
    const messages = getMessages();
    return (
        <React.StrictMode>
            <ErrorBoundary>
                <Provider store={store}>
                    <ServiceContainerCtxProvider>
                        <IntlProvider locale={'pl'} messages={messages}>
                            <AppCtxProvider>{props.children}</AppCtxProvider>
                        </IntlProvider>
                    </ServiceContainerCtxProvider>
                </Provider>
            </ErrorBoundary>
        </React.StrictMode>
    );
};

export default SSOrderApp;
