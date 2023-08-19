<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\ProjectManagerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectManagerRepository::class)]
class ProjectManager extends User
{
    #[Assert\NotBlank(message: 'entity.projectManager.projectManagementMethodologies.notBlank')]
    #[Assert\Length(
        max: 255, 
        maxMessage: 'entity.projectManager.projectManagementMethodologies.length.max',
    )]
    #[ORM\Column(length: 255)]
    private ?string $projectManagementMethodologies = null;

    #[Assert\NotBlank(message: 'entity.projectManager.reportSystems.notBlank')]
    #[Assert\Length(
        max: 255, 
        maxMessage: 'entity.projectManager.reportSystems.length.max',
    )]
    #[ORM\Column(length: 255)]
    private ?string $reportSystems = null;

    #[ORM\Column]
    private ?bool $knowsScrum = null;

    public function getProjectManagementMethodologies(): ?string
    {
        return $this->projectManagementMethodologies;
    }

    public function setProjectManagementMethodologies(string $projectManagementMethodologies): static
    {
        $this->projectManagementMethodologies = $projectManagementMethodologies;

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

    public function isKnowsScrum(): ?bool
    {
        return $this->knowsScrum;
    }

    public function setKnowsScrum(bool $knowsScrum): static
    {
        $this->knowsScrum = $knowsScrum;

        return $this;
    }
}
