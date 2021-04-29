<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player implements JsonSerializable
{
    public const POSITIONS = ['goalkeeper', 'defending', 'midfield', 'forward'];
    public const MSG_CREATED_SUCCESS = "Player creado exitosamente";
    public const MSG_MODIFIED_SUCCESS = "Player modificado exitosamente";
    public const MSG_DELETED_SUCCESS = "Player eliminado exitosamente";
    public const MSG_NOT_FOUND = "Player no encontrado";

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
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices=Player::POSITIONS, message="Choose a valid position.")
     * @Groups({"players_serialization"})
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"players_serialization"})
     */
    private $team;

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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function jsonSerialize () :array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'team' => $this->team,
        ];
    }
}
