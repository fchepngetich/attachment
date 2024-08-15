<!-- Edit Student Modal -->
<div class="modal fade" id="edit-student-modal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url('admin/students/update-student') ?>" id="edit-student-form" method="post">
            <div class="modal-header">
                <h4 class="modal-title" id="editStudentModalLabel">
                    Edit Student
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <?= csrf_field() ?>

                <input type="hidden" id="edit-student-id" name="id">

                <div class="form-group">
                    <label for="edit-name"><b>Full Name</b></label>
                    <input type="text" id="edit-name" name="name" class="form-control" required placeholder="Enter full name">
                    <span class="alert error name_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-email"><b>Email</b></label>
                    <input type="email" id="edit-email" name="email" class="form-control" required placeholder="Enter email">
                    <span class="alert error email_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-phone"><b>Phone</b></label>
                    <input type="text" id="edit-phone" name="phone" class="form-control" required placeholder="Enter phone number">
                    <span class="alert error phone_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-year_study"><b>Year of Study</b></label>
                    <select id="edit-year_study" name="year_study" class="form-control" required>
                        <option value="">Select Year</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                    <span class="alert error year_study_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-semester"><b>Semester</b></label>
                    <select id="edit-semester" name="semester" class="form-control" required>
                        <option value="">Select Semester</option>
                        <option value="1">1st Semester</option>
                        <option value="2">2nd Semester</option>
                    </select>
                    <span class="alert error semester_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-reg_no"><b>Registration Number</b></label>
                    <input type="text" id="edit-reg_no" name="reg_no" class="form-control" required placeholder="Enter registration number">
                    <span class="alert error reg_no_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-school"><b>School</b></label>
                    <select id="edit-school" name="school" class="form-control" required>
                        <option value="">Select School</option>
                        <option value="1">School of Engineering</option>
                        <option value="2">School of Business</option>
                        <option value="3">School of Medicine</option>
                        <option value="4">School of Arts and Humanities</option>
                        <option value="5">School of Education</option>
                    </select>
                    <span class="alert error school_error"></span>
                </div>

                <div class="form-group">
                    <label for="edit-course"><b>Course</b></label>
                    <select id="edit-course" name="course" class="form-control" required>
                        <option value="">Select Course</option>
                        <option value="1">Computer Science</option>
                        <option value="2">Business Administration</option>
                        <option value="3">Medicine</option>
                        <option value="4">Fine Arts</option>
                        <option value="5">Education</option>
                    </select>
                    <span class="alert error course_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>
