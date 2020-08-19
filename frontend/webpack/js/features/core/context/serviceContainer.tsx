import React from 'react';
import ApiService from '../services/ApiService';
import authTokenService, {
    AuthTokenService,
} from '../services/authTokenService';
import HttpService from '../services/httpService';

interface AppServiceContainer {
    apiService: ApiService;
    authTokenService: AuthTokenService;
}

function factoryServiceContainer(): AppServiceContainer {
    const apiService = new ApiService(new HttpService(), authTokenService);
    return {
        apiService,
        authTokenService: authTokenService,
    };
}

const ServiceContainerContext = React.createContext<
    AppServiceContainer | undefined
>(undefined);

const ServiceContainerCtxProvider: React.FC = ({ children }) => {
    const ctx = factoryServiceContainer();

    return (
        <ServiceContainerContext.Provider value={ctx}>
            {children}
        </ServiceContainerContext.Provider>
    );
};

function useServiceContainer(): AppServiceContainer {
    const context = React.useContext(ServiceContainerContext);
    if (context === undefined) {
        throw new Error(
            'useServiceContainer must be used within a ServiceContainerCtxProvider',
        );
    }
    return context;
}

export { ServiceContainerCtxProvider, useServiceContainer };
