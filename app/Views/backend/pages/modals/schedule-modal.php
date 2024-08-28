<!-- Schedule Visit Modal -->
<div class="modal fade" id="scheduleVisitModal" tabindex="-1" aria-labelledby="scheduleVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="scheduleVisitForm" method="post" action="<?= base_url('admin/attachment/schedule-visit') ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleVisitModalLabel">Schedule Visit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="student_id" id="student_id">
                    <div class="form-group">
                        <label for="visit_date">Date</label>
                        <input type="date" class="form-control" name="visit_date" id="visit_date" required>
                    </div>
                    <div class="form-group">
                        <label for="visit_time">Time</label>
                        <input type="time" class="form-control" name="visit_time" id="visit_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
