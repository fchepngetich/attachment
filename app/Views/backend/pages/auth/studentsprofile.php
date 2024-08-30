<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="page-header ">
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="title">
            <h4>My Profile</h4>
        </div>
    </div>
</div>
</div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="profile-box bg-white box-shadow border-radius-10 p-4">
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Full Name:</label>
                            <p class="text-muted"><?= esc($user['name']) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Email:</label>
                            <p class="text-muted"><?= esc($user['email']) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Phone:</label>
                            <p class="text-muted"><?= esc($user['phone']) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Registration Number:</label>
                            <p class="text-muted"><?= esc($user['reg_no']) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Year of Study:</label>
                            <p class="text-muted"><?= esc($user['year_study']) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Semester:</label>
                            <p class="text-muted"><?= esc($user['semester']) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">School:</label>
                            <p class="text-muted"><?= esc(getSchoolNameById($user['school'])) ?></p>
                        </div>
                        <div class="col-md-4 profile-item mb-2">
                            <label class="font-weight-bold">Course:</label>
                            <p class="text-muted"><?= esc(getCourseNameById($user['course'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
