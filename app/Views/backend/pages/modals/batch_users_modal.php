<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url('admin/upload-users') ?>" id="upload-users-form" method="post" enctype="multipart/form-data">
            <!-- Modal content for uploading a file -->
            <div class="modal-header">
                <h4 class="modal-title" id="uploadModalLabel">
                    Upload Users
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="user_file"><b>Upload File</b></label>
                    <input type="file" name="user_file" class="form-control" required accept=".csv">
                    <span class="alert error user_file_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>