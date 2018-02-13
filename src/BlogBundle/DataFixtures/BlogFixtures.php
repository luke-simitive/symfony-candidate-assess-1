<?php

namespace BlogBundle\DataFixtures;

use BlogBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle('Blog Post '.$i);
            $manager->persist($post);
        }

        $manager->flush();
    }
}