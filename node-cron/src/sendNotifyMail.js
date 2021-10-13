const logger = require('./winston');
const initSentry = require('./sentry');
const Sentry = require("@sentry/node");

async function addSendNotifyMailTaskToQueue(client) {
    const date = new Date();
    const QUEUE_ID = await client.incr('queue.message_id');
    try {
        await client.multi()
            .hset('queue.messages', QUEUE_ID, `300;${JSON.stringify({
                class: '\\common\\jobs\\RateOrders',
                date: `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
            })}`)
            .lpush('queue.waiting', QUEUE_ID)
            .exec();
    } catch (e) {
        logger.error(e);
        throw Error("Can't add task to queue");
    }
}

async function decoratedBySentry(client) {
    initSentry();
    const transaction = Sentry.startTransaction({
        op: "addSendNotifyMailTaskToQueue",
        name: "Transaction addSendNotifyMailTaskToQueue",
    });

    try {
        await addSendNotifyMailTaskToQueue(client);
    } catch (e) {
        logger.error(e);
        Sentry.captureException(e);
    } finally {
        transaction.finish();
    }
}

module.exports = decoratedBySentry;
