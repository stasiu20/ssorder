import React, { Component, ErrorInfo } from 'react';
import ErrorStackParser from 'error-stack-parser';

/**
 * @link https://pl.reactjs.org/docs/error-boundaries.html
 * @link https://pl.reactjs.org/docs/hooks-faq.html#do-hooks-cover-all-use-cases-for-classes
 */
export default class ErrorBoundary extends Component<
    {},
    { hasError: boolean; error?: Error }
> {
    constructor(props) {
        super(props);
        this.state = { hasError: false };
    }

    static getDerivedStateFromError(error: Error) {
        return { hasError: true, error: error };
    }

    componentDidCatch(error, errorInfo) {
        console.error('ERROR:');
        console.error({ error, errorInfo });
        console.error(ErrorStackParser.parse(error));
    }

    render() {
        if (this.state.hasError) {
            return (
                <div>
                    <p>Something went wrong.</p>
                    {this.state.error && (
                        <p>Error message: {this.state.error.message}</p>
                    )}
                    {this.state.error &&
                        typeof this.state.error.stack === 'string' && (
                            <pre>{this.state.error.stack}</pre>
                        )}
                </div>
            );
        }

        return this.props.children;
    }
}
