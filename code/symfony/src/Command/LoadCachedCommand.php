<?php

namespace App\Command;

use App\Service\BlogPostTitleLoader;
use DateInterval;
use DateTime;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCachedCommand extends Command
{
    protected static $defaultName = 'app:load-cached';

    /**
     * @var RedisAdapter.
     */
    protected $redis;

    /**
     * @var BlogPostTitleLoader
     */
    private $blogPostTitleLoader;

    /**
     * LoadUncachedCommand constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(BlogPostTitleLoader $blogPostTitleLoader)
    {
        parent::__construct();
        $this->blogPostTitleLoader = $blogPostTitleLoader;

        $this->redis = new RedisAdapter(
            RedisAdapter::createConnection(
                'redis://redis'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = microtime(true);

        print('Testing');
        for ($i = 0; $i < 1000; $i++) {
            $date = new DateTime();
            $date->setTimestamp(1501861385);

            for ($d = 0; $d < 10; $d++) {
                $date->modify('+'.$d.'day');
                $blogPostTitles = $this->getBlogPostTitlesByGreaterDateCached($date);
            }
            print('.');
        }
        print(PHP_EOL.'Duration: '.(string)(microtime(true) - $start).PHP_EOL);
    }

    /**
     * Get blog post titles from cache or DB.
     *
     * @param DateTime $date
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function getBlogPostTitlesByGreaterDateCached(DateTime $date): array
    {
        $item = $this->redis->getItem('blog.'.md5($date->getTimestamp()));

        if ($item->isHit()) {
            return $item->get();
        }

        $blogPostTitles = $this->blogPostTitleLoader->getBlogPostTitlesByGreaterDate($date);
        $item->set($blogPostTitles);
        $item->expiresAfter(new DateInterval('PT10S'));
        $this->redis->save($item);

        return $blogPostTitles;
    }

}
