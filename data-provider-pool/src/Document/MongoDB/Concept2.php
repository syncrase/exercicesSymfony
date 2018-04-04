<?php

//namespace App\Entity\MongoDB;
namespace App\Document\MongoDB;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\MongoDB\Concept2Repository")
 */
class Concept2
{
    /**
     * @MongoDB\Id
     * @ ORM\GeneratedValue()
     * @ ORM\Column(type="integer")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     * @ ORM\Column(type="string", length=512, nullable=true)
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
