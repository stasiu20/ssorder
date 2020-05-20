var Encore = require('@symfony/webpack-encore');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('web/assets/build')
    // public path used by the web server to access the output path
    .setPublicPath('/assets/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .createSharedEntry('vendor', './webpack/js/vendor.js')
    .addEntry('app', './webpack/js/app.js')
    .addEntry('restaurant', './webpack/js/restaurant.js')
    .addEntry('orderRealise', './webpack/js/orderRealise.js')
    .addEntry('rating', './webpack/js/rating.js')
    .addEntry('profile', './webpack/js/profile.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    // .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(true)

    .enableReactPreset()
    .enablePostCssLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment if you're having problems with a jQuery plugin
    // .autoProvidejQuery()
;

Encore.addPlugin(
    new BundleAnalyzerPlugin({
        analyzerMode: 'disabled',
        generateStatsFile: true,
        statsOptions: { source: false },
        statsFilename: process.env.CI ? path.join(process.env.CI_PROJECT_DIR, 'frontend/webpack/stats.json') : 'stats.json',
    })
);

module.exports = Encore.getWebpackConfig();
