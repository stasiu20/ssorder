describe('Rocketchat', () => {
    it('Help command', () => {
        cy.request({
            url: '/rocket-chat',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: {
                'token': Cypress.env('ROCKET_CHAT_BOT_TOKEN'),
                'bot': false,
                'channel_id': '6WqgZQx8nkS7vqnQrvBdeuRry3i5xknr6q',
                'channel_name': null,
                'message_id': 'Lx2Rry5vtA38NvRtc',
                'timestamp': '2019-10-04T17:17:46.298Z',
                'user_id': '6WqgZQx8nkS7vqnQr',
                'user_name': 'admin',
                'text': 'help',
            },
        }).then(response => {
            expect(response.status).to.eq(200);
            const body = response.body;

            expect(body).to.be.a('object');
            expect(body).to.have.property('text').and.to.be.a('string');
            expect(body.text).to.have.string('Dostępne polecenia to');
        });
    });

    it('info command', () => {
        cy.request({
            url: '/rocket-chat',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: {
                'token': Cypress.env('ROCKET_CHAT_BOT_TOKEN'),
                'bot': false,
                'channel_id': '6WqgZQx8nkS7vqnQrvBdeuRry3i5xknr6q',
                'channel_name': null,
                'message_id': 'Lx2Rry5vtA38NvRtc',
                'timestamp': '2019-10-04T17:17:46.298Z',
                'user_id': '6WqgZQx8nkS7vqnQr',
                'user_name': 'admin',
                'text': 'info',
            },
        }).then(response => {
            expect(response.status).to.eq(200);
            const body = response.body;

            expect(body).to.be.a('object');
            expect(body).to.have.property('text').and.to.be.a('string');
            expect(body.text).to.have.string('Nie masz integracji między ssorder');
        });
    });

    it('last order', () => {
        cy.request({
            url: '/rocket-chat',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: {
                'token': Cypress.env('ROCKET_CHAT_BOT_TOKEN'),
                'bot': false,
                'channel_id': '6WqgZQx8nkS7vqnQrvBdeuRry3i5xknr6q',
                'channel_name': null,
                'message_id': 'Lx2Rry5vtA38NvRtc',
                'timestamp': '2019-10-04T17:17:46.298Z',
                'user_id': '6WqgZQx8nkS7vqnQr',
                'user_name': 'admin',
                'text': 'last',
            },
        }).then(response => {
            expect(response.status).to.eq(200);
            const body = response.body;

            expect(body).to.be.a('object');
            expect(body).to.have.property('text').and.to.be.a('string');
            expect(body.text).to.have.string('Brak integracji z ssorder');
        });
    });
});
