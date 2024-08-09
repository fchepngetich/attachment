<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Students Due For Attachment</h4>
                </div>
                 <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Students List
                        </li>
                    </ol>
                </nav>
            </div>
           
        </div>
    </div>

<div class="container mt-5">
    <table id="studentsTable" class="table table-sm table-hover table-striped table-borderless rounded shadow" style="width:100%;" role="grid">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Year of Study</th>
                <th>Semester</th>
                <th>Registration Number</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($students)): ?>
                <?php $count=1; foreach($students as $student): ?>
                    <tr>
                        <td><?= esc($count++) ?></td>
                        
                        <td><?= esc($student['name']); ?></td>
                        <td><?= esc($student['email']); ?></td>
                        <td><?= esc($student['phone']); ?></td>
                        <td><?= esc($student['year_study']); ?></td>
                        <td><?= esc($student['semester']); ?></td>
                        <td><?= esc($student['reg_no']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>



</div>

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
