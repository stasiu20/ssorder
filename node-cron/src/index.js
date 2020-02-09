const cron = require('node-cron');
const shell = require('shelljs');

cron.schedule('20 8 * * *', () => {
    shell.exec('php /var/www/html/yii task/send-mail-with-rating-link', function taskSendMailWithRatingLink(code, stdout, stderr) {
        if (code !== 0) {
            console.error('Task task/send-mail-with-rating-link failed');
            console.error('Program output:', stdout);
            console.error('Program stderr:', stderr);
        }
    });
});
