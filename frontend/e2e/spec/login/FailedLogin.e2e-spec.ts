import {browser} from "protractor";
import {LoginPageObject} from "../../page/LoginPageObject.po";

describe('ssorder failed login page', function() {
    let page: LoginPageObject;

    beforeEach(async () => {
        page = new LoginPageObject();
        await page.goToLoginPage();
    });

    it('should display error message if wrong password', async function() {
        await page.fillLoginForm('sonia.baran', 'wrongpassword');
        await page.submitLoginForm();

        const login = page.getLoginErrorElement();
        const isDisplayLoginFormError = browser.ExpectedConditions.textToBePresentInElement(login, 'Niepoprawny login lub hasło.');
        return browser.wait(isDisplayLoginFormError, 10000, 'Login form error not present');
    });
});
