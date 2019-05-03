import {browser, by, element} from "protractor";
import {OrderRemarkPageObject} from "./OrderRemarkPageObject.po";

export class RestaurantPageObject {
    async orderFood(foodId: number) {
        const href = `/order/uwagi?id=${foodId}`;
        await element(by.css(`a[href="${href}"]`)).click();
        await browser.driver.wait(function () {
            return browser.driver.getCurrentUrl().then(function (url) {
                return new RegExp('/order/uwagi').test(url);
            });
        }, 10000, 'I cant find order link');

        return new OrderRemarkPageObject();
    }
}
