import { navigator } from '../support/pageObject/Navigation'
import { onLoginPage } from '../support/pageObject/LoginPage';
import { onRestaurantPage } from '../support/pageObject/RestaurantPage';
import { onHomePage } from '../support/pageObject/HomePage';
import { onOrderPage } from '../support/pageObject/OrderPage';

describe('SSOrder', () => {
    it('Create order', () => {
        const dt = (new Date()).getTime();
        const remarks = `Testowe zamowienie przez cypress{enter}${dt}`;

        navigator.toSignInPage();
        onLoginPage.signIn(Cypress.env('user').username, Cypress.env('user').password);
        onHomePage.makeOrder(Cypress.env('order').restaurantName, Cypress.env('order').foodId);
        onOrderPage.confirmOrder(remarks);
        cy.contains(dt.toString());
    });

    it('Wrong password', () => {
        navigator.toSignInPage();
        onLoginPage.signIn(Cypress.env('user').username, 'wrongpassword123');

        cy.get('#loginform-password')
            .should('have.class', 'is-invalid')
            .parents('.form-group')
            .find('.invalid-feedback')
            .should('be.visible');
    });

    it('Add restaurant and upload image', () => {
        const restaurantName = 'lorem ipsum' + (new Date()).getTime();

        navigator.toSignInPage();
        onLoginPage.signIn(Cypress.env('user').username, Cypress.env('user').password);

        cy.location('pathname').should('eq', '/');
        cy.get('#navbar').contains('Dodaj Restaurację').click();
        cy.location('pathname').should('eq', '/restaurants/add');

        onRestaurantPage.submitForm(restaurantName);
        cy.location('pathname')
            .should('match', /\/restaurants\/[\d]+\/update/)
            .then(location => {
                const regex = /\/restaurants\/([\d]+)\/update/;
                const restaurantId = Number(location.match(regex)[1]);

                onRestaurantPage.uploadImage();
                onRestaurantPage.uploadDoneIcon().should('be.visible');

                navigator.toRestaurant(restaurantId);
                cy.location('pathname').should('match', /\/restaurants\/[\d]+/);

                cy.get('#react-restaurant-image')
                    .find('img')
                    .should('be.visible')
                    .and(($img) => expect($img[0].naturalWidth).to.be.greaterThan(0));
            });
    });
});
