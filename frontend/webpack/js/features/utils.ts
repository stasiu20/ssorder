import { Router } from 'symfony-ts-router';
import routes from './fos_js_routes.json';

type ROUTE_NAME = keyof typeof routes.routes;

const router = new Router();
router.setRoutingData(routes);

export function isPwaApp(): boolean {
    return location.pathname === '/pwa';
}

export function generateUrl(
    routerName: ROUTE_NAME,
    params: Record<string, number | string> = {},
): string {
    if (isPwaApp()) {
        routerName = `pwa-${routerName.toString()}` as ROUTE_NAME;
    }
    return router.generate(routerName as string, params);
}
