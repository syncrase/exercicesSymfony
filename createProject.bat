PROJECT_FOLDER=files
composer create-project symfony/skeleton %PROJECT_FOLDER%
cd %PROJECT_FOLDER%
composer require profiler
composer require server --dev
composer require twig
composer require annotations