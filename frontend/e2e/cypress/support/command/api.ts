Cypress.Commands.add('login', (username: string, password: string) => {
    return cy.request({
        url: '/v1/session/login',
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: {
            'userName': username,
            'password': password,
        },
    })
});

Cypress.Commands.add('getAuthToken', (username: string, password: string) => {
    return cy.login(username, password).its('body.data');
});
