import ResponseError from '../exceptions/ResponseError';

export default class HttpService {
    request<T>(input: RequestInfo, init?: RequestInit): Promise<T> {
        const headers = {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        };

        if (!init) {
            init = {};
        }
        if (!init.headers) {
            init.headers = headers;
        }

        return fetch(input, init)
            .then(res =>
                res.ok ? res : Promise.reject(new ResponseError(res)),
            )
            .then<T>(res => res.json());
    }
}
