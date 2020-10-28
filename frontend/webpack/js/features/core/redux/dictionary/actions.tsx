import { ActionCreator, AnyAction } from 'redux';
import {
    ACTIONS_DICT,
    DictRestaurantCategories,
    FetchingRestaurantCategoriesAction,
    SettingRestaurantCategoriesAction,
} from './types';
import { AppServiceContainer } from '../../ServiceContainer';
import { ThunkAction } from 'redux-thunk';
import { AppState } from '../types';

export const setRestaurantCategoriesActionCreator: ActionCreator<SettingRestaurantCategoriesAction> = (
    categories: DictRestaurantCategories,
) => {
    const action: SettingRestaurantCategoriesAction = {
        type: ACTIONS_DICT.SET_RESTAURANT_CAT,
        categories,
    };
    return action;
};

export const setFetchRestaurantCategoriesActionCreator: ActionCreator<FetchingRestaurantCategoriesAction> = (
    flag: boolean,
) => {
    const action: FetchingRestaurantCategoriesAction = {
        type: ACTIONS_DICT.FETCH_RESTAURANT_CAT,
        flag,
    };
    return action;
};

export const fetchRestaurantCategoriesActionCreator = (): ThunkAction<
    void,
    AppState,
    { ContainerService: AppServiceContainer },
    AnyAction
> => {
    return function(dispatch, getStore, { ContainerService }): void {
        const store = getStore();
        if (
            store.dict.fetchingRestaurant ||
            Object.keys(store.dict.restaurantCategories).length > 1
        ) {
            return;
        }

        dispatch(setFetchRestaurantCategoriesActionCreator(true));
        ContainerService.apiService
            .fetchRestaurantCategoriesDict(new AbortController().signal)
            .then(dict => dispatch(setRestaurantCategoriesActionCreator(dict)))
            .finally(() =>
                dispatch(setFetchRestaurantCategoriesActionCreator(false)),
            );
    };
};
