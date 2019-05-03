import {beforeEach} from "selenium-webdriver/testing";
import {HomePageObject} from "../../page/HomePageObject.po";

describe('New order', () => {
    let homePageObject: HomePageObject;

    beforeEach(async () => {
        homePageObject = new HomePageObject();
        await homePageObject.goToHomePage();
    });

    it('create', async () => {
        const remarkText = 'lorem ipsum' + (new Date()).getTime();

        const restaurantPageObject = await homePageObject.clickRestaurantLink('BurgeRoom');
        const orderRemarkPageObject = await restaurantPageObject.orderFood(72);
        const orderListPageObject = await orderRemarkPageObject.sendOrderRemark(remarkText);

        await orderListPageObject.searchOrderByRemark(remarkText);
    });
});
