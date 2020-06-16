class AuthTokenService {
    isAuthenticated(): boolean {
        return false;
    }
}

const authTokenService = new AuthTokenService();
export default authTokenService;
