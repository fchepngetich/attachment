<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
    <div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Add Attachment Details</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Attachment Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="container mt-5">
  

    <form action="<?= base_url('admin/attachment/assign-supervisor/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="attachment_id" value="<?= esc($attachment['id']) ?>">
        <div class="form-group">
            <label for="supervisor_id">Supervisor</label>
            <select class="form-control" id="supervisor_id" name="supervisor_id" required>
                <option value="">Select Supervisor</option>
                <?php foreach ($supervisors as $supervisor): ?>
                    <option value="<?= esc($supervisor['id']) ?>"><?= esc($supervisor['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign</button>
        <a href="<?= base_url('admin/students') ?>" class="btn btn-secondary">Cancel</a>
    </form>

</div>


<?= $this->endSection() ?>


