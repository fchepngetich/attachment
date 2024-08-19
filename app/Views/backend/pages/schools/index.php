<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Manage Schools</h4>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#school-modal">
                    Add School
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-box">
                <div class="card-body">
                    <table class="table table-sm table-hover table-striped table-borderless" id="schools-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($schools as $school): ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= htmlspecialchars($school['name']) ?></td>
                                <td>
                                <button type="button" class="btn btn-sm btn-warning edit-school-btn" data-id="<?= $school['id'] ?>">
                                    <i class="fa fa-edit"></i>
                                </button>

                                    <button type="button" class="btn btn-sm btn-danger delete-school-btn" data-id="<?= $school['id'] ?>">
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
<?php include APPPATH . 'Views/backend/pages/modals/create-school-modal.php' ?>
<?php include APPPATH . 'Views/backend/pages/modals/edit-school-modal.php' ?>

</div>

<?= $this->endSection() ?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    $('#add-school-form').on('submit', function(e) {
        e.preventDefault();
        var csrfName = $('.ci_csrf_data').attr('name');
        var csrfHash = $('.ci_csrf_data').val();
        var form = this;
        var modal = $('#school-modal');
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
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
    $(document).ready(function() {
    $('.edit-school-btn').on('click', function() {
        var schoolId = $(this).data('id');
        console.log(schoolId);

        $.ajax({
            url: '<?= base_url('admin/school/edit') ?>',
            method: 'POST',
            data: {
                id: schoolId,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                console.log(response); // Log the response to check its structure
                if (response.status === 1) {
                    // Ensure 'response.data' is present and valid
                    if (response.data) {
                        $('#edit-school-id').val(response.data.id);
                        $('#edit-school-name').val(response.data.name);
                        $('#edit-school-modal').modal('show');
                    } else {
                        toastr.error('School data is missing in the response.');
                    }
                } else {
                    toastr.error(response.msg || 'Failed to fetch school data.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error); // Log error details
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});


$('#edit-school-form').on('submit', function(e) {
    e.preventDefault();

    var form = this;
    var formData = new FormData(form);
    var modal = $('#edit-school-modal');

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
                modal.modal('hide');
                toastr.success(response.msg);
                location.reload(); // Optional: Reload page to reflect changes
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

    $('.delete-school-btn').on('click', function() {
        var schoolId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure you want to delete this school?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: '<?= base_url('admin/school/delete') ?>/' + schoolId,
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

