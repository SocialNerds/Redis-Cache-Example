<?php

require_once('vendor/autoload.php');

use Symfony\Component\Cache\Adapter\RedisAdapter;

$redis = new RedisAdapter(
  RedisAdapter::createConnection('redis://redis')
);

$item = $redis->getItem('new_item');

if (!$item->isHit()) {
  print('Cache does not exist!' . PHP_EOL);
}

$item->set('This is a saved value.');
$redis->save($item);


$item = $redis->getItem('new_item');

if ($item->isHit()) {
  print('Cache exists!' . PHP_EOL);
}

$redis->deleteItem('new_item');

$item = $redis->getItem('new_item');

if (!$item->isHit()) {
  print('Cache does not exist!' . PHP_EOL);
}