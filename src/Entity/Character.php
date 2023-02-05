<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
#[ApiResource(
    operations:[
    new Get(),
    new GetCollection()]
)]
#[Uploadable]

class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $about = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Anime $anime = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favCharacters')]
    private Collection $usersFaving;

    #[UploadableField(mapping: 'characters', fileNameProperty:'img')]
    private ?File $file = null;
    public function __construct()
    {
        $this->usersFaving = new ArrayCollection();
    }

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

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getAnime(): ?Anime
    {
        return $this->anime;
    }

    public function setAnime(?Anime $anime): self
    {
        $this->anime = $anime;

        return $this;
    }

    public function __toString(){
        return $this->name;
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
            $usersFaving->addFavCharacter($this);
        }

        return $this;
    }

    public function removeUsersFaving(User $usersFaving): self
    {
        if ($this->usersFaving->removeElement($usersFaving)) {
            $usersFaving->removeFavCharacter($this);
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }
}
