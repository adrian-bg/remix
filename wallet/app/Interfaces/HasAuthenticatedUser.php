<?php

namespace App\Interfaces;

interface HasAuthenticatedUser
{
    public function setId(int $id): HasAuthenticatedUser;

    public function setName(string $name): HasAuthenticatedUser;

    public function setEmail(string $email): HasAuthenticatedUser;

    public function getId(): int;

    public function getName(): string;

    public function getEmail(): string;

}
