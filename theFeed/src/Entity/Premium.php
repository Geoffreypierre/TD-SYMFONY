<?php

namespace App\Entity;

use App\Repository\PremiumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PremiumRepository::class)]
class Premium
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
