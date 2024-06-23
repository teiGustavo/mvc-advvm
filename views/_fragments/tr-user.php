<tr>
    <td class="align-content-center" scope="row"><?= $user->getEmail(); ?></td>
    <td class="align-content-center"><?= $user->getRoleName(); ?></td>
    <th class="align-content-center">
        <a href="<?= $router->route('user.find'); ?>" class="text-body text-decoration-none" data-update="<?= $user->getId(); ?>" data-bs-toggle="modal" data-bs-target="#updateUserModal">
            <i class="bi bi-pencil-square fs-5"></i>
        </a>
        <a href="<?= $router->route('user.delete'); ?>" class="text-body" data-delete="<?= $user->getId(); ?>">
            <i class="bi bi-trash fs-5"></i>
        </a>
    </th>
</tr>