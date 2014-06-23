##GamesBot

This is a bot for sitting in a Slack channel and hyperlinking to games on BoardGameGeek

#Deployment

There is a Boxfile for deployment on Pagoda Box, hook configuration needs to happen inside Slack

#Local Installation

Download and install dependencies via composer;

    composer install

Run a local PHP webserver:

    php -S localhost:8000 -t web

Run the tests:

    bin/phpspec run
    bin/behat
