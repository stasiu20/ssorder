export type KEYS =
    | 'update'
    | 'newPassword'
    | 'rocketchatId'
    | 'email'
    | 'error'
    | 'saved'
    | 'invalidEmail'
    | 'invalidRocketChatId'
    | 'passwordTooShort'
    | 'passwordTooLong';

const messages: Readonly<Record<KEYS, string>> = {
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
};
export default messages;
