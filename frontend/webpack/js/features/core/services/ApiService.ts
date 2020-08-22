import HttpService from './httpService';
import { AuthTokenService } from './authTokenService';
import { Food, Restaurant, RestaurantCategory } from '../../restaurant/types';
import { DictRestaurantCategories } from '../redux/dictionary/types';

export default class ApiService {
    private httpService: HttpService;
    private authTokenService: AuthTokenService;

    constructor(httpService: HttpService, authTokenService: AuthTokenService) {
        this.httpService = httpService;
        this.authTokenService = authTokenService;
    }

    fetchRestaurantCategoriesDict(
        signal: AbortSignal,
    ): Promise<DictRestaurantCategories> {
        const token = this.authTokenService.getToken();
        return this.httpService
            .request<{ data: RestaurantCategory[] }>(
                '/v1/dictionaries/categories',
                {
                    headers: { Authorization: `Bearer ${token}` },
                    signal,
                },
            )
            .then(data => {
                const result = {};
                data.data.forEach(item => {
                    result[item.id] = item.name;
                });

                return result;
            });
    }

    fetchRestaurant(signal: AbortSignal) {
        const token = this.authTokenService.getToken();
        return this.httpService.request<{ data: Restaurant[] }>(
            '/v1/restaurants',
            { headers: { Authorization: `Bearer ${token}` }, signal },
        );
    }

    fetchRestaurantMenu(restaurantId: number, signal: AbortSignal) {
        const token = this.authTokenService.getToken();
        return this.httpService.request<{ data: Food[] }>(
            `/v1/restaurants/${restaurantId}/foods`,
            { headers: { Authorization: `Bearer ${token}` }, signal },
        );
    }

    createOrder(foodId: number, remarks = '') {
        const token = this.authTokenService.getToken();
        const headers = {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`,
        };
        return this.httpService.request<void>('/v1/orders', {
            headers,
            method: 'POST',
            body: JSON.stringify({ remarks: remarks, foodId: foodId }),
        });
    }
}
