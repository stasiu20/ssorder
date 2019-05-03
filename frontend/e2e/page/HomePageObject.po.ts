import {browser, by, element} from "protractor";
import {RestaurantPageObject} from "./RestaurantPageObject.po";

export class HomePageObject {
    async goToHomePage() {
        await browser.waitForAngularEnabled(false);
        await browser.get('/');

        await browser.driver.wait(function () {
            return browser.driver.getCurrentUrl().then(function (url) {
                return browser.baseUrl + '/' === url;
            });
        }, 10000);
    }

    async clickRestaurantLink(linkText: string) {
        await element(by.linkText(linkText)).click();
        await browser.driver.wait(function () {
            return browser.driver.getCurrentUrl().then(function (url) {
                return new RegExp('/site/restaurant').test(url);
            });
        }, 10000, 'I am not at restaurant page');

        return new RestaurantPageObject();
    }
}
