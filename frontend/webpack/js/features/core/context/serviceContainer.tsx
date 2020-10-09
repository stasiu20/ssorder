import React from 'react';
import { AppServiceContainer, ContainerService } from '../ServiceContainer';

const ServiceContainerContext = React.createContext<
    AppServiceContainer | undefined
>(undefined);

const ServiceContainerCtxProvider: React.FC = ({ children }) => {
    return (
        <ServiceContainerContext.Provider value={ContainerService}>
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
