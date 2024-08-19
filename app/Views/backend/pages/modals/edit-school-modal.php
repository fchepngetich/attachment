<div class="modal fade" id="edit-school-modal" tabindex="-1" role="dialog" aria-labelledby="editSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-school-form" action="<?= base_url('admin/school/update') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSchoolModalLabel">Edit School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-school-id" name="id">
                    <div class="form-group">
                        <label for="edit-school-name">School Name</label>
                        <input type="text" class="form-control" id="edit-school-name" name="name" required>
                        <span class="error-text name_error"></span>
                    </div>
                    <!-- Add more fields as necessary -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update School</button>
                </div>
            </form>
        </div>
    </div>
</div>
