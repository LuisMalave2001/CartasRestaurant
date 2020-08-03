<div class="modal fade" id="create-or-edit-modal"
data-backdrop="static"
tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-form">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary modal-submit-button"></button>
            </div>
        </div>
    </div>
</div>

<div style="display: none">
    @include('settings.forms.product')
    @include('settings.forms.menu')
    @include('settings.forms.carte_menu')
</div>
