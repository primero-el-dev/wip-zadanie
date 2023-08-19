<?php

$fileContents = file_get_contents('docker-compose.dist.yaml');

file_put_contents('docker-compose.yaml', str_replace('$pathToApp', __DIR__, $fileContents));

echo exec('docker-compose up -d --build');
echo 'Containers should be up...' . PHP_EOL;
exec('docker-compose exec zadanie-php composer install');
echo 'Composer dependencies downloaded...' . PHP_EOL;
exec('docker-compose exec zadanie-php bin/console -n doctrine:migrations:migrate');
echo 'Migrations executed...' . PHP_EOL;
exec('docker-compose exec zadanie-php yarn install');
echo 'Yarn dependencies downloaded...' . PHP_EOL;
exec('docker-compose exec zadanie-php yarn build');
echo 'Yarn build finished...' . PHP_EOL;
echo "Everything's done" . PHP_EOL;