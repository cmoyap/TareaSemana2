<h1><?= e($title) ?></h1>

<form method="post" action="<?= url($action) ?>">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" maxlength="120" value="<?= e($entity->name) ?>" required>
        <?php if (isset($errors['name'])): ?>
            <small class="error"><?= e($errors['name']) ?></small>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="120" value="<?= e($entity->email) ?>" required>
        <?php if (isset($errors['email'])): ?>
            <small class="error"><?= e($errors['email']) ?></small>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="text" id="password" name="password" maxlength="255" value="<?= e($entity->password) ?>" required>
        <?php if (isset($errors['password'])): ?>
            <small class="error"><?= e($errors['password']) ?></small>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="created_at">Created at</label>
        <input type="datetime-local" id="created_at" name="created_at" value="<?= e($entity->created_at ? str_replace(' ', 'T', substr((string) $entity->created_at, 0, 16)) : '') ?>">
        <?php if (isset($errors['created_at'])): ?>
            <small class="error"><?= e($errors['created_at']) ?></small>
        <?php endif; ?>
    </div>

    <div class="buttons">
        <button class="btn" type="submit">Guardar</button>
        <a href="<?= url('users') ?>">Cancelar</a>
    </div>
</form>
