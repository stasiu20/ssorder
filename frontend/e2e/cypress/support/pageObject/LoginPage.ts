export class LoginPage {
    signIn(userName: string, password: string): void {
        cy.get('#loginform-username').type(userName);
        cy.get('#loginform-password').type(password);
        cy.get('#login-form button[type="submit"]').click()
    }
}

export const onLoginPage = new LoginPage();
