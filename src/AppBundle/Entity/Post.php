<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Hub", mappedBy="posts")
     */
    private $hubs;

    public function __construct()
    {
        $this->hubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addHub(Hub $hub): Post
    {
        $hub->addPost($this);
        $this->hubs[] = $hub;

        return $this;
    }

    public function removeHub(Hub $hub): Post
    {
        $this->hubs->removeElement($hub);

        return $this;
    }

    public function getHubs(): ArrayCollection
    {
        return $this->hubs;
    }
}
