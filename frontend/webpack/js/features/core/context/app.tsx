import React from 'react';
import { IntlShape, MessageDescriptor, useIntl } from 'react-intl';

interface AppContextType {
    translate: (messageId: string) => string;
    translateMsgDescriptor: (message: MessageDescriptor) => string;
}

function factoryAppContext(intl: IntlShape): AppContextType {
    return {
        translate: (id): string => intl.formatMessage({ id }),
        translateMsgDescriptor: (message): string =>
            intl.formatMessage(message),
    };
}

const AppContext = React.createContext<AppContextType | null>(null);

const AppCtxProvider: React.FC = ({ children }) => {
    const intl = useIntl();
    const ctx = factoryAppContext(intl);

    return <AppContext.Provider value={ctx}>{children}</AppContext.Provider>;
};

function useAppCtx(): AppContextType {
    const context = React.useContext(AppContext);
    if (context === undefined) {
        throw new Error('useAppCtx must be used within a AppCtxProvider');
    }
    return context;
}

export { AppCtxProvider, useAppCtx };
