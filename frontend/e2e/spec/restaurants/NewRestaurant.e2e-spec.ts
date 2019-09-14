import {AddRestaurantPageObject} from "../../page/AddRestaurantPageObject.po";
import * as path from 'path';

describe('Add new restaurant', () => {
    let addRestaurantPage: AddRestaurantPageObject;

    beforeEach(async () => {
        addRestaurantPage = new AddRestaurantPageObject();
        await addRestaurantPage.gotToAddRestaurantPage();
    });

    it('Upload image', async () => {
        const restaurantName = 'lorem ipsum' + (new Date()).getTime();

        await addRestaurantPage.getRestaurantNameField().sendKeys(restaurantName);
        await addRestaurantPage.getRestaurantPhoneField().sendKeys('111222333');
        await addRestaurantPage.selectRestaurantCategory(4);
        await addRestaurantPage.getRestaurantImageField().sendKeys(path.resolve(__dirname, '../../assets/restaurantLogo.jpg'));
        const restaurantsIndexPage = await addRestaurantPage.submitLoginForm();
        const element = await restaurantsIndexPage.searchRestaurantByName(restaurantName);
        expect(await element.isPresent()).toBe(true);
        //todo: przejsc na strone restauracji i spr czy obrazek sie zaladowal
    });
});
