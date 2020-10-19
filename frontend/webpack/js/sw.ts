import { precacheAndRoute } from 'workbox-precaching';
import { setCacheNameDetails } from 'workbox-core';
import { PrecacheEntry } from 'workbox-precaching/src/_types';

interface Window extends ServiceWorkerGlobalScope {
    __WB_MANIFEST: Array<PrecacheEntry | string>;
}
declare const self: Window;

// <editor-fold desc="precache">
const filesToCache = [];
setCacheNameDetails({
    prefix: 'my-app',
    suffix: 'v1',
    precache: 'precache',
    runtime: 'run-time',
    googleAnalytics: 'ga',
});

// Precaching
// Make sure that all the assets passed in the array below are fetched and cached
// The empty array below is replaced at build time with the full list of assets to cache
// This is done by workbox-build-inject.js for the production build
let assetsToCache = self.__WB_MANIFEST;
// To customize the assets afterwards:
assetsToCache = [...assetsToCache, ...filesToCache];
precacheAndRoute(assetsToCache);
// </editor-fold>
