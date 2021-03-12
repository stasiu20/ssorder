/// <reference types="cypress" />

declare namespace Cypress {
    interface Chainable {
        /**
         * A command to login a user
         *
         * @example cy.login('username', 'password')
         */
        login(userName: string, password: string): Chainable<Response>;

        /**
         * A command for receiving an access token
         */
        getAuthToken(userName: string, password: string): Chainable<string>;
    }
}
