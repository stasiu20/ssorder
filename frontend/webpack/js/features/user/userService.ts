export interface LoginResponse {
    token: string;
}

class UserService {
    loginUser(
        userName: string,
        password: string,
        options: RequestInit,
    ): Promise<LoginResponse> {
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
            .then<LoginResponse>(res => ({ token: res.data }));
    }
}

const userService = new UserService();
export default userService;
