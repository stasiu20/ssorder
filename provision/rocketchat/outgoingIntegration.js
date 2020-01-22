const RocketChatApi = require('rocketchat-api');
const envfile = require('envfile');
const path = require('path');
const fs = require('fs');
const url = require('url');

function getConfiguration(configDir) {
    const envFile = `${configDir}/.env`;
    const envDistFile = `${configDir}/env.dist`;

    let configuration = {};
    if (fs.existsSync(envFile)) {
        configuration = envfile.parseFileSync(envFile);
    } else if (fs.existsSync(envDistFile)) {
        configuration = envfile.parseFileSync(envDistFile);
    } else {
        throw new Error(`At "${configDir}" not exist neither .env or env.dist file`);
    }

    return configuration;
}

async function createOutgoingIntegration(rocketChatUrl) {
    const rocketChatApi = new RocketChatApi(rocketChatUrl.protocol, rocketChatUrl.hostname, rocketChatUrl.port);
    await rocketChatApi.authentication.login('admin', 'admin', async () => {
        await  rocketChatApi.users.create({
            "email": "ssorder@example.com",
            "name": "ssorder",
            "password": "ssorder",
            "username": "ssorder",
            "active": true,
            "roles": ['bot']
        });
        const response = await rocketChatApi.integration.create({
            "type": "webhook-outgoing",
            "name": "ssorder",
            "enabled": true,
            "username": "ssorder",
            "token": configuration.ROCKET_CHAT_BOT_TOKEN,
            "event": "sendMessage",
            "urls": ["http://ssorder.lvh.me/rocket-chat"],
            "scriptEnabled": false,
            "channel" : "@ssorder",
            "alias": "ssorder-bot",
        });
        if (!response.success) {
            console.error("Error during add rocket chat integration");
            process.exit(1);
        }
        process.exit(0);
    });
}

const configDir = path.normalize(__dirname) + '/../../';
const configuration = getConfiguration(configDir);
const rocketChatUrl = new url.URL(configuration['ROCKET_CHAT_ENDPOINT']);

createOutgoingIntegration(rocketChatUrl);
