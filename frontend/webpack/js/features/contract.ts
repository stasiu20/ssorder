export interface LoginResponseType {
    token: string;
}

export interface UserServiceType {
    loginUser(
        userName: string,
        password: string,
        options: RequestInit,
    ): Promise<LoginResponseType>;
}
