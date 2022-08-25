<!-- Modal -->
<div class="modal fade" id="modal_send_message" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- modal-header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title2">Form message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- modal-body -->
            <div class="modal-body">
                <form id="form-modal_send_message" name="form-modal_send_message" enctype="multipart/form-data">
                    <div class="divId">
                        <input class="form-control" type="hidden" id="id" name="id">
                        {{-- <input class="form-control ids" type="hidden" id="ids" name="ids"> --}}
                    </div>

                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <select class="form-select" id="template" name="template">
                                    <option selected disabled>Choose...</option>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->message }}">{{ $template->name }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelectGrid">Template</label>
                                <span class="text-danger error-text template_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <textarea name="message" id="message" rows="10" class="form-control" placeholder="-" style="height: 200px;"></textarea>
                                <label for="message">Message</label>
                                <span class="text-danger error-text message_error"></span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- modal-footer -->
            <div class="modal-footer">
                <button id="closeBtn2" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="sendBtn" type="button" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>
