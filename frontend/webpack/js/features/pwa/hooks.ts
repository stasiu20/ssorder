import authTokenService from '../core/services/authTokenService';
import { useEffect, useState } from 'react';

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
