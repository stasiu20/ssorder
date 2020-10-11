import { useEffect, useState } from 'react';
import { FetchOptions, useFetch } from 'react-async';
import {
    useWindowScroll,
    usePreviousValue,
    useThrottledFn,
} from 'beautiful-react-hooks';
import { useServiceContainer } from '../core/context/serviceContainer';

export function useAuthStatus(): boolean {
    const container = useServiceContainer();
    const [isAuthenticated, setAuthenticated] = useState<boolean>(false);

    useEffect(() => {
        const subscription = container.authTokenService
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
    const container = useServiceContainer();
    const token = container.authTokenService.getToken();
    return useFetch<T>(
        resource,
        // todo mmo merge headers
        { ...init, headers: { Authorization: `Bearer ${token}` } },
        options,
    );
}

export function useScrollToggle(defaultValue: boolean): boolean {
    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
    const [prevScrollPos, setCurrentScrollPos] = useState<number>(0);
    const [visible, setVisible] = useState<boolean>(defaultValue);
    const tolerance = 30;

    const onWindowScrollHandler = useThrottledFn(() => {
        const currentScrollPos = document.body.getBoundingClientRect().top;

        if (Math.abs(currentScrollPos - prevScrollPos) < tolerance) {
            return;
        }

        if (prevScrollPos <= currentScrollPos) {
            setVisible(true);
        } else {
            setVisible(false);
        }
        setCurrentScrollPos(currentScrollPos);
    }, 450);

    useEffect(() => {
        // don't forget to cancel debounced
        return (): void => {
            onWindowScrollHandler.cancel();
        };
    }, []);
    useWindowScroll(onWindowScrollHandler);

    return visible;
}
