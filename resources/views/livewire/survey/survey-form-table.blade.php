<div class="p-6 bg-white border-1 border-gray-300 rounded-4">
    <div>
        <section>
            <header>
                <h2 class="poppins-semibold text-lg">
                    {{ __('Tracer survey') }}
                </h2>

                <p class="mt-1 mb-1 text-sm text-gray-600">
                    {{ __("Below is the list of all tracer survey forms.") }}
                </p>
            </header>

            <ul class="nav nav-tabs mt-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="published-form-tab" data-bs-toggle="tab" 
                        data-bs-target="#published-form-tab-pane" type="button" role="tab" 
                        aria-controls="published-form-tab-pane" aria-selected="false">Published</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="unpublished-form-tab" data-bs-toggle="tab" 
                        data-bs-target="#unpublished-form-tab-pane" type="button" role="tab" 
                        aria-controls="unpublished-form-tab-pane" aria-selected="false">Unpublished</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="published-form-tab-pane" role="tabpanel" 
                    aria-labelledby="published-form-tab" tabindex="0">@livewire('survey.components.published-forms')</div>
                <div class="tab-pane fade" id="unpublished-form-tab-pane" role="tabpanel" 
                    aria-labelledby="unpublished-form-tab" tabindex="0">@livewire('survey.components.unpublished-forms')</div>
            </div>
        </section>
    </div>

    <script>
        function refreshSurveyFormTable() {
            setTimeout(function(){
                window.location.reload();
            }, 1000);
        }
    </script>
</div>
