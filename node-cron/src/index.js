const cron = require('node-cron');
const RedisClient = require('./redis.js');
const addSendNotifyMailTaskToQueue = require('./sendNotifyMail.js');
const logger = require('./winston');

cron.schedule('20 8 * * *', async () => {
    try {
        await addSendNotifyMailTaskToQueue(RedisClient);
        logger.info('Task to send notification mail finished')
    } catch (e) {
        logger.error(e);
    }
});
