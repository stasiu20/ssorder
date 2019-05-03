import {browser, by, element, ElementFinder} from "protractor";

export class LoginPageObject {
    private usernameElement: ElementFinder;
    private passwordElement: ElementFinder;
    private formElement: ElementFinder;

    constructor() {
        this.usernameElement = element(by.id('loginform-username'));
        this.passwordElement = element(by.id('loginform-password'));
        this.formElement = element(by.id('login-form'));
    }

    async goToLoginPage() {
        await browser.waitForAngularEnabled(false);
        await browser.get('/site/login');
    }

    async fillLoginForm(username: string, password: string) {
        await this.usernameElement.sendKeys(username);
        await this.passwordElement.sendKeys(password);
    }

    async submitLoginForm() {
        await this.formElement.submit();
    }

    getLoginErrorElement() {
        return element(by.css('div.form-group.field-loginform-password.has-error > p.help-block-error'));
    }
}
