<?php

// Loading composer libraries. These libraries contain the
// cache library and the adapter for Redis.
require_once('vendor/autoload.php');

// We are using the Redis Adapter as our cache backend.
use Symfony\Component\Cache\Adapter\RedisAdapter;

// Initializing connection to Redis.
$redis = new RedisAdapter(
    RedisAdapter::createConnection('redis://redis')
);

// Checking Redis for data under the key "new_item".
// it shouldn't return anything since this is a new connection.
$item = $redis->getItem('new_item');

// Checking if there is any data under the key "new_item".
if (!$item->isHit()) {
    print('Cache does not exist!'.PHP_EOL);
}

// Setting under this key the new data. The new data is just
// a string. And then, we use "save" method to persist this
// data.
$item->set('This is a saved value.');
$redis->save($item);

// Then, we check under the key "new_item" if there is any
// data.
$item = $redis->getItem('new_item');

// Since we saved a string in this key, this time, it should
// return data.
if ($item->isHit()) {
    print('Cache exists!'.PHP_EOL);
}

// Deleting our data.
$redis->deleteItem('new_item');

// Then, we check again to see that now there is nothing there.
$item = $redis->getItem('new_item');
if (!$item->isHit()) {
    print('Cache does not exist!'.PHP_EOL);
}
