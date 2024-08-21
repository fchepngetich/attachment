<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Attachment Details</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
            <div class=" card card-body">
                <div class="row">
                    <div class="col-md-4 detail-item">
                        <dt>Student Name:</dt>
                        <dd><?= esc($student['name']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Company Name:</dt>
                        <dd><?= esc($attachment['company_name']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Company Location:</dt>
                        <dd><?= esc($attachment['company_location']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>County:</dt>
                        <dd><?= esc($attachment['county']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Company Email:</dt>
                        <dd><?= esc($attachment['company_email']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Company Phone:</dt>
                        <dd><?= esc($attachment['company_phone']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Start Date:</dt>
                        <dd><?= esc($attachment['date_start']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>End Date:</dt>
                        <dd><?= esc($attachment['date_end']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Google Map Location:</dt>
                        <dd><a href="<?= esc($attachment['google_map']) ?>" target="_blank">View Location</a></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Supervisor:</dt>
                        <dd><?= esc($supervisor['full_name']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Supervisor Comments:</dt>
                        <dd><?= esc($attachment['supervisor_comments']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Assessment Confirmed At:</dt>
                        <dd><?= esc($attachment['assessment_confirmed_at']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Assessment Status:</dt>
                        <dd>
                            <?php if ($attachment['is_assessment_confirmed']): ?>
                                <span class="badge badge-success">Assessed</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Pending Assessment</span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Student Confirmation Date:</dt>
                        <dd><?= esc($attachment['student_confirmation_date']) ?></dd>
                    </div>
                    <div class="col-md-4 detail-item">
                        <dt>Student Confirmation:</dt>
                        <dd><?= $attachment['is_student_confirmed'] ? 'Confirmed' : 'Not Confirmed' ?></dd>
                    </div>
                </div>
                <div class="mt-3">
            <a href="<?= base_url('admin/attachment/get') ?>" class="btn btn-sm btn-info">Back to Attachments</a>
        </div>
            </div>
           
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
        $('#studentsTable').DataTable({
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



