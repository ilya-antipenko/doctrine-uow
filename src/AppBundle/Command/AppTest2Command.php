<?php

namespace AppBundle\Command;

use AppBundle\Entity\Hub;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppTest2Command extends Command
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
            ->setName('app:test2');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->entityManager;

        // Create Hub
        $hub = new Hub();
        $hub->setName('Databases ' . uniqid());
        $em->persist($hub);

        // Create first Post
        $post = new Post();
        $post->addHub($hub);
        $em->persist($post);
        $em->flush();

        // Create second Post
        $post2 = new Post();
        $em->persist($post2);

        $hub->getPosts()->clear();
        $hub->addPost($post2);
        $em->flush();

        // Print hub data
        echo 'Before refresh: ' . PHP_EOL;
        $this->printHub($hub);

        // Refresh from the DB
        $em->refresh($hub);

        // Print hub data
        echo 'After refresh: ' . PHP_EOL;
        $this->printHub($hub);
    }

    private function printHub(Hub $hub)
    {
        echo sprintf('Posts of hub "%s"' . PHP_EOL, $hub->getName());
        foreach ($hub->getPosts() as $post) {
            echo '[+] Post ID: ' . $post->getId() . PHP_EOL;
        }
        echo '=====================' . PHP_EOL . PHP_EOL;
    }

}
