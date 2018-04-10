:: ######################################################################
:: This file cannot be executed but this is the command sequence template
:: ######################################################################

set PROJECT_FOLDER=data-provider-pool
composer create-project symfony/skeleton %PROJECT_FOLDER%
cd %PROJECT_FOLDER%

:: ALMOST ALWAYS REQUIRED
composer require profiler server --dev twig annotations symfony/form


:: OPTIONAL
:: MySQL
composer require doctrine maker
:: Mongo pour php7 or later
composer config "platform.ext-mongo" "1.6.16" && composer require "alcaeus/mongo-php-adapter" doctrine/mongodb-odm-bundle
:: Advanced assets
composer require asset encore
yarn install
:: Symfony forms
composer require symfony/form


:: UI LIBRARIES
:: !!! Préférer l'utilisation de yarn, c'est fait pour ça!
composer require twbs/bootstrap components/font-awesome components/jquery 


:: INFO
:: example de configuration d'un bundle
php bin/console config:dump-reference framework
:: Affiche toutes les routes
php bin/console debug:router
:: Affiche tous les autowiring
php bin/console debug:autowiring
:: Affiche tous les packages composer
composer show


:: At the end
composer update


:: NOTES
'--dev' option : Install packages listed in require-dev (this is the default behavior).