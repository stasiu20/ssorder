describe('Restaurants', () => {
    it('List of restaurants', () => {
        cy.getAuthToken(Cypress.env('user').username, Cypress.env('user').password).then((token) => {
            cy.request({
                url: `/v1/restaurants/index`,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
            }).then((response) => {
                expect(response.status).to.equal(200);
                const body = response.body.data;

                expect(body).to.be.a('array');
                expect(body[0]).to.be.a('object');
                expect(body[0]).to.have.property('id').and.to.be.a('number');
                expect(body[0]).to.have.property('name').and.to.be.a('string');
                expect(body[0]).to.have.property('telNumber').and.to.be.a('string');
                expect(body[0]).to.have.property('deliveryPrice').and.to.be.a('number');
                expect(body[0]).to.have.property('packPrice').and.to.be.a('number');
                expect(body[0]).to.have.property('imageUrl').and.to.be.a('string');
                expect(body[0]).to.have.property('category').and.to.be.a('number');
            });
        });
    });

    it('Menu', () => {
        cy.getAuthToken(Cypress.env('user').username, Cypress.env('user').password).then((token) => {
            cy.request({
                url: `/v1/restaurants/${Cypress.env('restaurant').withMenu}/foods`,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
            }).then((response) => {
                expect(response.status).equal(200);
                expect(response.headers['X-Pagination-Current-Page'.toLowerCase()]).to.eql('1');
                expect(response.headers).to.have.property('X-Pagination-Page-Count'.toLocaleLowerCase());
                expect(response.headers).to.have.property('X-Pagination-Per-Page'.toLowerCase());
                expect(response.headers).to.have.property('X-Pagination-Total-Count'.toLocaleLowerCase());

                const body = response.body;
                expect(body).to.be.a('array');
                expect(body[0]).to.be.a('object');
                expect(body[0]).to.have.property('id').and.to.be.a('number');
                expect(body[0]).to.have.property('restaurantId').and.to.be.a('number');
                expect(body[0]).to.have.property('foodName').and.to.be.a('string');
                expect(body[0]).to.have.property('foodInfo').and.to.be.a('string');
                expect(body[0]).to.have.property('foodPrice').and.to.be.a('number');
            });
        });
    });
});
