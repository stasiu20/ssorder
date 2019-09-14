import {browser, by, element} from "protractor";
import RestaurantListPageObject from "./RestaurantListPageObject.po";

export class AddRestaurantPageObject {
    async gotToAddRestaurantPage() {
        await browser.waitForAngularEnabled(false);
        await browser.get('/restaurants/upload');

        await browser.driver.wait(function () {
            return browser.driver.getCurrentUrl().then(function (url) {
                return browser.baseUrl + '/restaurants/upload' === url;
            });
        }, 10000);
    }

    getRestaurantNameField() {
        return element(by.id('restaurants-restaurantname'));
    }

    getRestaurantPhoneField() {
        return element(by.id('restaurants-tel_number'))
    }

    async selectRestaurantCategory(categoryId) {
        const select = element(by.id('restaurants-categoryid'));
        await select.click();
        await browser.sleep(1500);
        await select.$(`[value="${categoryId}"]`).click();
    }

    getRestaurantImageField() {
        return element(by.id('restaurants-imagefile'));
    }

    async submitLoginForm(): Promise<RestaurantListPageObject> {
        await element(by.id('w0')).submit();

        await browser.driver.wait(function () {
            return browser.driver.getCurrentUrl().then(function (url) {
                return new RegExp('/restaurants/index').test(url);
            });
        }, 10000, 'I am not at restaurants index page');

        return new RestaurantListPageObject();
    }
}
