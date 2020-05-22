import { ActionCreator } from 'redux';
import { Dict, SettingRestaurantCategoriesAction } from './types';

export const setRestaurantCategoriesActionCreator: ActionCreator<SettingRestaurantCategoriesAction> = (
    categories: Dict,
) => {
    const action: SettingRestaurantCategoriesAction = {
        type: 'SettingRestaurantCategories',
        categories,
    };
    return action;
};
