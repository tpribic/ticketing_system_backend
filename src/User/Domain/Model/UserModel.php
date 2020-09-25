<?php

declare(strict_types=1);

namespace App\User\Domain\Model;


use Symfony\Component\Validator\Constraints as Assert;

final class UserModel
{

    /**
     * @Assert\Email
     */
    private string $email;

    /**
     * @Assert\NotBlank()
     */
    private string $password;
    private string $name;
    private string $surname;
    private array $roles;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $role
     */
    public function setRoles(array $role): void
    {
        $this->roles = $role;
    }
}