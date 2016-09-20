#!/bin/bash
set -e
set -x

EPV=$1
DB=$2
TRAVIS_PHP_VERSION=$3

if [ "$EPV" == "1" -a "$DB" == "mysqli" -a "$TRAVIS_PHP_VERSION" == "5.5" ]
then
	cd phpBB
	composer require phpbb/epv:dev-master --dev --no-interaction
	cd ../
fi
