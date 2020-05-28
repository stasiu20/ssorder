declare module '*.css?module' {
    const classes: { [key: string]: string };
    export default classes;
}

declare module '*.scss?module' {
    const classes: { [key: string]: string };
    export default classes;
}
