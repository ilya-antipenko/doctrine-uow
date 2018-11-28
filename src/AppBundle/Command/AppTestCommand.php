<?php

namespace AppBundle\Command;

use AppBundle\Entity\Hub;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppTestCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ?string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('app:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->entityManager;

        $hub = new Hub();
        $hub->setName('Databases ' . uniqid());
        $em->persist($hub);

        $post = new Post();
        $post->addHub($hub);
        $em->persist($post);
        $em->flush();

// 2. Uncomment this and check.
//        $post2 = new Post();
//        $post2->addHub($hub);
//        $em->persist($post2);

// 1. Uncomment this and check.
//        $em->remove($post);
//        $em->flush();
    }

}
