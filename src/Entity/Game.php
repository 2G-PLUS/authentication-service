<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @method string getUserIdentifier()
 */
class Game
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $link;


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'image'       => $this->image,
            'link'        => $this->link
        ];
    }
}