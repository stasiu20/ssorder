import React, { Component, ReactNode } from 'react';
import ErrorStackParser from 'error-stack-parser';

interface ErrorBoundaryState {
    hasError: boolean;
    error?: Error;
}

/**
 * @link https://pl.reactjs.org/docs/error-boundaries.html
 * @link https://pl.reactjs.org/docs/hooks-faq.html#do-hooks-cover-all-use-cases-for-classes
 */
export default class ErrorBoundary extends Component<{}, ErrorBoundaryState> {
    constructor(props) {
        super(props);
        this.state = { hasError: false };
    }

    static getDerivedStateFromError(error: Error): ErrorBoundaryState {
        return { hasError: true, error: error };
    }

    componentDidCatch(error, errorInfo): void {
        console.error('ERROR:');
        console.error({ error, errorInfo });
        console.error(ErrorStackParser.parse(error));
    }

    render(): ReactNode {
        if (this.state.hasError) {
            const error = this.state.error;
            return (
                <div>
                    <p>Something went wrong.</p>
                    {error && <p>Error message: {error.message}</p>}
                    {error && typeof error.stack === 'string' && (
                        <pre>{error.stack}</pre>
                    )}
                </div>
            );
        }

        return this.props.children;
    }
}
