import ApiService from './services/ApiService';
import authTokenService, {
    AuthTokenService,
} from './services/authTokenService';
import HttpService from './services/httpService';
import { UserService } from './services/userService';
import { ApiServiceType, UserServiceType } from '../contract';

export interface AppServiceContainer {
    apiService: ApiServiceType;
    authTokenService: AuthTokenService;
    userService: UserServiceType;
}

function factoryServiceContainer(): AppServiceContainer {
    const apiService = new ApiService(new HttpService(), authTokenService);
    return {
        apiService,
        authTokenService: authTokenService,
        userService: new UserService(),
    };
}

const ContainerService = factoryServiceContainer();

export function getContainerService(): AppServiceContainer {
    return ContainerService;
}
