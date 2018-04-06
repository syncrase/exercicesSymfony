:: This file doesn't work but this is the right command sequence
set PROJECT_FOLDER=data-provider-pool
composer create-project symfony/skeleton %PROJECT_FOLDER%
cd %PROJECT_FOLDER%

:: REQUIRED
composer require profiler server --dev twig annotations


:: OPTIONAL
:: MySQL
composer require doctrine maker
:: Mongo pour php7 or later
composer config "platform.ext-mongo" "1.6.16" && composer require "alcaeus/mongo-php-adapter" doctrine/mongodb-odm-bundle
:: Advanced assets
composer require asset encore
yarn install


:: LIBRARIES
composer require twbs/bootstrap components/font-awesome components/jquery 


:: HELP example de configuration d'un bundle
php bin/console config:dump-reference framework