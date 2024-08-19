<div class="modal fade" id="edit-course-modal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-course-form" action="<?= base_url('admin/courses/update') ?>" method="post">
                <input type="hidden" id="edit-course-id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-course-name">Course Name</label>
                        <input type="text" class="form-control" id="edit-course-name" name="name" placeholder="Enter course name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
                <?= csrf_field(); ?>
            </form>
        </div>
    </div>
</div>
