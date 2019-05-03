import {browser, by, element} from "protractor";
import {OrderListPageObject} from "./OrderListPageObject.po";

export class OrderRemarkPageObject {
    async sendOrderRemark(remarkText: string) {
        const elementOrderRemarks = element(by.id('order-uwagi'));
        await elementOrderRemarks.sendKeys(remarkText);
        await elementOrderRemarks.submit();

        await browser.driver.wait(function () {
            return browser.driver.getCurrentUrl().then(function (url) {
                return new RegExp('/order/index').test(url);
            });
        }, 10000, 'I am not at order index page');

        return new OrderListPageObject();
    }
}
