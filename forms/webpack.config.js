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

        // uncomment to define the assets of the project
        // .addEntry('js/app', './assets/js/app.js')
        // .addStyleEntry('css/app', './assets/css/app.scss')
//        .addEntry('bootstrap/js', './assets/js/bootstrap.js')
//        .addStyleEntry('bootstrap/css', './assets/css/bootstrap.css')
        .addEntry('bootstrap/js', './node_modules/bootstrap/dist/js/bootstrap.js')
        .addStyleEntry('bootstrap/css', './node_modules/bootstrap/dist/css/bootstrap.css')
        // uncomment if you use Sass/SCSS files
        // .enableSassLoader()

        // uncomment for legacy applications that require $/jQuery as a global variable
        // .autoProvidejQuery()

        // show OS notifications when builds finish/fail
        .enableBuildNotifications()
        ;

module.exports = Encore.getWebpackConfig();
