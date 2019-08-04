# Symfony Cache Tags example

This repo contains an example for caching and cache invalidation through cache tags 
using Symfony Cache Component.

# Check the full explanation video (GR)
[![Cache, για Performance & Consistency #73, live](https://img.youtube.com/vi/1z-Pjc8HJZg/0.jpg)](https://youtu.be/1z-Pjc8HJZg)

# Installation
Requirements
- You need to have [Docker](https://docs.docker.com/engine/installation/) and [Docker Compose](https://docs.docker.com/compose/install/) installed

# Run

Run in root folder,
~~~
cp .env.example .env
docker-compose build && docker-compose up -d
~~~~

Login to the container and install composer dependencies,
~~~
docker exec -u serveruser -it cachetags_fpm /bin/bash -c "TERM=$TERM exec bash"
cd vhosts/cachetags/
composer install
~~~~

Check http://127.0.0.1/ on your browser

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
