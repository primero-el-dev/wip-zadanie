<?php

namespace App\Entity;

use App\Entity\Tester;
use App\Entity\Developer;
use App\Entity\ProjectManager;
use App\Entity\CommonUser;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;
use App\Validator\UniqueField;

#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'job', type: 'string')]
#[ORM\DiscriminatorMap(User::JOB_SUBCLASS_MAP)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const JOB_SUBCLASS_MAP = [
        'tester' => Tester::class, 
        'developer' => Developer::class, 
        'project_manager' => ProjectManager::class,
        'common_user' => CommonUser::class,
    ];

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true, nullable: true)]
    private ?string $login = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Ignore]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[Assert\NotBlank(message: 'entity.user.email.notBlank')]
    #[Assert\Email(message: 'entity.user.email.email')]
    #[UniqueField(message: 'entity.user.email.uniqueField')]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'entity.user.name.notBlank')]
    #[Assert\Length(
        min: 2, 
        max: 40, 
        minMessage: 'entity.user.name.length.min', 
        maxMessage: 'entity.user.name.length.max',
    )]
    #[Assert\Regex(pattern: '/^\w+$/u', message: 'entity.user.name.regex')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'entity.user.surname.notBlank')]
    #[Assert\Length(
        min: 2, 
        max: 100, 
        minMessage: 'entity.user.surname.length.min', 
        maxMessage: 'entity.user.surname.length.max',
    )]
    #[Assert\Regex(pattern: '/^\w+(\-\w+)*$/u', message: 'entity.user.surname.regex')]
    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[Assert\Length(
        max: 65_535, // MySQL text type maximum length
        maxMessage: 'entity.user.description.length.max',
    )]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void {}

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getJob(): string
    {
        return array_flip(self::JOB_SUBCLASS_MAP)[get_class($this)];
    }
}
