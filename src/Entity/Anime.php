<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeRepository::class)]
#[ApiResource]
class Anime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $genres = [];

    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Character::class, orphanRemoval: true)]
    private Collection $characters;

    #[ORM\ManyToOne(inversedBy: 'animes')]
    private ?Studio $studio = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favAnimes')]
    private Collection $usersFaving;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->usersFaving = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function setGenres(?array $genres): self
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setAnime($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getAnime() === $this) {
                $character->setAnime(null);
            }
        }

        return $this;
    }

    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    public function setStudio(?Studio $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersFaving(): Collection
    {
        return $this->usersFaving;
    }

    public function addUsersFaving(User $usersFaving): self
    {
        if (!$this->usersFaving->contains($usersFaving)) {
            $this->usersFaving->add($usersFaving);
            $usersFaving->addFavAnime($this);
        }

        return $this;
    }

    public function removeUsersFaving(User $usersFaving): self
    {
        if ($this->usersFaving->removeElement($usersFaving)) {
            $usersFaving->removeFavAnime($this);
        }

        return $this;
    }
}
