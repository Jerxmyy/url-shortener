<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO {
    public function __construct(
        #[Assert\Email]
        public string $email,
    
        #[Assert\Length(min: 4)]
        public string $displayName,
    
        #[Assert\PasswordStrength]
        public string $password,
    ) {}
}