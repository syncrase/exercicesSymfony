var Encore = require('@symfony/webpack-encore');

Encore
        // the project directory where compiled assets will be stored
        .setOutputPath('public/build/')
        // the public path used by the web server to access the previous directory
        .setPublicPath('/build')
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        // uncomment to create hashed filenames (e.g. app.abc123.css)
        // .enableVersioning(Encore.isProduction())
        // show OS notifications when builds finish/fail
        .enableBuildNotifications()

        // assets for the theme 1
        .addEntry('theme1/js', './assets/theme1/theme1.js')
        .addStyleEntry('theme1/css', './assets/theme1/theme1.scss')


//        .addStyleEntry('theme1/css', './assets/css/custom.scss')

        // any url() paths in your Sass files must now be relative to the original source entry file 
        // instead of whatever file you're inside of
        .enableSassLoader(function (sassOptions) {}, {
            resolveUrlLoader: false
        })

        // uncomment for legacy applications that require $/jQuery as a global variable
        // allow legacy applications to use $/jQuery as a global variable
        .autoProvidejQuery()
        ;

module.exports = Encore.getWebpackConfig();
