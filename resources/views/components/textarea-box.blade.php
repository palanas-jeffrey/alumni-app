<textarea {{ $attributes->merge(['class' => 'border-gray-300 rounded-md shadow-sm mt-1 block w-full']) }} 
    rows="4">{{ $slot }}</textarea>