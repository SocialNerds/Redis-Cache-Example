<?php

namespace App\Command;

use App\Service\BlogPostTitleLoader;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUncachedCommand extends Command
{
    protected static $defaultName = 'app:load-uncached';

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
                $blogPostTitles = $this->blogPostTitleLoader->getBlogPostTitlesByGreaterDate($date);
            }
            print('.');
        }
        print(PHP_EOL.'Duration: '.(string)(microtime(true) - $start).PHP_EOL);
    }

}
