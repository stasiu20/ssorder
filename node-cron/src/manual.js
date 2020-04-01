const addSendNotifyMailTaskToQueue = require('./sendNotifyMail.js');
const RedisClient = require('./redis.js');
const logger = require('./winston');

async function run() {
    try {
        await addSendNotifyMailTaskToQueue(RedisClient);
        logger.info('Task to send notification mail finished');
        RedisClient.disconnect();
    } catch (e) {
        logger.error(e);
    }
}
run();
