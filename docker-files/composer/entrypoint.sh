#! /bin/bash

# install composer dependencies
if [ ! -f "vendor/autoload.php" ]; then
    #if depencies has already been installed don't rerun
    composer install --no-progress --no-interaction
fi #end if

# copy .env.example file if .env file does not exist
if [ ! -f ".env"]; then
    echo "Creating .env file for env WP-WEB-CRAWLER"
    cp .env.example .env
else
    echo "env file exists"
fi

role=${CONTAINER_ROLE:-composer}

echo "Done"