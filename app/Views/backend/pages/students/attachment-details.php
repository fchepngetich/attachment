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

    <div class="container rounded shadow mt-5">
        <div class="row mb-3">
            <!-- Company Name -->
            <div class="col-md mt-4 -4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Company Name</h5>
                        <p class="card-text"><?= esc($attachmentDetails['company_name']) ?></p>
                    </div>
                </div>
            </div>
            <!-- County -->
            <div class="col-md-4 mt-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">County</h5>
                        <p class="card-text"><?= esc($attachmentDetails['county']) ?></p>
                    </div>
                </div>
            </div>
            <!-- Company Location -->
            <div class="col-md-4 mt-4 mb-2">
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
            <div class="col-md-4 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Assessment Status</h5>
                        <p class="card-text">
                        <p class="card-text">
                            <?php
                                $isSupervisorConfirmed = esc($attachmentDetails['is_assessment_confirmed']);
                                $isStudentConfirmed = esc($attachmentDetails['is_student_confirmed']);
                                
                                if ($isSupervisorConfirmed && $isStudentConfirmed) {
                                    echo '<span class="badge badge-success">Fully Assessed</span>';
                                } else {
                                    if ($isSupervisorConfirmed && !$isStudentConfirmed) {
                                        echo '<a href="' . base_url('/admin/students/confirm-assessment/' . esc($attachmentDetails['id'])) . '" class="btn btn-primary">Confirm Assessment</a>';
                                    } elseif (!$isSupervisorConfirmed) {
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    }
                                }
                            ?>
                        </p>



                       
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <a href="<?= base_url('admin/home') ?>" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
<?= $this->endSection() ?>
