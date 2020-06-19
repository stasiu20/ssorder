export function isPwaApp(): boolean {
    return location.pathname === '/pwa';
}

export function generateUrl(
    router: string,
    params: Record<string, number | string>,
): string {
    // todo mmo whitelist
    switch (router) {
        case 'restaurant':
            return isPwaApp()
                ? `/menu/${params.id}`
                : `/restaurants/details?id=${params.id}`;
        default:
            throw new Error('Unknown router name');
    }
}
