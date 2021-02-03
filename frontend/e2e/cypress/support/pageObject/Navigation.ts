export class Navigator {
    toSignInPage(): void {
        cy.visit('/site/login');
    }

    toRestaurant(restaurantId: number) {
        cy.visit(`/restaurants/${restaurantId}`);
    }

    toEditRestaurant(restaurantId: number) {
        cy.visit(`/restaurants/${restaurantId}/update`);
    }

    isHomePage(): void {
        cy.location('pathname').should('eq', '/');
    }

    isSignInPage(): void {
        cy.location('pathname').should('eq', '/site/login');
    }
}

export const navigator = new Navigator();
