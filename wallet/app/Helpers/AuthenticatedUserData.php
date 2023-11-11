<?php

namespace App\Helpers;

use App\Interfaces\HasAuthenticatedUser;

class AuthenticatedUserData implements HasAuthenticatedUser
{
    protected int $id;
    protected string $name;
    protected string $email;

    /**
     * @param int $id
     * @return HasAuthenticatedUser
     */
    public function setId(int $id): HasAuthenticatedUser
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     * @return HasAuthenticatedUser
     */
    public function setName(string $name): HasAuthenticatedUser
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $email
     * @return HasAuthenticatedUser
     */
    public function setEmail(string $email): HasAuthenticatedUser
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
