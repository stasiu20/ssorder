const messages: Record<string, string> = {
    Required: 'Pole wymagane',
    PhoneInvalid: 'Numer telefonu jest niepoprawny',
    wrongPrice: 'Niepoprawna cena',
    InvalidRestaurantName: 'Niepoprawna nazwa restauracji',
    InvalidEmail: 'Niepoprawny adres email',
    InvalidRocketChatId: 'Niepoprawny numer rocket chat',
    InvalidPasswordTooLong: 'Hasło zbyt długie',
    InvalidPasswordTooShort: 'Hasło zbyt krótkie',

    update: 'Aktualizuj',
    newPassword: 'Nowe hasło',
    rocketchatId: 'Rocketchat ID',
    email: 'Email',
    error: 'Błąd podczas zapisu',
    saved: 'Zapisano',
    invalidEmail: 'Niepoprawny adres email',
    invalidRocketChatId: 'Niepoprawny numer rocketchar',
    passwordTooShort: 'Zbyt krótkie hasło',
    passwordTooLong: 'Zbyt długie hasło',

    Details: 'Szczegóły',
    Order: 'Zamów',

    restaurantSaved: 'Restauracja zapisana',
    restaurantName: 'Nazwa restauracji',
    phoneNumber: 'Numer telefonu',
    deliveryPrice: 'Cena dostawy',
    packPrice: 'Cena opakowania',
    chooseCategory: 'Wybierz kategorię',
    category: 'Kategoria',
    save: 'Zapisz',
};

export function getMessages(): Readonly<Record<string, string>> {
    return messages;
}
