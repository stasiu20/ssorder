import authTokenService from '../core/services/authTokenService';
import { useEffect, useState } from 'react';
import { FetchOptions, useFetch } from 'react-async';
import {
    useWindowScroll,
    usePreviousValue,
    useThrottledFn,
} from 'beautiful-react-hooks';

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

export function useScrollToggle(
    element: HTMLElement,
    toggleClassName: string,
): void {
    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
    let prevScrollPos = usePreviousValue(0);
    const tolerance = 30;

    const onWindowScrollHandler = useThrottledFn(() => {
        const currentScrollPos = document.body.getBoundingClientRect().top;

        if (Math.abs(currentScrollPos - prevScrollPos) < tolerance) {
            return;
        }

        if (prevScrollPos <= currentScrollPos) {
            element.classList.add(toggleClassName);
        } else {
            element.classList.remove(toggleClassName);
        }
        prevScrollPos = currentScrollPos;
    }, 200);

    useEffect(() => {
        // don't forget to cancel debounced
        return (): void => onWindowScrollHandler.cancel();
    });

    useWindowScroll(onWindowScrollHandler);
}
