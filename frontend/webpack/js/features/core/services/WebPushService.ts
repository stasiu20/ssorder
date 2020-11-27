import { AuthTokenServiceType } from '../../contract';

function getVAPIDPubKey(): string {
    return window.getVAPIDPubKey();
}

function urlBase64ToUint8Array(base64String): Uint8Array {
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }

    return outputArray;
}

export default class WebPushService {
    private authTokenService: AuthTokenServiceType;

    constructor(authTokenService: AuthTokenServiceType) {
        this.authTokenService = authTokenService;
    }

    async subscribe(registration): Promise<void> {
        const publicKey = getVAPIDPubKey();
        const Uint8ArrayPublicKey = urlBase64ToUint8Array(publicKey);

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: Uint8ArrayPublicKey,
        });

        await fetch('/v1/webpush', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${this.authTokenService.getToken()}`,
            },
            body: JSON.stringify(subscription.toJSON()),
        });

        return subscription;
    }

    async unsubscribe() {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();

        if (subscription === null) {
            return;
        }

        await subscription.unsubscribe();
        await fetch('/v1/webpush', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${this.authTokenService.getToken()}`,
            },
            body: JSON.stringify(subscription.toJSON()),
        });
    }
}
