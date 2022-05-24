declare module 'appConfig' {
    interface Config {
        apiUrl: string;
        meiliSearch: {
            url: string;
            apiKey: string;
        };
    }
    const def: Config;
    export default def;
}
