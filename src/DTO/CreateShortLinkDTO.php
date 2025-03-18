<?php

namespace App\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateShortLinkDTO
{
    public function __construct(
        #[Assert\Url]
        public string $url,

        #[Assert\Length(min: 4)]
        public ?string $shortCode = null,

        #[Assert\NotBlank(allowNull: true)]
        public ?string $title = null,

        #[Assert\Positive]
        public ?int $maxVisits = null,

        #[Assert\Type(DateTimeInterface::class)]
        public ?\DateTimeImmutable $validOn = null,

        #[Assert\Type(DateTimeInterface::class)]
        public ?\DateTimeImmutable $expiresAt = null,

        #[Assert\All([
            new Assert\Type('integer'),
            new Assert\Positive,
        ])]
        public array $tags = [],
    ) {}
}