<div class="h-100">
    <section class="h-100">
        <div class="bg-white border-1 border-gray-300 rounded-4 h-100">
            <div class="p-6">
                <div>
                    <div>
                        <h2 class="font-medium poppins-semibold text-lg">Edit form</h2>

                        @if ($is_published)
                            <p class="mb-3 text-gray-600 text-sm">The form is currently published and cannot be modified.</p>
                        @else
                            <p class="mb-3 text-gray-600 text-sm">Edit/update survey form.</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        @if (!$is_published)
                            <x-link-btn href="{{ route('survey.form-edit', ['form_id' => $form_id]) }}">
                                <span>Edit</span>
                            </x-link-btn>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>