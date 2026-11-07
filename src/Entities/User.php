<?php
declare(strict_types=1);

namespace App\Entities;

/** Una fila de la tabla users. */
final class User
{
    public function __construct(
        public ?int $id = null,
        public string $name = '',
        public string $email = '',
        public string $password = '',
        public string $created_at = '',
    ) {
    }

    public static function fromArray(array $d): self
    {
        return new self(
            id: (isset($d['id']) && $d['id'] !== '' ? (int) $d['id'] : null),
            name: (string) ($d['name'] ?? ''),
            email: (string) ($d['email'] ?? ''),
            password: (string) ($d['password'] ?? ''),
            created_at: (string) ($d['created_at'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'created_at' => $this->created_at,
        ];
    }
}
