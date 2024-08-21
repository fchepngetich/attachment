<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h5>Manage Students</h5>
                    </div>

                </div>
                <?php if (App\Libraries\CIAuth::role() === "1"): ?>

                <div class="col-md-2 col-sm-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#student-modal">
                        Add Student
                    </button>
                </div>
                <div class="col-md-2 col-sm-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#batch-upload-modal">
                        Upload
                    </button>
                </div>
                <?php endif;?>
            </div>
        </div>

        <form method="post" action="<?= base_url('admin/students/search') ?>">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="name" placeholder="Name" value="<?= esc($searchData['name'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="email" placeholder="Email" value="<?= esc($searchData['email'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?= esc($searchData['phone'] ?? '') ?>">
                </div>
            
                <div class="col-md-3">
                    <input type="text" class="form-control" name="reg_no" placeholder="Reg No" value="<?= esc($searchData['reg_no'] ?? '') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <select class="form-control" name="school_id">
                        <option value="">Select School</option>
                        <?php foreach ($schools as $school): ?>
                        <option value="<?= esc($school['id']) ?>" <?= (isset($searchData['school_id']) && $searchData['school_id'] == $school['id']) ? 'selected' : '' ?>>
                            <?= esc($school['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="course_id">
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course): ?>
                        <option value="<?= esc($course['id']) ?>" <?= (isset($searchData['course_id']) && $searchData['course_id'] == $course['id']) ? 'selected' : '' ?>>
                            <?= esc($course['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-info">Search</button>
                    <span>
                    <a href="<?= base_url('admin/home') ?>" class="btn btn-sm btn-info">Reset</a>
                    </span>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-body">
                        <table class="table table-sm table-hover table-striped table-borderless" id="students-table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Reg No</th>
                                    <?php if (App\Libraries\CIAuth::role() === "1"): ?>

                                    <th scope="col">Action</th>
                                    
                                    <?php endif;?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><?= $student['name'] ?></td>
                                        <td><?= $student['email'] ?></td>
                                        <td><?= $student['phone'] ?></td>
                                        <td><?= $student['year_study'] ?></td>
                                        <td><?= $student['semester'] ?></td>
                                        <td><?= $student['reg_no'] ?></td>
                                        <?php if (App\Libraries\CIAuth::role() === "1"): ?>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning edit-student-btn"
                                                data-id="<?= $student['id'] ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-student-btn"
                                                data-id="<?= $student['id'] ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <?php endif;?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Student Modal -->
        <?php include 'modals/create-student-modal.php' ?>
        <!-- Edit Student Modal -->
        <?php include 'modals/edit-student-modal.php' ?>
        <?php include 'modals/batch_students_modal.php' ?>

    </div>
    <?= $this->endSection() ?>
</div>
<?= $this->section('stylesheets')?>
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css">
<?= $this->endSection()?>

<?= $this->section('scripts') ?>
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        $('#students-table').DataTable({

        });
        $('#school').change(function () {
            var schoolId = $(this).val();
            if (schoolId) {
                $.ajax({
                    url: "<?= base_url('admin/students/get-courses-by-school/') ?>" + schoolId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#course').empty();
                        $('#course').append('<option value="">Select Course</option>');
                        $.each(data, function (key, value) {
                            $('#course').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#course').empty();
                $('#course').append('<option value="">Select Course</option>');
            }
        });


        $('#add-student-form').on('submit', function (e) {
            e.preventDefault();
            var csrfName = $('.ci_csrf_data').attr('name');
            var csrfHash = $('.ci_csrf_data').val();
            var form = this;
            var modal = $('#student-modal');
            var formData = new FormData(form);
            formData.append(csrfName, csrfHash);

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                processData: false,
                dataType: 'json',
                contentType: false,
                cache: false,
                beforeSend: function () {
                    toastr.remove();
                    $(form).find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.token) {
                        $('.ci_csrf_data').val(response.token);
                    }
                    if (response.status === 1) {
                        $(form)[0].reset();
                        modal.modal('hide');
                        toastr.success(response.msg);
                        location.reload();
                    } else if (response.status === 0) {
                        if (response.errors) {
                            $.each(response.errors, function (prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val);
                            });
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX request failed:", xhr, status, error);
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });



        $(document).ready(function () {
            $('.edit-student-btn').on('click', function () {
                var studentId = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('admin/students/edit') ?>',
                    method: 'GET',
                    data: { id: studentId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 1) {
                            $('#edit-student-id').val(response.data.id);
                            $('#edit-name').val(response.data.name);
                            $('#edit-email').val(response.data.email);
                            $('#edit-phone').val(response.data.phone);
                            $('#edit-year_study').val(response.data.year_study);
                            $('#edit-semester').val(response.data.semester);
                            $('#edit-reg_no').val(response.data.reg_no);
                            $('#edit-school').val(response.data.school);
                            $('#edit-course').val(response.data.course);



                            $('#edit-student-modal').modal('show');
                        } else {
                            toastr.error('Failed to fetch student data.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request failed:", xhr, status, error);
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });

            $('#edit-student-form').on('submit', function (e) {
                e.preventDefault();

                var form = this;
                var formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: formData,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    beforeSend: function () {
                        toastr.remove();
                        $(form).find('span.error-text').text('');
                    },
                    success: function (response) {
                        if (response.token) {
                            $('input[name="<?= csrf_token() ?>"]').val(response.token);
                        }
                        if (response.status === 1) {
                            $(form)[0].reset();
                            $('#edit-student-modal').modal('hide');
                            toastr.success(response.msg);
                            location.reload();
                        } else if (response.status === 0) {
                            toastr.error(response.msg);
                        } else {
                            if (response.errors) {
                                $.each(response.errors, function (prefix, val) {
                                    $(form).find('span.' + prefix + '_error').text(val);
                                });
                            } else {
                                toastr.error('An unexpected error occurred.');
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request failed:", xhr, status, error);
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });
        });

        // Delete Student
        $('.delete-student-btn').on('click', function () {
            var studentId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure you want to delete this student?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('admin/students/delete') ?>',
                        method: 'POST',
                        data: {
                            id: studentId,
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log('AJAX Response:', response);

                            if (response.token) {
                                $('.ci_csrf_data').val(response.token);
                            }
                            if (response.status === 1) {
                                Swal.fire(
                                    'Deleted!',
                                    response.msg,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                                $('#student-row-' + studentId).remove();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.msg,
                                    'error'
                                )
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX request failed:", xhr, status, error);
                            Swal.fire(
                                'Error!',
                                'An error occurred. Please try again.',
                                'error'
                            )
                        }
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>