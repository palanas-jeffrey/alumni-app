<div class="w-100 mb-3">
    @if($field->type == "text" || $field->type == "number" || $field->type == "date")
        <div>
            <x-input-label for="field_{{ $field->id }}">
                {{ $field->field_label }}
                @if($field->required)
                    {{"*"}}
                @endif
            </x-input-label>
            <x-text-input 
                id="field_{{ $field->id }}" 
                name="field_{{ $field->id }}"
                type="{{$field->type}}" 
                class="mt-1 block w-full"
                autofocus
                :required="$field->required == 1"
            />
            <x-input-error class="mt-2" :messages="$errors->get('field_' . $field->id)" />
        </div>
    @elseif($field->type == "textarea")
        <div>
            <x-input-label for="field_{{ $field->id }}">
                {{ $field->field_label }}
                @if($field->required)
                    {{"*"}}
                @endif
            </x-input-label>
            <textarea
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full form-control"
                id="field_{{ $field->id }}" 
                name="field_{{ $field->id }}"
                rows="4"
                placeholder=""
                {{$field->required == 1 ? "required" : ""}}
                ></textarea>
        </div>
    @elseif($field->type == "radio" || $field->type == "checkbox")
        <div>
            <fieldset>
                <legend>
                    {{$field->field_label}} 
                    @if($field->required)
                        {{"*"}}
                    @endif
                </legend>
                    @php
                        $choices = explode("|", $field->choices);
                    @endphp

                    @foreach($choices as $choice)
                        <div>
                            @if($field->type == "radio")
                                <input 
                                    id="field_{{ $field->id }}" 
                                    type="radio" 
                                    name="field_{{ $field->id }}" 
                                    value="{{ $choice }}"
                                    {{ $loop->first && $field->required ? 'required' : '' }}>
                            @elseif($field->type == "checkbox")
                                <input id="field_{{$field->id}}" 
                                    type="checkbox" 
                                    name="field_{{ $field->id }}" 
                                    value="{{$choice}}">
                            @endif
                            <label class="ml-2" for="field_{{$choice}}">{{$choice}}</label>
                        </div>
                    @endforeach
            </fieldset>
        </div>
    @elseif($field->type == "select")
        <x-input-label for="field_{{ $field->id }}">
            {{ $field->field_label }}
            @if($field->required)
                {{"*"}}
            @endif
        </x-input-label>
        <select name="field_{{ $field->id }}" id="field_{{ $field->id }}" class="w-full">
            @php
                $choices = explode("|", $field->choices);
            @endphp

            @foreach($choices as $choice)
                <option value="{{ $choice }}">
                    {{ $choice }}
                </option>
            @endforeach
        </select>
    @endif
</div>