import { navigator } from '../support/pageObject/Navigation';
import { onLoginPage } from '../support/pageObject/LoginPage';

describe('PWA SSOrder', () => {
    it('Make an order', () => {
        const dt = (new Date()).getTime();
        const remarks = `Testowe zamowienie przez cypress/PWA{enter}${dt}`;

        cy.intercept('POST', '/v1/orders').as('order');
        cy.intercept('POST', '/site/login').as('login');

        cy.visit('/pwa');
        cy.get('input[name="username"]').type(Cypress.env('user').username);
        cy.get('input[name="password"]').type(Cypress.env('user').password);
        cy.get('button').contains('Sign in').click();

        cy.contains(Cypress.env('order').restaurantName).parents('.col-xs-12').contains('Zamów').click({ force: true });
        cy.get(`[href*="/order/${Cypress.env('order').foodId}"]`).contains('Zamów').click();
        cy.get('textarea[name="remarks"]').type(remarks)
        cy.get('button').contains('Order').click();

        cy.wait('@order');
        navigator.toSignInPage();
        cy.clearLocalStorage();
        onLoginPage.signIn(Cypress.env('user').username, Cypress.env('user').password);
        cy.wait('@login');
        cy.visit('/order/index');
        cy.contains(dt.toString());
    });
});
