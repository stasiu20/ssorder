import ErrorStackParser from 'error-stack-parser';

window.addEventListener('error', function(e) {
    const { message, filename, lineno, colno, error } = e;
    let stack = null;
    if (error && error instanceof Error) {
        stack = ErrorStackParser.parse(error) || [];
    }
    const userAgent = navigator.userAgent;
    const errorObj = { message, filename, lineno, colno, stack, userAgent };
    const blob = new Blob([JSON.stringify(errorObj)], {
        type: 'application/json',
    });
    navigator.sendBeacon('/error/reporting', blob);
});
