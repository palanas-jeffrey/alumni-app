<select {{ $attributes->merge(['class' => 'border-gray-300 rounded-md shadow-sm block w-full']) }}>
    @if ($hasBlank)
        <option></option>
    @endif
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>