    <h3>{{ trans('general.data_controls') }}</h3>

    <div class="mb-4">
        <button data-which="findData" type="button" class="btn btn-primary btn-sm">{{ trans('general.find_sensitive_data') }}</button>
        <button data-which="anoynmizeData" type="button" class="btn btn-primary btn-sm">{{ trans('general.anonymize_data') }}</button>

    </div>

    <div class="mb-8">
        <div>
            <h3>{{ trans('general.filter_controls') }}</h3>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="PersNamesCheck" name="selectionFilter"
                       value="PERSON" checked>
                <label class="custom-control-label" for="PersNamesCheck">{{ trans('general.names_of_persons') }}</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="DateCheck" name="selectionFilter"
                       value="DATE" checked>
                <label class="custom-control-label" for="DateCheck">{{ trans('general.date_and_time') }}</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="LocatioCheck" name="selectionFilter"
                       value="LOCATION" checked>
                <label class="custom-control-label" for="CountriesCheck">Location</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="NumbersCheck" name="selectionFilter"
                       value="NUMBER" checked>
                <label class="custom-control-label" for="NumbersCheck">{{ trans('general.numbers') }}</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="MoneyCheck" name="selectionFilter"
                       value="MONEY" checked>
                <label class="custom-control-label" for="MoneyCheck">{{ trans('general.money') }}</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="OrganizationCheck" name="selectionFilter"
                       value="ORGANIZATION" checked>
                <label class="custom-control-label" for="MoneyCheck">Organisation</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="ArtCheck" name="selectionFilter"
                       value="WORK_OF_ART" checked>
                <label class="custom-control-label" for="MoneyCheck">WORK OF ART</label>
            </div>


        </div>

    </div>
