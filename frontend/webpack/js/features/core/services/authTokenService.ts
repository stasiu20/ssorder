import { BehaviorSubject, Observable } from 'rxjs';

export class AuthTokenService {
    private _subject = new BehaviorSubject<boolean>(false);

    constructor() {
        this._subject.next(this.isAuthenticated());
    }

    storeToken(token: string): void {
        this._subject.next(true);
        localStorage.setItem('token', token);
    }

    clearToken(): void {
        this._subject.next(false);
        localStorage.removeItem('token');
    }

    getToken(): string | null {
        return localStorage.getItem('token') || null;
    }

    isAuthenticated(): boolean {
        return this.getToken() !== null;
    }

    isAuthenticated$(): Observable<boolean> {
        return this._subject.asObservable();
    }
}

const authTokenService = new AuthTokenService();
export default authTokenService;
