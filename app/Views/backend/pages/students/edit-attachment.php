<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Edit Attachment Details</h4>
                </div>
              
            </div>
        </div>
    </div>

    <div class="container rounded shadow mt-5">
    <form action="<?= base_url('admin/attachment/update-attachment') ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= esc($attachmentDetails['id']) ?>">

    <div class="row">
        <!-- Company Name -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="<?= esc($attachmentDetails['company_name']) ?>" required>
            </div>
        </div>

        <!-- County -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="county">County</label>
                <select class="form-control" id="county" name="county" required>
                    <?php foreach ($counties as $key => $county): ?>
                        <option value="<?= $key ?>" <?= $key === $attachmentDetails['county'] ? 'selected' : '' ?>><?= $county ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Company Location -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_location">Company Location</label>
                <input type="text" class="form-control" id="company_location" name="company_location" value="<?= esc($attachmentDetails['company_location']) ?>" required>
            </div>
        </div>

        <!-- Company Email -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_email">Company Email</label>
                <input type="email" class="form-control" id="company_email" name="company_email" value="<?= esc($attachmentDetails['company_email']) ?>" required>
            </div>
        </div>

        <!-- Company Phone -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_phone">Company Phone</label>
                <input type="text" class="form-control" id="company_phone" name="company_phone" value="<?= esc($attachmentDetails['company_phone']) ?>" required>
            </div>
        </div>

        <!-- Start Date -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_start">Start Date</label>
                <input type="date" class="form-control" id="date_start" name="date_start" value="<?= esc($attachmentDetails['date_start']) ?>" required>
            </div>
        </div>

        <!-- End Date -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_end">End Date</label>
                <input type="date" class="form-control" id="date_end" name="date_end" value="<?= esc($attachmentDetails['date_end']) ?>" required>
            </div>
        </div>

        <!-- Google Map URL -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="google_map">Google Map URL</label>
                <input type="text" class="form-control" id="google_map" name="google_map" value="<?= esc($attachmentDetails['google_map']) ?>" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
    </form>

    </div>
<?= $this->endSection() ?>
