export class HomePage {
    makeOrder(restaurantName: string, foodId: number) {
        cy.contains(restaurantName).parents('.col-xs-12').contains('Zamów').click({ force: true });
        cy.location('pathname').should('eq', '/restaurants/details');
        cy.get(`tr[data-key="${foodId}"]`).contains('restaurant').click();
        cy.location('pathname').should('eq', '/order/uwagi');
    }
}

export const onHomePage = new HomePage();
