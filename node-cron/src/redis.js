const Redis = require('ioredis');
const nconf = require('nconf');

nconf.argv().env().file({file: __dirname + '/../config.json'});
const RedisClient = new Redis({
    port: nconf.get('REDIS_PORT'),
    host: nconf.get('REDIS_HOST'),
    db: nconf.get('REDIS_DB'),
});
RedisClient.on('error', err => {
    console.error('REDIS: FAILED');
    console.error(err);
    process.exit(1)
});
module.exports = RedisClient;
