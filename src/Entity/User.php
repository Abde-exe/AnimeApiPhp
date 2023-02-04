<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Anime::class, inversedBy: 'usersFaving')]
    private Collection $favAnimes;

    #[ORM\ManyToMany(targetEntity: Character::class, inversedBy: 'usersFaving')]
    private Collection $favCharacters;

    public function __construct()
    {
        $this->favAnimes = new ArrayCollection();
        $this->favCharacters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getFavAnimes(): Collection
    {
        return $this->favAnimes;
    }

    public function addFavAnime(Anime $favAnime): self
    {
        if (!$this->favAnimes->contains($favAnime)) {
            $this->favAnimes->add($favAnime);
        }

        return $this;
    }

    public function removeFavAnime(Anime $favAnime): self
    {
        $this->favAnimes->removeElement($favAnime);

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getFavCharacters(): Collection
    {
        return $this->favCharacters;
    }

    public function addFavCharacter(Character $favCharacter): self
    {
        if (!$this->favCharacters->contains($favCharacter)) {
            $this->favCharacters->add($favCharacter);
        }

        return $this;
    }

    public function removeFavCharacter(Character $favCharacter): self
    {
        $this->favCharacters->removeElement($favCharacter);

        return $this;
    }
}
