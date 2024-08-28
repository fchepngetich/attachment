<!-- Schedule/Reschedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Schedule Visit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="scheduleForm" method="post" action="<?= base_url('admin/attachment/schedule/save'); ?>">
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="student_id" value="">
                    <div class="form-group">
                        <label for="visit_date">Visit Date</label>
                        <input type="date" class="form-control" name="visit_date" id="visit_date" required>
                    </div>
                    <div class="form-group">
                        <label for="visit_time">Visit Time</label>
                        <input type="time" class="form-control" name="visit_time" id="visit_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openScheduleModal(studentId, visitDate = '', visitTime = '') {
        $('#student_id').val(studentId);
        $('#visit_date').val(visitDate);
        $('#visit_time').val(visitTime);
        $('#scheduleModal').modal('show');
    }
</script>
