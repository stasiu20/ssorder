import { ActionCreator } from 'redux';
import {
    ACTIONS_DICT,
    DictRestaurantCategories,
    SettingRestaurantCategoriesAction,
} from './types';

export const setRestaurantCategoriesActionCreator: ActionCreator<SettingRestaurantCategoriesAction> = (
    categories: DictRestaurantCategories,
) => {
    const action: SettingRestaurantCategoriesAction = {
        type: ACTIONS_DICT.SET_RESTAURANT_CAT,
        categories,
    };
    return action;
};
