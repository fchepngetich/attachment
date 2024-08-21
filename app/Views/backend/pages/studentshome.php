<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                   
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                           
                        </ol>
                    </nav>
                </div>
               
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-body">
                        <table class="table table-sm table-hover table-striped table-borderless" id="students-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Year of Study</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Registration Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($students as $student): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $student['name'] ?></td>
                                    <td><?= $student['email'] ?></td>
                                    <td><?= $student['phone'] ?></td>
                                    <td><?= $student['year_study'] ?></td>
                                    <td><?= $student['semester'] ?></td>
                                    <td><?= $student['reg_no'] ?></td>
                                  
                                </tr>
                                <?php endforeach; ?>                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
    <?= $this->endSection() ?>
</div>
<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>



<?= $this->endSection() ?>
