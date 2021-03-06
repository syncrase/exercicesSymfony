var Encore = require('@symfony/webpack-encore');

Encore
        .setOutputPath('public/build/')
        .setPublicPath('/build')
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        // uncomment to create hashed filenames (e.g. app.abc123.css)
        // .enableVersioning(Encore.isProduction())
        .enableBuildNotifications()
        // uncomment to define the assets of the project
        .addEntry('js/app', './assets/js.js')
//        .addStyleEntry('css/app', './assets/style.scss') --> already inclue in js.js
        //.addStyleEntry('css/login', './assets/css/login.scss')
        
        .addEntry('css/app', './assets/js/login.js')
        // assets for the theme 1
//        .addEntry('vis/js', './node_modules/vis/dist/vis.js')
//        .addStyleEntry('vis/css', './node_modules/vis/dist/vis.css')
        // uncomment if you use Sass/SCSS files
        // any url() paths in your Sass files must now be relative to the original source entry file 
        // instead of whatever file you're inside of
        .enableSassLoader(function (sassOptions) {}, {
            resolveUrlLoader: false
        })

        // uncomment for legacy applications that require $/jQuery as a global variable
        .autoProvidejQuery()
        ;

module.exports = Encore.getWebpackConfig();
