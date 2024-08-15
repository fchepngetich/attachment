<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
    <div class="container mb-5">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Manage Roles</h4>
                </div>
              
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#user-modal">
                    <a href="<?= base_url('/userroles') ?>">View Roles</a>
                </button>
            </div>
        </div>
    </div>       
<form action="<?= base_url('/userroles/update/' . $role['id']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="role_name">Role Name</label>
        <input type="text" class="form-control" id="role_name" name="role_name" value="<?= $role['name'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

    </div>
    <?= $this->endSection() ?>
