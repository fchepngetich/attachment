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
                        <div class="col-md-6 profile-item mb-2">
                            <label class="font-weight-bold">Full Name:</label>
                            <p class="text-muted"><?= esc($user['full_name']) ?></p>
                        </div>
                        <div class="col-md-6 profile-item mb-2">
                            <label class="font-weight-bold">Email:</label>
                            <p class="text-muted"><?= esc($user['email']) ?></p>
                        </div>
                        <div class="col-md-6 profile-item mb-2">
                            <label class="font-weight-bold">Role:</label>
                            <p class="text-muted"><?= esc(getRoleNameById($user['role_id'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
