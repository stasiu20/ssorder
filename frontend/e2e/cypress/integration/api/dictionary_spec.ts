describe('Dictionary', () => {
    it('Restaurant categories', () => {
        cy.getAuthToken(Cypress.env('user').username, Cypress.env('user').password).then(token => {
            cy.request({
                url: '/v1/dictionaries/categories',
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
            }).then((response) => {
                expect(response.status).equal(200);

                const body = response.body.data;
                expect(body).to.be.a('array');
                expect(body[0]).to.be.a('object');
                expect(body[0]).to.have.property('id').and.to.be.a('number');
                expect(body[0]).to.have.property('name').and.to.be.a('string');
            });
        });
    })
})
