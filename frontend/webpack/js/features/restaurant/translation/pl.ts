export type KEYS =
    | 'error'
    | 'restaurantSaved'
    | 'restaurantName'
    | 'phoneNumber'
    | 'deliveryPrice'
    | 'packPrice'
    | 'chooseCategory'
    | 'category'
    | 'save';

const messages: Readonly<Record<KEYS, string>> = {
    error: 'Błąd podczas zapisu',
    restaurantSaved: 'Restauracja zapisana',
    restaurantName: 'Nazwa restauracji',
    phoneNumber: 'Numer telefonu',
    deliveryPrice: 'Cena dostawy',
    packPrice: 'Cena opakowania',
    chooseCategory: 'Wybierz kategorię',
    category: 'Kategoria',
    save: 'Zapisz',
};
export default messages;
