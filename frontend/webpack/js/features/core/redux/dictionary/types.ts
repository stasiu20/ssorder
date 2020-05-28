import { Action } from 'redux';

export const ACTIONS_DICT = {
    SET_RESTAURANT_CAT: 'SettingRestaurantCategories',
} as const;

export type DictRestaurantCategories = Record<number, string>;

export interface DictionaryState {
    readonly restaurantCategories: DictRestaurantCategories;
}

export interface SettingRestaurantCategoriesAction
    extends Action<typeof ACTIONS_DICT.SET_RESTAURANT_CAT> {
    categories: DictRestaurantCategories;
}

export type DictionaryActions = SettingRestaurantCategoriesAction;
