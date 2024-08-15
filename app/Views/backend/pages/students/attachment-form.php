<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
    <div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Add Attachment Details</h4>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="container mt-5">
    <form action="<?= base_url('admin/students/attachment/store') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="county">County</label>
                <select class="form-control" id="county" name="county" required>
                    <?php foreach ($counties as $code => $name): ?>
                        <option value="<?= $code ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_location">Company Location</label>
                <input type="text" class="form-control" id="company_location" name="company_location">
            </div>
        </div>
     
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_email">Company Email</label>
                <input type="email" class="form-control" id="company_email" name="company_email">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="company_phone">Company Phone</label>
                <input type="text" class="form-control" id="company_phone" name="company_phone">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_start">Start Date</label>
                <input type="date" class="form-control" id="date_start" name="date_start" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_end">End Date</label>
                <input type="date" class="form-control" id="date_end" name="date_end" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="google_map">Google Map URL</label>
                <input type="text" class="form-control" id="google_map" name="google_map">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        <a href="javascript:history.back()" class="btn btn-sm btn-secondary ml-2">Cancel</a>
        </div>
</form>

</div>


<?= $this->endSection() ?>


