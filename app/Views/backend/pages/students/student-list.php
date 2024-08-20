<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>



    <div class="container">
    <div class="page-header">
                <div class="title">
                    <h4>Attached Students</h4>
                </div>
        </div>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <div class="card card-box">
        <div class="card-body">
        <table id="attachmentsTable" class="table table-sm table-hover table-striped table-borderless">
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
                        <?php if ($attachment['supervisor'] && !$attachment['supervisor_comments']) : ?>
                            <a href="<?= base_url('admin/attachment/change-supervisor/' . $attachment['id']) ?>" class="btn btn-warning btn-sm">Change Supervisor</a>
                            <?php else: ?>
                                <a href="<?= base_url('admin/attachment/view/' . $attachment['id']) ?>" class="btn btn-primary btn-sm">View Details</a>
                                <?php endif; ?>
                            <?php if (!$attachment['supervisor'] ) : ?>
                            <a href="<?= base_url('admin/attachment/assign-supervisor/' . $attachment['id']) ?>" class="btn btn-warning btn-sm">Assign Supervisor</a>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> </div> </div>
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
            
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
