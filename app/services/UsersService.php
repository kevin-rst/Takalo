<?php

namespace app\services;

use app\repositories\UsersRepository;

class UsersService
{
    private $repo;
    public function __construct(UsersRepository $repo)
    {
        $this->repo = $repo;
    }

    public function register(array $values, $plainPassword, $role)
    {
        $hash = password_hash((string)$plainPassword, PASSWORD_DEFAULT);
        
        return $this->repo->create(
            $values['nom'],
            $values['email'],
            $hash,
            $role
        );
    }
}
