<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>My Attachment Details</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container rounded shadow mt-5">
        <?php if ($hasAttachment): ?>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Company Name -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Company Name</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['company_name']) ? esc($attachmentDetails['company_name']) : '-' ?>
                                    </p>
                                </div>
                                <!-- County -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">County</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['county']) ? esc($attachmentDetails['county']) : '-' ?>
                                    </p>
                                </div>
                                <!-- Company Location -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Company Location</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['company_location']) ? esc($attachmentDetails['company_location']) : '-' ?>
                                    </p>
                                </div>
                                <!-- Company Email -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Company Email</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['company_email']) ? esc($attachmentDetails['company_email']) : '-' ?>
                                    </p>
                                </div>
                                <!-- Company Phone -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Company Phone</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['company_phone']) ? esc($attachmentDetails['company_phone']) : '-' ?>
                                    </p>
                                </div>
                                <!-- Start Date -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Start Date</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['date_start']) ? esc($attachmentDetails['date_start']) : '-' ?>
                                    </p>
                                </div>
                                <!-- End Date -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">End Date</h5>
                                    <p class="card-text">
                                        <?= !empty($attachmentDetails['date_end']) ? esc($attachmentDetails['date_end']) : '-' ?>
                                    </p>
                                </div>
                                <!-- Google Map URL -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Google Map URL</h5>
                                    <p class="card-text">
                                        <?php if (!empty($attachmentDetails['google_map'])): ?>
                                            <a href="<?= esc($attachmentDetails['google_map']) ?>"
                                                target="_blank"><?= esc($attachmentDetails['google_map']) ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <!-- Assessment Status -->
                                <div class="col-md-4 mb-3">
                                    <h5 class="card-title">Assessment Status</h5>
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
                            <div class="form-group mb-3">

                                <a href="javascript:history.back()" class="btn btn-sm btn-info">Back</a>
                                <?php if (empty($attachmentDetails['supervisor_id'])): ?>
                                    <span>
                                        <a href="<?= base_url('admin/attachment/edit-attachment/' . esc($attachmentDetails['id'])) ?>"
                                            class="btn btn-sm btn-warning">Edit Details</a>
                                    </span>
                                <?php endif; ?>


                            </div>
                        </div>

                    </div>

                </div>

            </div>


        <?php else: ?>
            <div class="alert alert-info">
                <h6>You have no attachment details ,please fill the the attachment details form first</h6>
                <!-- <a href="<?= base_url('admin/attachmentlist') ?>" class="btn btn-sm btn-secondary">Back</a> -->
            </div>
        <?php endif; ?>
    </div>
    <?= $this->endSection() ?>