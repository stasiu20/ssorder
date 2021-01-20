export class RestaurantPage {
    submitForm(restaurantName: string) {
        cy.get('input[name="restaurantName"]').type(restaurantName);
        cy.get('input[name="tel_number"]').type('222253554');
        cy.get('input[name="delivery_price"]').type('2.5');
        cy.get('input[name="pack_price"]').type('0.5');
        cy.get('select[name="categoryId"]').select('polak');
        cy.get('#react-restaurant-form button[type="submit"]').click();
    }

    uploadImage() {
        cy.get('vaadin-upload').shadow().find('input[type="file"]').attachFile('cy.png');
        cy.get('#react-restaurant-form button[type="submit"]').click();
    }
}

export const onRestaurantPage = new RestaurantPage();
