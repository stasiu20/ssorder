import {by, element} from "protractor";

export class OrderListPageObject {
    async searchOrderByRemark(remarkText) {
        await element(by.cssContainingText('td', remarkText));
    }
}
