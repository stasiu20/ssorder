import React from 'react';
import { ErrorBoundary, FallbackProps } from 'react-error-boundary';

const ErrorFallback: React.FC<FallbackProps> = ({ error }) => {
    return (
        <div role="alert">
            <p>Something went wrong:</p>
            <pre>{error?.message}</pre>
            <pre>{error?.stack}</pre>
        </div>
    );
};

const AppErrorBoundary: React.FC<{}> = props => {
    return (
        <ErrorBoundary
            FallbackComponent={ErrorFallback}
            onError={(error, info): void => console.error(error, info)}
        >
            {props.children}
        </ErrorBoundary>
    );
};

export default AppErrorBoundary;
