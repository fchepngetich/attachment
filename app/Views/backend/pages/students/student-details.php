<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header">
        <h4>Student Details</h4>
    </div>

    <div class="card">
    <div class="row">
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Name</h5>
            <p class="card-text"><?= !empty($student['name']) ? esc($student['name']) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Email</h5>
            <p class="card-text"><?= !empty($student['email']) ? esc($student['email']) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Phone</h5>
            <p class="card-text"><?= !empty($student['phone']) ? esc($student['phone']) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">School</h5>
            <p class="card-text"><?= !empty($student['school']) ? esc(getSchoolNameById($student['school'])) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Course</h5>
            <p class="card-text"><?= !empty($student['course']) ? esc(getCourseNameById($student['course'])) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Year of Study</h5>
            <p class="card-text"><?= !empty($student['year_study']) ? esc($student['year_study']) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Semester</h5>
            <p class="card-text"><?= !empty($student['semester']) ? esc($student['semester']) : '-' ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title">Registration Number</h5>
            <p class="card-text"><?= !empty($student['reg_no']) ? esc($student['reg_no']) : '-' ?></p>
        </div>
    </div>

</div>


    </div>
</div>

<?= $this->endSection() ?>
