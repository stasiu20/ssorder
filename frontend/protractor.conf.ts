import {browser, Config} from "protractor";
import {LoginPageObject} from "./e2e/page/LoginPageObject.po";

export let config: Config = {
    framework: 'jasmine',
    directConnect: true,
    baseUrl: 'http://ssorder.lvh.me',
    SELENIUM_PROMISE_MANAGER: false,
    specs: ['e2e/spec/**/*.e2e-spec.ts'],
    exclude: ['e2e/spec/login/FailedLogin.e2e-spec.ts'],
    'onPrepare': async () => {
        require('ts-node/dist/index').register({
            project: 'e2e/tsconfig.json'
        });

        let page: LoginPageObject = new LoginPageObject();
        await page.goToLoginPage();
        await page.fillLoginForm('sonia.baran', 'password');
        await page.submitLoginForm();

        return browser.driver.wait(function() {
            return browser.driver.getCurrentUrl().then(function(url) {
                return browser.baseUrl + '/' === url;
            });
        }, 10000);
    }
};
