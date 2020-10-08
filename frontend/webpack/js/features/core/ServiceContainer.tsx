import ApiService from './services/ApiService';
import authTokenService, {
    AuthTokenService,
} from './services/authTokenService';
import HttpService from './services/httpService';

export interface AppServiceContainer {
    apiService: ApiService;
    authTokenService: AuthTokenService;
}

function factoryServiceContainer(): AppServiceContainer {
    const apiService = new ApiService(new HttpService(), authTokenService);
    return {
        apiService,
        authTokenService: authTokenService,
    };
}

export const ContainerService = factoryServiceContainer();
