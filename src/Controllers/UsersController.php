<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Entities\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use PDOException;

final class UsersController extends Controller
{
    private UserService $service;

    public function __construct(?UserService $service = null)
    {
        parent::__construct();

        $this->service = $service
            ?? new UserService(
                new UserRepository(Database::connection())
            );
    }

    public function index(): void
    {
        $this->render(
            'users/index',
            ['items' => $this->service->list()],
            'Users'
        );
    }

    public function create(): void
    {
        $this->form(new User(), [], 'users/store', 'Nuevo User');
    }

    public function store(): void
    {
        $this->requirePost();

        $entity = User::fromArray($this->request->allPost());
        $errors = $this->service->validate($entity);

        if ($errors) {
            $this->form($entity, $errors, 'users/store', 'Nuevo User');
            return;
        }

        $this->service->create($entity);

        $this->redirect('users', 'Registro creado correctamente.');
    }

    public function edit(?int $id = null): void
    {
        $entity = $this->service->get((int) $id);

        $this->form(
            $entity,
            [],
            'users/update/' . $entity->id,
            'Editar User'
        );
    }

    public function update(?int $id = null): void
    {
        $this->requirePost();

        $this->service->get((int) $id);

        $entity = User::fromArray($this->request->allPost());
        $entity->id = (int) $id;

        $errors = $this->service->validate($entity);

        if ($errors) {
            $this->form(
                $entity,
                $errors,
                'users/update/' . $id,
                'Editar User'
            );
            return;
        }

        $this->service->update($entity);

        $this->redirect('users', 'Registro actualizado correctamente.');
    }

    public function delete(?int $id = null): void
    {
        $this->requirePost();

        $this->service->get((int) $id);

        try {
            $this->service->delete((int) $id);
        } catch (PDOException) {
            $this->redirect(
                'users',
                'No se pudo eliminar: el registro esta en uso.',
                'error'
            );
        }

        $this->redirect('users', 'Registro eliminado.');
    }

    private function form(
        User $entity,
        array $errors,
        string $action,
        string $title
    ): void {
        $this->render(
            'users/form',
            compact('entity', 'errors', 'action'),
            $title
        );
    }
}
