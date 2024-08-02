<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Categories</h4>
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

    <div class="row">
 <H1>This is student's page.</H1>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="<?= base_url('public/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<link rel="stylesheet" href="<?= base_url('public/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css') ?>">

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?= base_url('public/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js') ?> "></script>
<script>
$(document).ready(function() {

    
});
</script>
<?= $this->endSection() ?>
