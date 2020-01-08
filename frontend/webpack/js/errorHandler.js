/* global ga */
import ErrorStackParser from 'error-stack-parser';

window.addEventListener('error', function(e) {
    e.preventDefault();
    const { message, filename, lineno, colno, error } = e;
    let stack = null;
    if (error && error instanceof Error) {
        stack = ErrorStackParser.parse(error) || [];
    }
    const userAgent = navigator.userAgent;
    const errorObj = { message, filename, lineno, colno, stack, userAgent };
    console.error(errorObj);
    ga('send', 'exception', {
        exDescription: JSON.stringify(errorObj),
        exFatal: true,
    });
    ga(
        'send',
        'event',
        'window.error',
        message,
        JSON.stringify(errorObj),
        undefined,
        { NonInteraction: 1 },
    );
});
