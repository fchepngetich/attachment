<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>System Logs</h4>
            </div>
        </div>   
         </div></div>
         <div class="card card-box">
        <div class="card-body">
    <table id="logs" class="table table-sm table-hover table-striped table-borderless">
        <thead>
        <?php if (!empty($logs) && is_array($logs)): ?>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Message</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
                <?php $count=1; foreach ($logs as $log): ?>
                    <tr>
                        <td><?= esc($count++) ?></td>
                        <td><?= esc(getUsernameById($log['user_id'])) ?></td>
                        <td><?= esc($log['action']) ?></td>
                        <td><?= esc($log['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div></div></div>

<?= $this->endSection() ?>

<?= $this->section('stylesheets')?>
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css">
<?= $this->endSection()?>

<?= $this->section('scripts') ?>
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        $('#logs').DataTable({

        });});

</script>
<?= $this->endSection()?>

