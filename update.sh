#!/bin/bash

./bin/console d:s:u --force
rm -rf ./var/cache
php -d memory_limit=1G bin/console sonata:media:sync-thumbnails sonata.media.provider.image default
