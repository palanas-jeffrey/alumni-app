<div class="w-100 pb-4 pt-4">
    @if($field->type == "text" || $field->type == "number" || $field->type == "date")
        <div>
            <x-input-label for="field_{{ $field->id }}" class="mb-3">
                <strong>
                    {{ $order }}.
                    {{ $field->field_label }}
                    @if($field->required)
                        {{"*"}}
                    @endif
                </strong>
            </x-input-label>
            <x-text-input 
                id="field_{{ $field->id }}" 
                name="field_{{ $field->id }}"
                type="{{$field->type}}" 
                class="mt-1 block w-full"
                data-section-id="{{$section_id}}"
                :required="$field->required == 1"
            />
            <x-input-error class="mt-2" :messages="$errors->get('field_' . $field->id)" />
        </div>
    @elseif($field->type == "textarea")
        <div>
            <x-input-label for="field_{{ $field->id }}" class="mb-3">
                <strong>
                    {{ $order }}.
                    {{ $field->field_label }}
                    @if($field->required)
                        {{"*"}}
                    @endif
                </strong>
            </x-input-label>
            <textarea
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                id="field_{{ $field->id }}" 
                name="field_{{ $field->id }}"
                rows="4"
                placeholder=""
                data-section-id="{{$section_id}}"
                {{$field->required == 1 ? "required" : ""}}
                ></textarea>
        </div>
    @elseif($field->type == "radio" || $field->type == "checkbox")
        <div>
            <fieldset>
                <legend class="block font-medium text-sm text-gray-700 mb-3">
                    <strong>
                        {{ $order }}.
                        {{$field->field_label}} 
                        @if($field->required)
                            {{"*"}}
                        @endif
                    </strong>
                </legend>
                    @php
                        $choices = explode("|", $field->choices);
                    @endphp

                    <div class="d-flex flex-wrap ml--16 mb--16">
                        @foreach($choices as $choice)
                            <label class="choice-card shadow-sm">
                                <div>
                                    @if($field->type == "radio")
                                        <input 
                                            id="field_{{ $field->id }}_{{ $loop->index }}" 
                                            type="radio" 
                                            name="field_{{ $field->id }}" 
                                            value="{{ $choice }}"
                                            data-section-id="{{$section_id}}"
                                            {{ $loop->first && $field->required ? 'required' : '' }}>
                                    @elseif($field->type == "checkbox")
                                        <input id="field_{{$field->id}}_{{ $loop->index }}" 
                                            type="checkbox" 
                                            name="field_{{ $field->id }}" 
                                            value="{{$choice}}"
                                            data-section-id="{{$section_id}}"
                                            {{ $loop->first && $field->required ? 'data-required-group=true' : '' }}>
                                    @endif
                                    <span class="ml-2">{{$choice}}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

            </fieldset>
        </div>
    @elseif($field->type == "select")
        <x-input-label for="field_{{ $field->id }}" class="mb-3">
            <strong>
                {{ $order }}.
                {{ $field->field_label }}
                @if($field->required)
                    {{"*"}}
                @endif
            </strong>
        </x-input-label>
        <select name="field_{{ $field->id }}" data-section-id="{{$section_id}}"
            id="field_{{ $field->id }}" class="w-full">
            @php
                $choices = array_map('trim', explode('|', $field->choices));
            @endphp

            <option value=""></option>
            @foreach($choices as $choice)
                <option value="{{ $choice }}">
                    {{ $choice }}
                </option>
            @endforeach
        </select>
    @elseif($field->type == "file")
        <x-input-label for="field_{{ $field->id }}" class="mb-3">
            <div>
                <strong>
                    {{ $order }}.
                    {{ $field->field_label }}
                    @if($field->required)
                        {{"*"}}
                    @endif
                </strong>
            </div>
            <div>
                <span class="txt-12">Accepted formats: PDF, JPG, JPEG, PNG, DOC, DOCX. Maximum file size: 2MB.</span>
            </div>
        </x-input-label>
        <div class="hidden view-document">
            <x-link-generic class="mb-3" href="javascript:void(0);" target="_blank">
                <span>View document</span>    
            </x-link-generic>
        </div>
        <input id="field_{{ $field->id }}" name="field_{{ $field->id }}" type="file"
            data-section-id="{{$section_id}}"
            @if($field->required) required @endif/>
    @endif
</div>