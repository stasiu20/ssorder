const messages: Record<string, string> = {
    Required: 'Pole wymagane',
    PhoneInvalid: 'Numer telefonu jest niepoprawny',
    wrongPrice: 'Niepoprawna cena',
    InvalidRestaurantName: 'Niepoprawna nazwa restauracji',
    InvalidEmail: 'Niepoprawny adres email',
    InvalidRocketChatId: 'Niepoprawny numer rocket chat',
    InvalidPasswordTooLong: 'Hasło zbyt długie',
    InvalidPasswordTooShort: 'Hasło zbyt krótkie',
};

export function getMessages(): Readonly<Record<string, string>> {
    return messages;
}

export function addMessage(id: string, message: string): void {
    messages[id] = message;
}

export function addMessages(messages: Record<string, string>): void {
    Object.entries(messages).forEach(([key, value]) => {
        addMessage(key, value);
    });
}
