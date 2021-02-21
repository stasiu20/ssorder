describe('Order', () => {
    it('create a new order', () => {
        cy.getAuthToken(Cypress.env('user').username, Cypress.env('user').password).then((token) => {
            cy.request({
                url: `/v1/orders`,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: {
                    'foodId': Cypress.env('order').foodId,
                    'remarks': 'Without sauce',
                },
            }).then((response) => {
                expect(response.status).to.equal(201);
                const body = response.body.data;

                expect(body).to.be.a('object');
                expect(body).to.have.property('id').and.to.be.a('number');
                expect(body).to.have.property('foodId').and.to.equal(Cypress.env('order').foodId);
                expect(body).to.have.property('restaurantId').and.to.be.a('number');
            });
        });
    });
});
