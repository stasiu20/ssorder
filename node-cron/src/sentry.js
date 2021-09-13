const nconf = require('nconf');
const Sentry = require("@sentry/node");
const Tracing = require("@sentry/tracing");

nconf.argv().env().file({file: __dirname + '/../config.json'});
const initSentry = () => {
    let executed = false;

    return function() {
        if (!executed) {
            executed = true;

            Sentry.init({
                dsn: nconf.get('SENTRY_DSN'),
                tracesSampleRate: 1.0,
            });
        }
    };
}

module.exports = initSentry();
