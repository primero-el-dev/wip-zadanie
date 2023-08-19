<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\TesterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TesterRepository::class)]
class Tester extends User
{
    #[Assert\NotBlank(message: 'entity.tester.testingSystems.notBlank')]
    #[Assert\Length(
        max: 255, 
        maxMessage: 'entity.tester.testingSystems.length.max',
    )]
    #[ORM\Column(length: 255)]
    private ?string $testingSystems = null;

    #[Assert\NotBlank(message: 'entity.tester.reportSystems.notBlank')]
    #[Assert\Length(
        max: 255, 
        maxMessage: 'entity.tester.reportSystems.length.max',
    )]
    #[ORM\Column(length: 255)]
    private ?string $reportSystems = null;

    #[ORM\Column]
    private ?bool $knowsSelenium = null;

    public function getTestingSystems(): ?string
    {
        return $this->testingSystems;
    }

    public function setTestingSystems(string $testingSystems): static
    {
        $this->testingSystems = $testingSystems;

        return $this;
    }

    public function getReportSystems(): ?string
    {
        return $this->reportSystems;
    }

    public function setReportSystems(string $reportSystems): static
    {
        $this->reportSystems = $reportSystems;

        return $this;
    }

    public function isKnowsSelenium(): ?bool
    {
        return $this->knowsSelenium;
    }

    public function setKnowsSelenium(bool $knowsSelenium): static
    {
        $this->knowsSelenium = $knowsSelenium;

        return $this;
    }
}
