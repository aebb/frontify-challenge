<?php

namespace Frontify\ColorApi\Entity;

use DateTime;
use JsonSerializable;

class Color implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private string $hexCode;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    public function __construct(array $data)
    {
        $this->id        = $data['id'];
        $this->name      = $data['name'];
        $this->hexCode   = $data['hexCode'];
        $this->createdAt = new DateTime($data['createdAt']) ?? new DateTime();
        $this->updatedAt = new DateTime($data['updatedAt']) ?? new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHexCode(): string
    {
        return $this->hexCode;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setId(int $id): Color
    {
        $this->id = $id;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'hexCode'   => $this->hexCode,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }
}
