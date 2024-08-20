<!-- Modal to Add Student -->
<div class="modal fade" id="student-modal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel"
    aria-hidden="true" style="display: none;" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url('admin/students/create-student') ?>" id="add-student-form"
            method="post">
            <div class="modal-header">
                <h4 class="modal-title" id="studentModalLabel">
                    Add Student
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="name"><b>Full Name</b></label>
                    <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                    <span class="alert error name_error"></span>
                </div>
                <div class="form-group">
                    <label for="email"><b>Email</b></label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter email">
                    <span class="alert error email_error"></span>
                </div>
                <div class="form-group">
                    <label for="phone"><b>Phone</b></label>
                    <input type="text" name="phone" class="form-control" required placeholder="Enter phone number">
                    <span class="alert error phone_error"></span>
                </div>
                <div class="form-group">
                    <label for="year_study"><b>Year of Study</b></label>
                    <select name="year_study" class="form-control" required>
                        <option value="">Select Year</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                    <span class="alert error year_study_error"></span>
                </div>

                <div class="form-group">
                    <label for="semester"><b>Semester</b></label>
                    <select name="semester" class="form-control" required>
                        <option value="">Select Semester</option>
                        <option value="1">1st Semester</option>
                        <option value="2">2nd Semester</option>
                    </select>
                    <span class="alert error semester_error"></span>
                </div>

                <div class="form-group">
                    <label for="reg_no"><b>Registration Number</b></label>
                    <input type="text" name="reg_no" class="form-control" required placeholder="Enter registration number">
                    <span class="alert error reg_no_error"></span>
                </div>

                <div class="form-group">
                    <label for="school"><b>School</b></label>
                    <select name="school" id="school" class="form-control" required>
                        <option value="">Select School</option>
                        <?php foreach ($schools as $school): ?>
                            <option value="<?= $school['id'] ?>"><?= $school['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="alert error school_error"></span>
                </div>
                
                <div class="form-group">
                    <label for="course"><b>Course</b></label>
                    <select name="course" id="course" class="form-control" required>
                        <option value="">Select Course</option>
                    </select>
                    <span class="alert error course_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary action">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>

