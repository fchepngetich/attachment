<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header">
        <h4>Student Details</h4>
    </div>

    <div class="card">

<!-- views/attachment_details.php -->
<h2>Attachment Details</h2>

<?php if (!empty($attachments)): ?>
    <?php foreach ($attachments as $attachment): ?>
        <div class="row">
            <div class="col-md-4 mb-4">
                <p><strong>Company Name:</strong> <?= esc($attachment['company_name']) ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <p><strong>County:</strong> <?= esc($attachment['county']) ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <p><strong>Date Start:</strong> <?= esc($attachment['date_start']) ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <p><strong>Date End:</strong> <?= esc($attachment['date_end']) ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <p><strong>Visit Scheduled At:</strong> <?= esc($attachment['visit_scheduled_at']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No attachment details found for this student.</p>
<?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>

