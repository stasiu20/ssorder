const addSendNotifyMailTaskToQueue = require('./sendNotifyMail.js');
const RedisClient = require('./redis.js');

async function run() {
    try {
        await addSendNotifyMailTaskToQueue(RedisClient);
        console.log('Task to send notification mail finished');
    } catch (e) {
        console.error(e);
    }
}
run();
