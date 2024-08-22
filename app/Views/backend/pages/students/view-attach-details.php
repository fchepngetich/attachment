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
        <div class="details card">
    <div class="row">
        <div class="col-md-4">
            <div  class="card-body">
                <dt>Student Name:</dt>
                <dd><?= esc($student['name']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Company Name:</dt>
                <dd><?= esc($attachment['company_name']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Company Location:</dt>
                <dd><?= esc($attachment['company_location']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>County:</dt>
                <dd><?= esc($attachment['county']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Company Email:</dt>
                <dd><?= esc($attachment['company_email']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Company Phone:</dt>
                <dd><?= esc($attachment['company_phone']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Start Date:</dt>
                <dd><?= esc($attachment['date_start']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>End Date:</dt>
                <dd><?= esc($attachment['date_end']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Google Map Location:</dt>
                <dd><a href="<?= esc($attachment['google_map']) ?>" target="_blank">View Location</a></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Supervisor:</dt>
                <dd><?= esc($supervisor['full_name']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Supervisor Comments:</dt>
                <dd><?= esc($attachment['supervisor_comments']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Assessment Confirmed At:</dt>
                <dd><?= esc($attachment['assessment_confirmed_at']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Assessment Status:</dt>
                <dd>
                    <?php if ($attachment['is_assessment_confirmed']): ?>
                        <span class="badge badge-success">Assessed</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Pending Assessment</span>
                    <?php endif; ?>
                </dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Student Confirmation Date:</dt>
                <dd><?= esc($attachment['student_confirmation_date']) ?></dd>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body">
                <dt>Student Confirmation:</dt>
                <dd><?= $attachment['is_student_confirmed'] ? 'Confirmed' : 'Not Confirmed' ?></dd>
            </div>
        </div>
    </div>

    <div class="card-body mt-3">
        <a href="javascript:history.back()" class="btn btn-sm btn-info">Go Back</a>
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



