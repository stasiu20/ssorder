export class OrderPage {
    confirmOrder(remarkText) {
        cy.get('#order-uwagi')
            .type(remarkText)
            .parents('form')
            .find('button[type="submit"]')
            .click();
        cy.location('pathname').should('eq', '/order/index');

    }
}

export const onOrderPage = new OrderPage();
