<modal is-modal-hidden="activeWindowModal">
    <div class="modal-header">
        <h5 class="modal-title">Modal Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" compile-html ng-bind-html="data.aw.content" />
    <div class="modal-footer">
        <button type="button" class="btn btn-success">Save changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</modal>