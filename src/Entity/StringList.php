<?php

namespace App\Entity;

use App\Repository\StringListRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StringListRepository::class)]
#[ORM\HasLifecycleCallbacks]
class StringList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModified = null;

    #[ORM\OneToOne(targetEntity: StringList::class)]
    private ?StringList $next = null;

    #[ORM\OneToOne(targetEntity: StringList::class)]
    private ?StringList $previous = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function getDateCreatedString(): ?string
    {
        return $this->dateCreated->format('Y-m-d H:i:s');
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function getDateModifiedString(): ?string
    {
        return $this->dateModified->format('Y-m-d H:i:s');
    }

    public function setDateModified(\DateTimeInterface $dateModified): static
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getNext(): ?StringList
    {
        return $this->next;
    }

    public function setNext(?StringList $next): void
    {
        $this->next = $next;
    }

    public function getPrevious(): ?StringList
    {
        return $this->previous;
    }

    public function setPrevious(?StringList $previous): void
    {
        $this->previous = $previous;
    }
}
