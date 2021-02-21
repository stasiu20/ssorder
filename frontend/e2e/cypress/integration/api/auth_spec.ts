describe('Authorization', () => {
    it('login with wrong login/password', () => {
        cy.request({
            url: '/v1/session/login',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: {
                'userName': 'aa',
                'password': 'bbb',
            },
            failOnStatusCode: false,
        }).then((response) => {
            expect(response.status).equal(422);
            expect(response.body[0]).to.have.property('field').to.eql('userName');
            expect(response.body[0]).to.have.property('message').to.eql('Niepoprawny login lub hasło.');
        });
    });

    it('Success login', () => {
        cy.login(Cypress.env('user').username, Cypress.env('user').password)
            .then((response) => {
                expect(response.status).equal(200);
                expect(response.body).to.be.a('object');
                expect(response.body).to.have.property('type').to.eql('auth');
                expect(response.body).to.have.property('data').and.to.be.a('string');
            });
    });

    it('login with empty body', () => {
        cy.request({
            url: '/v1/session/login',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: {},
            failOnStatusCode: false,
        }).then((response) => {
            expect(response.status).equal(422);
            expect(response.body[0]).to.have.property('field').to.eql('userName');
            expect(response.body[0]).to.have.property('message').to.eql('User Name nie może pozostać bez wartości.');
            expect(response.body[1]).to.have.property('field').to.eql('password');
            expect(response.body[1]).to.have.property('message').to.eql('Password nie może pozostać bez wartości.');
        });
    });

    it('logout with invalid access token', () => {
        cy.request({
            url: '/v1/session/logout',
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer WRONG_TOKEN`,
            },
            failOnStatusCode: false,
        }).then((response) => {
            expect(response.status).equal(401);
        });
    });

    it('logout without access token', () => {
        cy.request({
            url: '/v1/session/logout',
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            failOnStatusCode: false,
        }).then((response) => {
            expect(response.status).equal(401);
        });
    });

    it('success logout', () => {
        cy.getAuthToken(Cypress.env('user').username, Cypress.env('user').password).then((token) => {
            cy.request({
                url: `/v1/session/logout`,
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
            }).then((response) => {
                expect(response.status).equal(204);
                expect(response.body).to.be.empty;
            });
        });
    })
});
