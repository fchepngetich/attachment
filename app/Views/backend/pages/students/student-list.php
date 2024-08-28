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
    <form id="search-form" action="<?= base_url('admin/attachment/search-attached-students') ?>" method="POST" class="mb-3">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" class="form-control" name="student_name" placeholder="Student Name" value="<?= esc($searchData['student_name'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?= esc($searchData['company_name'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="supervisor" placeholder="Supervisor" value="<?= esc($searchData['supervisor'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="county" placeholder="County" value="<?= esc($searchData['county'] ?? '') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="start_date" class="form-control" name="start_date" placeholder="Start Date"
                    onfocus="(this.type='date')" 
                    onblur="if(!this.value) this.type='text';" 
                    value="<?= esc($searchData['start_date'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="text" id="end_date" class="form-control" name="end_date" placeholder="End Date"
                    onfocus="(this.type='date')" 
                    onblur="if(!this.value) this.type='text';" 
                    value="<?= esc($searchData['end_date'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-info">Search</button>
                <a href="<?= base_url('admin/attachment/get') ?>" class="btn btn-sm btn-primary">Reset</a>
            </div>
        </div>
    </form>

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
                        <?php if (App\Libraries\CIAuth::role() === "1" | App\Libraries\CIAuth::role() === "2"): ?>

                        <th>Action</th>
                        
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attachments as $attachment): ?>
                        <tr>
                            <td>
                            <a href="<?= base_url('admin/students/details/' . $attachment['student_id']) ?>">
                            <?= esc($attachment['student_name']) ?>                                        </a>
                        
                        
                        </td>
                            <td><?= esc($attachment['company_name']) ?></td>
                            <td><?= esc($attachment['company_location']) ?></td>
                            <td><?= esc($attachment['county']) ?></td>
                            <td><?= esc($attachment['date_start']) ?></td>
                            <td><?= esc($attachment['date_end']) ?></td>
                            <td>
                                <?php 
                                    if (!empty($attachment['supervisor_id']) && ($supervisorUsername = getUsernameById($attachment['supervisor_id']))) {
                                        echo esc($supervisorUsername);
                                    } else {
                                        echo 'Not Assigned';
                                    }
                                ?>
                            </td>
                            <?php if (App\Libraries\CIAuth::role() === "1" | App\Libraries\CIAuth::role() === "2"): ?>

                            <td>
                                <?php if ($attachment['supervisor_id'] && !$attachment['supervisor_comments']) : ?>
                                    <a href="<?= base_url('admin/attachment/change-supervisor/' . $attachment['id']) ?>" class="btn btn-warning btn-sm">Change Supervisor</a>
                                <?php elseif($attachment['supervisor_id'] && $attachment['supervisor_comments']): ?>
                                    <a href="<?= base_url('admin/attachment/view/' . $attachment['id']) ?>" class="btn btn-primary btn-sm">
                                        Attachment Details</a>
                                <?php endif; ?>
                                <?php if (!$attachment['supervisor_id']) : ?>
                                    <a href="<?= base_url('admin/attachment/assign-supervisor/' . $attachment['id']) ?>" class="btn btn-warning btn-sm">Assign Supervisor</a>
                                <?php endif; ?>
                            </td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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
        $('#attachmentsTable').DataTable({});
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
