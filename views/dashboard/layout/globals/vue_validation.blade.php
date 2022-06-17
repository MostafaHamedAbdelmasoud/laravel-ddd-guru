<div class="kt-section" :class="{'kt-section--first': (validation_errors.length > 0)}" v-if="validation_errors.length > 0">
    <div class="kt-section__body">
        <div class="form-group row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <ul>
                        <li v-for="e in validation_errors">@{{ e }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
