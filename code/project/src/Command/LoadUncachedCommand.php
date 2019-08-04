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

        for ($i = 0; $i < 500; $i++) {
            $date = new DateTime();
            $date->setTimestamp(1501861385);

            for ($d = 0; $d < 100; $d++) {
                $date->modify('+'.$d.'day');
                $blogPostTitles = $this->blogPostTitleLoader->getBlogPostTitlesByGreaterDate($date);
            }
        }
        print('Duration: '.(string)(microtime(true) - $start).PHP_EOL);
    }

}