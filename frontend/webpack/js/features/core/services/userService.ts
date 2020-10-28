import { LoginResponseType, UserServiceType } from '../../contract';

export class UserService implements UserServiceType {
    loginUser(
        userName: string,
        password: string,
        options: RequestInit,
    ): Promise<LoginResponseType> {
        return fetch('/v1/session/login', {
            ...options,
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ userName, password }),
        })
            .then(res => (res.ok ? res : Promise.reject(res)))
            .then(res => res.json())
            .then<LoginResponseType>(res => ({ token: res.data }));
    }
}
