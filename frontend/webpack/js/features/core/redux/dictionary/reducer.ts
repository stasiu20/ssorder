// import update from 'immutability-helper';
import { Reducer } from 'redux';
import { ACTIONS_DICT, DictionaryActions, DictionaryState } from './types';

// eslint-disable-next-line @typescript-eslint/no-empty-function,@typescript-eslint/no-unused-vars
const neverReached = (never: never): void => {};

const initialState: DictionaryState = {
    restaurantCategories: {},
};

const reducer: Reducer<DictionaryState, DictionaryActions> = (
    state = initialState,
    action,
) => {
    switch (action.type) {
        case ACTIONS_DICT.SET_RESTAURANT_CAT:
            return { ...state, restaurantCategories: action.categories };
        default:
            return state;
        // neverReached(action);
        // break;
    }
};

export default reducer;
