<!-- Confirm Assessment Modal -->
<div class="modal fade" id="confirmAssessmentModal" tabindex="-1" aria-labelledby="confirmAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmAssessmentModalLabel">Confirm Assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="confirm-assessment-form" action="<?= base_url('confirm-assessment') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="attachment_id" value="<?= $attachmentId ?>">

                    <div class="mb-3">
                        <label for="comments" class="form-label">Comments:</label>
                        <textarea name="comments" id="comments" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="signature" class="form-label">Signature:</label>
                        <canvas id="signature-pad" class="signature-pad border"></canvas>
                        <input type="hidden" name="signature" id="signature">
                    </div>

                    <button type="button" class="btn btn-secondary" id="clear-signature">Clear Signature</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm Assessment</button>
                </div>
            </form>
        </div>
    </div>
</div>