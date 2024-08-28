<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>My Schedule</h4>
                </div>

            </div>
        </div>
    </div>

    <div class="">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('admin/attachment/my-schedule') ?>" method="post">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" name="name" value="<?= esc($search['name'] ?? '') ?>" class="form-control"
                        placeholder="Search by Name">
                </div>
                <div class="col-md-4">
                    <input type="text" name="company" value="<?= esc($search['company'] ?? '') ?>" class="form-control"
                        placeholder="Search by Company Name">
                </div>
                <div class="col-md-4">
                    <input type="text" name="county" value="<?= esc($search['county'] ?? '') ?>" class="form-control"
                        placeholder="Search by County">
                </div>
            </div>

            <div class="row mb-3">

                <div class="col-md-4">
                    <input type="text" id="start_date" class="form-control" name="start_date" placeholder="Start Date"
                        onfocus="(this.type='date')" onblur="if(!this.value) this.type='text';"
                        value="<?= esc($search['start_date'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" id="end_date" class="form-control" name="end_date" placeholder="End Date"
                        onfocus="(this.type='date')" onblur="if(!this.value) this.type='text';"
                        value="<?= esc($search['end_date'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    <a href="<?= base_url('admin/attachment/my-schedule') ?>" class="btn btn-sm btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="card card-box">
            <div class="card-body">
                <table id="studentsTable" class="table table-sm table-hover table-striped table-borderless">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>County</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Scheduled Visit Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        foreach ($students as $student): ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><a href="<?= base_url('admin/attachment/view/' . $student['id']) ?>"><?= $student['name']; ?>
                                </td>
                                <td><?= !empty($student['company_name']) ? $student['company_name'] : '-'; ?></td>
                                <td><?= !empty($student['county']) ? $student['county'] : '-'; ?></td>
                                <td><?= !empty($student['date_start']) ? $student['date_start'] : '-'; ?></td>
                                <td><?= !empty($student['date_end']) ? $student['date_end'] : '-'; ?></td>
                                <td><?= !empty($student['visit_scheduled_at']) ? $student['visit_scheduled_at'] : '-'; ?>
                                </td>
                                <td>
                                    <?php if ($student['is_assessment_confirmed']): ?>
                                        <a href="<?= base_url('admin/attachment/clear-schedule/' . $student['student_id']); ?>"
                                            class="btn btn-sm btn-secondary">
                                            Clear Schedule
                                        </a>
                                    <?php elseif ($student['visit_status'] === 'scheduled'): ?>
                                        <button class="btn btn-sm btn-secondary"
                                            onclick="openScheduleModal(<?= $student['student_id']; ?>)">
                                            Reschedule Visit
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="openScheduleModal(<?= $student['student_id']; ?>)">
                                            Schedule Visit
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php include APPPATH . 'Views/backend/pages/modals/schedule-modal.php' ?>
        </div>
    </div>

    <?= $this->section('stylesheets') ?>

    <link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css">
    <?= $this->endSection() ?>

    <?= $this->section('scripts') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>


    <script>

        function clearSchedule(studentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to clear the schedule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('admin/attachment/clear-schedule/') ?>' + studentId,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(
                                    'Cleared!',
                                    'The schedule has been cleared.',
                                    'success'
                                );

                                $('#studentsTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function openScheduleModal(studentId) {
            $('#student_id').val(studentId);
            $('#scheduleVisitModal').modal('show');
        }

        $(document).ready(function () {
            // Initialize the modal if necessary
            $('#scheduleVisitModal').modal({ show: false });
        });


        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            $('#studentsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

        });
    </script>
    <?= $this->endSection() ?>

    <?= $this->endSection() ?>