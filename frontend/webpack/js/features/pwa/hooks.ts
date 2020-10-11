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
