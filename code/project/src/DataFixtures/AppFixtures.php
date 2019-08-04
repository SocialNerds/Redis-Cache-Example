<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use joshtronic\LoremIpsum;
use \DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $lipsum = new LoremIpsum();

        for ($i = 0; $i < 1000; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($lipsum->words(4));
            $blogPost->setContent($lipsum->sentences(100));
            $date = new DateTime();
            $date->setTimestamp(rand(1501861385, 1564933385));
            $blogPost->setCreatedAt($date);
            $manager->persist($blogPost);
        }
        $manager->flush();
    }
}
