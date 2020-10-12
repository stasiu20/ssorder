import { DictRestaurantCategories } from './core/redux/dictionary/types';
import { Food, Restaurant } from './restaurant/types';

export interface LoginResponseType {
    token: string;
}

export interface UserServiceType {
    loginUser(
        userName: string,
        password: string,
        options: RequestInit,
    ): Promise<LoginResponseType>;
}

export interface ApiServiceType {
    fetchRestaurantCategoriesDict(
        signal: AbortSignal,
    ): Promise<DictRestaurantCategories>;

    fetchRestaurant(signal: AbortSignal): Promise<{ data: Restaurant[] }>;

    fetchRestaurantMenu(
        restaurantId: number,
        signal: AbortSignal,
    ): Promise<{ data: Food[] }>;

    createOrder(foodId: number, remarks): Promise<void>;
}
