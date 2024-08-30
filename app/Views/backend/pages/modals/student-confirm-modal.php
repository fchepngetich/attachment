<!-- Modal Markup: student-confirm-modal.php -->
<div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signatureModalLabel">Confirm Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="confirm-assessment-form" action="<?= base_url('admin/students/confirm-assessment') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="attachment_id" value="<?= $attachmentId ?>">

                    <!-- Comments Field -->
                    <div class="form-group mb-3">
                        <label for="comments">Comments:</label>
                        <textarea name="comments" id="comments" rows="4" class="form-control"></textarea>
                    </div>

                    <!-- Signature Field -->
                    <div class="form-group mb-3">
                        <label for="signature-pad">Signature:</label>
                        <canvas id="signature-pad" class="border border-secondary" width="300" height="150"></canvas>
                        <input type="hidden" name="signature" id="signature">
                        <button type="button" id="clear-signature" class="btn btn-sm btn-secondary mt-2">Clear Signature</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
