export default class ResponseError extends Error {
    private readonly _response: Response;

    constructor(response: Response) {
        super('Response error');
        this.name = 'ResponseError';
        this._response = response;
    }

    get response(): Response {
        return this._response;
    }
}
