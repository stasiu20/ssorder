import React, { useState, useEffect, Dispatch } from 'react';
import WebPushService from '../../core/services/WebPushService';
import { toast } from 'react-toastify';
import { AuthTokenServiceType } from '../../contract';

class DomTokenProvider implements AuthTokenServiceType {
    getToken(): string | null {
        const token = window.getJWTToken();

        return token || null;
    }
}

const service = new WebPushService(new DomTokenProvider());

// eslint-disable-next-line @typescript-eslint/no-empty-interface
interface Props {}

function useHasWebPushSubscription(): readonly [boolean, Dispatch<boolean>] {
    const [hasSubscription, setHasSubscription] = useState(false);

    if ('serviceWorker' in navigator) {
        // we don't have any event to monitoring subscription -
        // https://medium.com/@madridserginho/how-to-handle-webpush-api-pushsubscriptionchange-event-in-modern-browsers-6e47840d756f
        // https://stackoverflow.com/questions/36602095/how-should-i-handle-the-pushsubscriptionchange-event
        navigator.serviceWorker.ready
            .then(registration => registration.pushManager.getSubscription())
            .then(subscription => setHasSubscription(!!subscription));
    }

    return [hasSubscription, setHasSubscription] as const;
}

const useWebPushState = (): [PermissionState] => {
    const [permissionState, setPermissionState] = useState<PermissionState>(
        'denied',
    );

    useEffect(() => {
        if ('permissions' in navigator) {
            navigator.permissions
                .query({ name: 'push', userVisibleOnly: true })
                .then(ps => setPermissionState(ps.state));
        }
    }, []);

    return [permissionState];
};

async function registerWebPush(): Promise<void> {
    if ('serviceWorker' in navigator) {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();

        if (!subscription) {
            await service.subscribe(registration);
        }
    }
}

const WebPushCheckbox: React.FC<Props> = props => {
    const [webPushState] = useWebPushState();
    const [hasSubscription, setHasSubs] = useHasWebPushSubscription();
    const isChecked = webPushState === 'granted' && hasSubscription;

    const onChangeHandler = () => {
        if (hasSubscription) {
            service
                .unsubscribe()
                .then(() => {
                    setHasSubs(false);
                    toast.success('You unsubscribe from WebPush');
                })
                .catch(() =>
                    toast.error('Error during unsubscribe from WebPush'),
                );
        } else {
            registerWebPush()
                .then(() => {
                    setHasSubs(true);
                    toast.success('You successful subscribe to WebPush');
                })
                .catch(() => toast.error('Error during subscribe to WebPush'));
        }
    };

    return (
        <input
            type="checkbox"
            onChange={onChangeHandler}
            checked={isChecked}
            disabled={
                !('serviceWorker' in navigator && 'PushManager' in window)
            }
        />
    );
};

const IfWebPushGranted: React.FC<Props> = props => {
    const [webPushState] = useWebPushState();

    if (webPushState === 'granted') {
        return <>{props.children}</>;
    }

    return null;
};

const IfWebPushNotGranted: React.FC<Props> = props => {
    const [webPushState] = useWebPushState();

    if (webPushState !== 'granted') {
        return <>{props.children}</>;
    }

    return null;
};

const WebPushState: React.FC<Props> = props => {
    const [webPushState] = useWebPushState();

    return (
        <p>
            WebPush status: <strong>{webPushState}</strong>
        </p>
    );
};

const WebPushStateManager: React.FC<Props> = props => {
    return (
        <>
            <WebPushState />
            <label>
                <IfWebPushGranted>You have enable WebPush.</IfWebPushGranted>
                <IfWebPushNotGranted>
                    You don&apos;t allow for WebPush. Click checkbox to give
                    permissions. Without WebPush we can&apos;t send to you
                    notifications.
                </IfWebPushNotGranted>
                <WebPushCheckbox />
            </label>
        </>
    );
};

export default WebPushStateManager;
