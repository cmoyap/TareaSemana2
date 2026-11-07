<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;

interface UserRepositoryInterface
{
    /** @return User[] */
    public function all(): array;

    public function find(int $id): ?User;

    public function create(User $entity): int;

    public function update(User $entity): void;

    public function delete(int $id): void;
}
