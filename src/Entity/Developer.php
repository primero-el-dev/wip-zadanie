<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer extends User
{
    #[Assert\NotBlank(message: 'entity.developer.ideEnvironments.notBlank')]
    #[Assert\Length(
        max: 255, 
        maxMessage: 'entity.developer.ideEnvironments.length.max',
    )]
    #[ORM\Column(length: 255)]
    private ?string $ideEnvironments = null;

    #[Assert\NotBlank(message: 'entity.developer.programmingLanguages.notBlank')]
    #[Assert\Length(
        max: 255, 
        maxMessage: 'entity.developer.programmingLanguages.length.max',
    )]
    #[ORM\Column(length: 255)]
    private ?string $programmingLanguages = null;

    #[ORM\Column]
    private ?bool $knowsMySQL = null;

    public function getIdeEnvironments(): ?string
    {
        return $this->ideEnvironments;
    }

    public function setIdeEnvironments(string $ideEnvironments): static
    {
        $this->ideEnvironments = $ideEnvironments;

        return $this;
    }

    public function getProgrammingLanguages(): ?string
    {
        return $this->programmingLanguages;
    }

    public function setProgrammingLanguages(string $programmingLanguages): static
    {
        $this->programmingLanguages = $programmingLanguages;

        return $this;
    }

    public function isKnowsMySQL(): ?bool
    {
        return $this->knowsMySQL;
    }

    public function setKnowsMySQL(bool $knowsMySQL): static
    {
        $this->knowsMySQL = $knowsMySQL;

        return $this;
    }
}
