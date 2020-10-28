const Encore = require('@symfony/webpack-encore');
const WorkboxPlugin = require('workbox-webpack-plugin');
const path = require('path');
const crypto = require('crypto');
const fs = require('fs');

function calculateChecksum(file) {
    return crypto.createHash('md5').update(fs.readFileSync(file)).digest('base64')
}

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('./web/assets/pwa')
    // public path used by the web server to access the output path
    .setPublicPath('/assets/pwa')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './webpack/js/features/pwa/index.tsx')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    // .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    // .configureBabelPresetEnv((config) => {
    //     config.useBuiltIns = 'usage';
    //     config.corejs = 3;
    // })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    .enableReactPreset()
//.addEntry('admin', './assets/js/admin.js')
    .addAliases({
        '@': path.resolve(__dirname, 'src'),
    })
;

Encore.addPlugin(
    new WorkboxPlugin.InjectManifest({
        swSrc: './webpack/js/sw.ts',
        swDest: '../../sw.js',
        maximumFileSizeToCacheInBytes: 10485760,
        additionalManifestEntries: [
            { url: '/manifest.json', revision: calculateChecksum(path.resolve(__dirname, 'web/manifest.json')) },
            { url: '/image/icons/icon-72x72.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-72x72.png')) },
            { url: '/image/icons/icon-96x96.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-96x96.png')) },
            { url: '/image/icons/icon-128x128.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-128x128.png')) },
            { url: '/image/icons/icon-144x144.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-144x144.png')) },
            { url: '/image/icons/icon-152x152.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-152x152.png')) },
            { url: '/image/icons/icon-192x192.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-192x192.png')) },
            { url: '/image/icons/icon-384x384.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-384x384.png')) },
            { url: '/image/icons/icon-512x512.png', revision: calculateChecksum(path.resolve(__dirname, 'web/image/icons/icon-512x512.png')) },
        ],
    }),
);

module.exports = Encore.getWebpackConfig();
