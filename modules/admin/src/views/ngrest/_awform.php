<modal is-modal-hidden="activeWindowModal" modal-title="{{data.aw.title}}">
    <div ng-if="!activeWindowModal" compile-html ng-bind-html="data.aw.content"></div>
</modal>