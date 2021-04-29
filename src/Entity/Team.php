<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team implements JsonSerializable
{
    public const MSG_CREATED_SUCCESS = "Team creado exitosamente";
    public const MSG_MODIFIED_SUCCESS = "Team modificado exitosamente";
    public const MSG_DELETED_SUCCESS = "Team eliminado exitosamente";
    public const MSG_NOT_FOUND = "Team no encontrado";
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"players_serialization"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"players_serialization"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=7)
     * @Groups({"players_serialization"})
     */
    private $hexColor;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="team", orphanRemoval=true)
     */
    private $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
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

    public function getHexColor(): ?string
    {
        return $this->hexColor;
    }

    public function setHexColor(?string $hexColor): self
    {
        $this->hexColor = $hexColor;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize () :array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hexColor' => $this->hexColor,
        ];
    }
}
