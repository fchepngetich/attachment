<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Students Attachment Details</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Students Attachment Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <table id="attachmentsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Company</th>
                    <th>Company Location</th>
                    <th>County</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Supervisor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attachments as $attachment): ?>
                    <tr>
                        <td><?= esc($attachment['student_name']) ?></td>
                        <td><?= esc($attachment['company_name']) ?></td>
                        <td><?= esc($attachment['company_location']) ?></td>
                        <td><?= esc($attachment['county']) ?></td>
                        <td><?= esc($attachment['date_start']) ?></td>
                        <td><?= esc($attachment['date_end']) ?></td>
                        <td>
                            <?php if ($attachment['supervisor']): ?>
                                <?= esc($attachment['supervisor']['full_name']) ?>
                            <?php else: ?>
                                Not Assigned
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($attachment['supervisor']): ?>
                                <a href="<?= base_url('admin/attachment/change-supervisor/' . $attachment['id']) ?>" class="btn btn-warning btn-sm">Change Supervisor</a>
                            <?php else: ?>
                                <a href="<?= base_url('admin/attachment/assign-supervisor/' . $attachment['id']) ?>" class="btn btn-primary btn-sm">Assign Supervisor</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

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
    $(document).ready(function() {
        $('#attachmentsTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
