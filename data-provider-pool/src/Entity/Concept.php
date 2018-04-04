<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConceptRepository")
 * Doctrine symfony doc https://symfony.com/doc/current/doctrine.html
 * More advanced annotation http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
 * Full doctrine configuration file https://symfony.com/doc/current/reference/configuration/doctrine.html
 * How to associate tables https://symfony.com/doc/current/doctrine/associations.html
 */
class Concept
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
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
