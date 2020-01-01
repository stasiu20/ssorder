import { Observable, Observer } from 'rxjs';

/**
 * This method wraps an EventSource as an observable sequence.
 * @param {String} url The url of the server-side script.
 * @param {Observer} [openObserver] An optional observer for the 'open' event for the server side event.
 * @returns {Observable} An observable sequence which represents the data from a server-side event.
 *
 * @link https://gist.github.com/mattpodwysocki/69872d2f7ae6d0180155
 */
export function fromEventSource(
    url: string,
    openObserver: Observer<any> = null
) {
    return new Observable<{ message: string }>(observer => {
        const source = new EventSource(url);

        function onOpen(e) {
            openObserver.next(e);
            openObserver.complete();
            source.removeEventListener('open', onOpen, false);
        }

        function onError(e) {
            if (e.readyState === EventSource.CLOSED) {
                observer.complete();
            } else {
                observer.error(e);
            }
        }

        function onMessage(e: MessageEvent) {
            try {
                const data = JSON.parse(e.data);
                observer.next(data);
            } catch (e) {}
        }

        openObserver && source.addEventListener('open', onOpen, false);
        source.addEventListener('error', onError, false);
        source.addEventListener('message', onMessage, false);

        return function() {
            source.removeEventListener('error', onError, false);
            source.removeEventListener('message', onMessage, false);
            source.close();
        };
    });
}
