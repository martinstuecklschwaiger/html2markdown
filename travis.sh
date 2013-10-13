#!/bin/sh

SCRIPT_BASEDIR=$(dirname $0)

cd $SCRIPT_BASEDIR
wd=$PWD

#for php_version in 5.3 5.4 5.5; do
for php_version in 5.3; do
	echo $php_version
	(
		cd /tmp
		pwd
		
		echo $wd
		git clone $wd php_travis_$php_version
		cd php_travis_$php_version
		pwd
		
		composer install
		composer create-project --keep-vcs scrutinizer/php-analyzer:dev-master
		
		phpenv global 5.3
		
		#phpunit --coverage-text
		
		cd ..
		#chmod -R 777 php_travis_$php_version
		#rm -r php_travis_$php_version
		
	)
done
