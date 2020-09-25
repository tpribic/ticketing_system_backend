<?php

namespace App\Issue\Infrastructure\Doctrine\Main\Entity;

use App\Issue\ContextContract\PriorityInterface;
use App\Issue\Infrastructure\Doctrine\Main\Repository\PriorityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriorityRepository::class)
 */
class Priority implements PriorityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;

    public function getId(): ?int
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
}
