export type KEYS = 'Details' | 'Order';

const messages: Readonly<Record<KEYS, string>> = {
    Details: 'Szczegóły',
    Order: 'Zamów',
};
export default messages;
