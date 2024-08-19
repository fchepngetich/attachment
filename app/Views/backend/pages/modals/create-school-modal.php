<div class="modal fade" id="school-modal" tabindex="-1" role="dialog" aria-labelledby="school-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="school-modalLabel">Add School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-school-form" action="<?= base_url('admin/school/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="school-name">School Name</label>
                        <input type="text" name="name" class="form-control" id="school-name" required>
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <input type="hidden" class="ci_csrf_data" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save School</button>
                </div>
            </form>
        </div>
    </div>
</div>
