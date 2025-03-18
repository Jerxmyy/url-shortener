<?php

namespace App\Service;

use Faker;
use App\DTO\CreateShortLinkDTO;
use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShortLinkService
{
    public function __construct(
        private EntityManagerInterface $em,
        private ShortUrlRepository $shortLinkRepository,
    ) {}

    public function createShortLink(CreateShortLinkDTO $dto): ShortUrl {
        $shortLink = new ShortUrl();
        $shortLink->setUrl($dto->url);
        if ($dto->shortCode === null) {
            $shortLink->setShortCode($this->generateShortLink());
        } else {
            // Make sure it doesn't already exist, otherwise throw 409
            // throw new HttpException(Response::HTTP_CONFLICT, 'Short code already exists');
            $shortLink->setShortCode($dto->shortCode);
        }

        $shortLink
            ->setMaxVisits($dto->maxVisits)
            ->setValidOn($dto->validOn)
            ->setExpiresAt($dto->expiresAt);

        $this->em->persist($shortLink);
        $this->em->flush();

        return $shortLink;
    }

    public function generateShortLink(): string {
        $faker = Faker\Factory::create();
        $code = $faker->regexify('[A-Za-z0-9]{8}');
        // Check that code doesn't already exist
        // If it does, generate a new one
        return $code;
    }
}