import { Action } from 'redux';

export const ACTIONS_DICT = {
    SET_RESTAURANT_CAT: 'SettingRestaurantCategories',
    FETCH_RESTAURANT_CAT: 'FetchingRestaurantCategories',
} as const;

export type DictRestaurantCategories = Record<number, string>;

export interface DictionaryState {
    readonly restaurantCategories: DictRestaurantCategories;
}

export interface SettingRestaurantCategoriesAction
    extends Action<typeof ACTIONS_DICT.SET_RESTAURANT_CAT> {
    categories: DictRestaurantCategories;
}

export interface FetchingRestaurantCategoriesAction
    extends Action<typeof ACTIONS_DICT.FETCH_RESTAURANT_CAT> {
    flag: boolean;
}

export type DictionaryActions =
    | SettingRestaurantCategoriesAction
    | FetchingRestaurantCategoriesAction;
