import {by, element} from "protractor";

export default class RestaurantListPageObject {
    async searchRestaurantByName(restaurantName) {
        return element(by.cssContainingText('td', restaurantName));
    }
}
