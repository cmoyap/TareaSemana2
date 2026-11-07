<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use PDO;

final class UserRepository implements UserRepositoryInterface
{
    private const WRITABLE = ['name', 'email', 'password', 'created_at'];

    public function __construct(private PDO $pdo)
    {
    }

    public function all(): array
    {
        $rows = $this->pdo
            ->query('SELECT * FROM "users" ORDER BY "id" DESC')
            ->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            [User::class, 'fromArray'],
            $rows
        );
    }

    public function find(int $id): ?User
    {
        $st = $this->pdo->prepare(
            'SELECT * FROM "users" WHERE "id" = :id'
        );

        $st->execute(['id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);

        return $row ? User::fromArray($row) : null;
    }

    public function create(User $entity): int
    {
        $sql = '
            INSERT INTO "users" ("name", "email", "password", "created_at")
            VALUES (:name, :email, :password, :created_at)
            RETURNING "id"
        ';

        $st = $this->pdo->prepare($sql);
        $st->execute($this->data($entity));

        return (int) $st->fetchColumn();
    }

    public function update(User $entity): void
    {
        $sql = '
            UPDATE "users"
            SET "name" = :name, "email" = :email, "password" = :password, "created_at" = :created_at
            WHERE "id" = :__pk
        ';

        $st = $this->pdo->prepare($sql);

        $st->execute(
            $this->data($entity) + [
                '__pk' => $entity->id
            ]
        );
    }

    public function delete(int $id): void
    {
        $st = $this->pdo->prepare(
            'DELETE FROM "users" WHERE "id" = :id'
        );

        $st->execute(['id' => $id]);
    }

    private function data(User $entity): array
    {
        return array_intersect_key(
            $entity->toArray(),
            array_flip(self::WRITABLE)
        );
    }
}
