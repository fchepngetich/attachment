<div class="modal fade" id="create-course-modal" tabindex="-1" role="dialog" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCourseModalLabel">Add New Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-course-form" action="<?= base_url('admin/courses/create') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="course-name">Course Name</label>
                        <input type="text" class="form-control" id="course-name" name="name" placeholder="Enter course name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="school-id">School</label>
                        <select class="form-control" id="school-id" name="school_id">
                            <?php foreach ($schools as $school): ?>
                                <option value="<?= $school['id'] ?>"><?= htmlspecialchars($school['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger error-text school_id_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Course</button>
                </div>
                <?= csrf_field(); ?>
            </form>
        </div>
    </div>
</div>
