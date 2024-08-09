<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>My Attachment Details</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            My Attachment Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Company Name -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Company Name</h5>
                        <p class="card-text"><?= esc($attachmentDetails['company_name']) ?></p>
                    </div>
                </div>
            </div>
            <!-- County -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">County</h5>
                        <p class="card-text"><?= esc($attachmentDetails['county']) ?></p>
                    </div>
                </div>
            </div>
            <!-- Company Location -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Company Location</h5>
                        <p class="card-text"><?= esc($attachmentDetails['company_location']) ?></p>
                    </div>
                </div>
            </div>
            <!-- Company Email -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Company Email</h5>
                        <p class="card-text"><?= esc($attachmentDetails['company_email']) ?></p>
                    </div>
                </div>
            </div>
            <!-- Company Phone -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Company Phone</h5>
                        <p class="card-text"><?= esc($attachmentDetails['company_phone']) ?></p>
                    </div>
                </div>
            </div>
            <!-- Start Date -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Start Date</h5>
                        <p class="card-text"><?= esc($attachmentDetails['date_start']) ?></p>
                    </div>
                </div>
            </div>
            <!-- End Date -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">End Date</h5>
                        <p class="card-text"><?= esc($attachmentDetails['date_end']) ?></p>
                    </div>
                </div>
            </div>
            <!-- Google Map URL -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Google Map URL</h5>
                        <p class="card-text">
                            <a href="<?= esc($attachmentDetails['google_map']) ?>" target="_blank"><?= esc($attachmentDetails['google_map']) ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
            <a href="<?= base_url('admin/home') ?>" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
<?= $this->endSection() ?>
