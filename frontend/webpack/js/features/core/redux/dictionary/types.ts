import { Action } from 'redux';

export interface Dict {
    [key: string]: string;
}

export interface DictionaryState {
    readonly restaurantCategories: Dict;
}

export interface SettingRestaurantCategoriesAction
    extends Action<'SettingRestaurantCategories'> {
    categories: Dict;
}

export type DictionaryActions = SettingRestaurantCategoriesAction;
