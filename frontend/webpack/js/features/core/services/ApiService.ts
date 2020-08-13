import HttpService from './httpService';
import { AuthTokenService } from './authTokenService';
import { Restaurant } from '../../restaurant/types';

export default class ApiService {
    private httpService: HttpService;
    private authTokenService: AuthTokenService;

    constructor(httpService: HttpService, authTokenService: AuthTokenService) {
        this.httpService = httpService;
        this.authTokenService = authTokenService;
    }

    fetchRestaurant(signal: AbortSignal) {
        const token = this.authTokenService.getToken();
        return this.httpService.request<{ data: Restaurant[] }>(
            '/v1/restaurants',
            { headers: { Authorization: `Bearer ${token}` }, signal },
        );
    }
}
