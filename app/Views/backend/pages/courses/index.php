<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Manage Courses</h4>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-course-modal">
    Add Course
</button>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-box">
                <div class="card-body">
                    <table class="table table-sm table-hover table-striped table-borderless" id="courses-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($courses as $course): ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= htmlspecialchars($course['name']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-course-btn" data-id="<?= $course['id'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-course-btn" data-id="<?= $course['id'] ?>">
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

 
       <!-- Add School Modal -->
<?php include APPPATH . 'Views/backend/pages/modals/create-course-modal.php' ?>
<?php include APPPATH . 'Views/backend/pages/modals/edit-course-modal.php' ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script>
 $(document).ready(function() {
    $('#add-course-btn').on('click', function() {
        $('#create-course-modal').modal('show');
    });
    $('#add-course-form').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if (response.status === 1) {
                $(form)[0].reset();
                $('#create-course-modal').modal('hide');
                toastr.success(response.msg);
                location.reload();
            } else {
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
            toastr.error('An error occurred. Please try again.');
        }
    });
});

    $('.edit-course-btn').on('click', function() {
        
        var courseId = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/courses/edit') ?>',
            method: 'POST',
            data: {
                id: courseId,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 1) {
                    location.reload();
                } else {
                    toastr.error(response.msg || 'Failed to fetch course data.');
                }
            },
            error: function(xhr, status, error) {
            console.log(xhr.responseText); // Log the error message
            toastr.error('An error occurred. Please try again.');
            }

            
            }
        });
    });

    $('#edit-course-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if (response.token) {
                    $('input[name="<?= csrf_token() ?>"]').val(response.token);
                }
                if (response.status === 1) {
                    $('#edit-course-modal').modal('hide');
                    toastr.success(response.msg);
                    location.reload(); 
                } else if (response.status === 0) {
                    $.each(response.errors, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    // Delete Course

    $('.delete-course-btn').on('click', function() {
        var courseId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure you want to delete this course?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/courses/delete') ?>/' + courseId,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 1) {
                            Swal.fire(
                                'Deleted!',
                                response.msg,
                                'success'
                            );
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.msg,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'An error occurred. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});



</script>
<?= $this->endSection() ?>
