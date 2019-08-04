<?php


namespace App\Service;

use App\Entity\BlogPost;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlogPostTitleLoader
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * BlogPostTitleLoader constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Load titles of blog posts that are created at a greater date.
     *
     * @param DateTime $date
     *
     * @return array
     */
    public function getBlogPostTitlesByGreaterDate(DateTime $date): array
    {

        $repository = $this->container->get('doctrine')->getRepository(BlogPost::class);

        $criteria = new Criteria();
        $criteria
            ->where($criteria->expr()->gt('createdAt', $date))
            ->orderBy(['createdAt' => Criteria::ASC])
            ->setFirstResult(0)
            ->setMaxResults(10);
        $blogPostEntities = $repository->matching($criteria);
        $blogPostTitles = [];
        foreach ($blogPostEntities as $blogPostEntity) {
            $blogPostTitles[] = $blogPostEntity->getTitle();
        }

//        $this->container->get('doctrine')->getEntityManager()->clear(BlogPost::class);

        return $blogPostTitles;
    }
}