<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Manage Students</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Manage Students
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#student-modal">
                        Add Student
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-box">
                    <div class="card-body">
                        <table class="table table-sm table-hover table-striped table-borderless" id="students-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Year of Study</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Registration Number</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($students as $student): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $student['name'] ?></td>
                                    <td><?= $student['email'] ?></td>
                                    <td><?= $student['phone'] ?></td>
                                    <td><?= $student['year_study'] ?></td>
                                    <td><?= $student['semester'] ?></td>
                                    <td><?= $student['reg_no'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning edit-student-btn" data-id="<?= $student['id'] ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-student-btn" data-id="<?= $student['id'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Student Modal -->
        <?php include 'modals/create-student-modal.php'?>
        <!-- Edit Student Modal -->
        <?php include 'modals/edit-student-modal.php'?>
    </div>
    <?= $this->endSection() ?>
</div>
<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    // Add Student
    $('#add-student-form').on('submit', function(e) {
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
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
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
                        $.each(response.errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val);
                        });
                    } else {
                        toastr.error(response.msg);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr, status, error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    // Load student data into the modal
    $('.edit-student-btn').on('click', function() {
        var studentId = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/students/edit') ?>',
            method: 'GET',
            data: { id: studentId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 1) {
                    $('#edit-student-id').val(response.data.id);
                    $('#edit-name').val(response.data.name);
                    $('#edit-email').val(response.data.email);
                    $('#edit-phone').val(response.data.phone);
                    $('#edit-year_study').val(response.data.year_study);
                    $('#edit-semester').val(response.data.semester);
                    $('#edit-reg_no').val(response.data.reg_no);

                    $('#edit-student-modal').modal('show');
                } else {
                    toastr.error('Failed to fetch student data.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr, status, error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    $('#add-student-form').on('submit', function(e) {
    e.preventDefault();
    var csrfName = $('.ci_csrf_data').attr('name');
    var csrfHash = $('.ci_csrf_data').val();
    var form = this;
    var modal = $('#student-modal');
    var formData = new FormData(form);
    formData.append(csrfName, csrfHash);

    // Debugging: Log FormData contents
    console.log('FormData contents:');
    formData.forEach(function(value, key) {
        console.log(key + ': ' + value);
    });

    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formData,
        processData: false,
        dataType: 'json',
        contentType: false,
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
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
                    $.each(response.errors, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                } else {
                    toastr.error(response.msg);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", xhr, status, error);
            toastr.error('An error occurred. Please try again.');
        }
    });
});


    // Delete Student
    $('.delete-student-btn').on('click', function() {
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
                    success: function(response) {
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
                    error: function(xhr, status, error) {
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
