:: This file doesn't work but this is the right command sequence
set PROJECT_FOLDER=chronologie
composer create-project symfony/skeleton %PROJECT_FOLDER%
cd %PROJECT_FOLDER%
composer require profiler
composer require server --dev
composer require twig
composer require annotations
