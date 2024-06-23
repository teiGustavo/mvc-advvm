<tr>
    <td class="align-content-center" scope="row"><?= $report->getFormattedDate(); ?></td>
    <td class="align-content-center"><?= $report->getReport(); ?></td>
    <td class="align-content-center"><?= $report->getType(); ?></td>
    <td class="align-content-center"><?= $report->getAmountInBRLFormat(); ?></td>
    <th class="align-content-center">
        <a href="" data-bs-toggle="modal" data-bs-target="#updateModal" class="text-body" data-target="<?= $router->route('report.find'); ?>" data-update="<?= $report->getId(); ?>"><i class="bi bi-pencil-square fs-5"></i></a>
        <a href="#" class="text-body" data-target="<?= $router->route('report.delete'); ?>" data-delete="<?= $report->getId(); ?>"><i class="bi bi-trash fs-5"></i></a>
    </th>
</tr>