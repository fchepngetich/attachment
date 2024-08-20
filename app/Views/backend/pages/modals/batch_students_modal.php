<!-- Modal to Batch Upload Students -->
<div class="modal fade" id="batch-upload-modal" tabindex="-1" role="dialog" aria-labelledby="batchUploadModalLabel"
    aria-hidden="true" style="display: none;" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url('admin/students/batch-upload') ?>" id="batch-upload-form"
            method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title" id="batchUploadModalLabel">
                    Upload Students
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="students_csv"><b>Upload CSV File</b></label>
                    <input type="file" name="students_csv" class="form-control" required>
                    <span class="alert error students_csv_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary action">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
