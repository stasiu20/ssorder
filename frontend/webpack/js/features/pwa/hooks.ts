import authTokenService from '../core/services/authTokenService';
import { useEffect, useState } from 'react';
import { FetchOptions, useFetch } from 'react-async';

export function useAuthStatus(): boolean {
    const [isAuthenticated, setAuthenticated] = useState<boolean>(false);

    useEffect(() => {
        const subscription = authTokenService
            .isAuthenticated$()
            .subscribe(value => {
                setAuthenticated(value);
            });
        return (): void => subscription.unsubscribe();
    }, []);

    return isAuthenticated;
}

export function useApiFetch<T>(
    resource: RequestInfo,
    init: RequestInit,
    options: FetchOptions<T>,
) {
    const token = authTokenService.getToken();
    return useFetch<T>(
        resource,
        // todo mmo merge headers
        { ...init, headers: { Authorization: `Bearer ${token}` } },
        options,
    );
}
