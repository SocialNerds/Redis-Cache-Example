# Redis Cache example

This repo contains an example on caching with Redis. 

# Check the full explanation video (GR)
(Coming soon)

# Installation
Requirements
- You need to have [Docker](https://docs.docker.com/engine/installation/) and [Docker Compose](https://docs.docker.com/compose/install/) installed

# Run

Run in root folder,
~~~
cp .env.example .env && docker-compose build && docker-compose up -d
~~~~

Login to the container and install composer dependencies,
~~~
docker exec -u serveruser -it app_fpm /bin/bash
~~~~

Install dependencies,
~~~
cd simple && composer install && cd ../symfony && composer install
~~~~

Create DB schema,
~~~
php bin/console doctrine:schema:update --force
~~~~

Create dummy data,
~~~
yes | php bin/console doctrine:fixtures:load
~~~~

Test the database without cache,
~~~
php bin/console app:load-uncached
~~~~

Test the database with cache,
~~~
php bin/console app:load-cached
~~~~

The cached test should be much faster.

Exit the container,
~~~
exit
~~~~

To stop it, go to root folder and type,
~~~~
docker-compose down
~~~~

# By SocialNerds
* [SocialNerds.gr](https://www.socialnerds.gr/)
* [YouTube](https://www.youtube.com/SocialNerdsGR)
* [Facebook](https://www.facebook.com/SocialNerdsGR)
* [Twitter](https://twitter.com/socialnerdsgr)
