<!-- Modal -->
<div class="modal fade" id="modal_auto_message" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- modal-header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title2">Form auto message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body">

                <div class="alert alert-info">
                    <strong>Field:</strong><br>
                    {name}, {address}, {gender}, {email}, {hp}, {created_at}, {updated_at}
                </div>

                <form id="form-modal_auto_message" name="form-modal_auto_message" enctype="multipart/form-data">
                    <div class="divId">
                        <input class="form-control" type="hidden" id="auto_id" name="id">
                    </div>

                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" name="name" id="auto_name" class="form-control" value="Lorem5"
                                    placeholder="-" readonly>
                                <label for="floatingSelectGrid">Name</label>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <textarea name="message" id="auto_message" rows="10" class="form-control" placeholder="-" style="height: 200px;"></textarea>
                                <label for="message">Message</label>
                                <span class="text-danger error-text message_error"></span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- modal-footer -->
            <div class="modal-footer">
                <button id="closeBtn3" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="saveBtn2" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
