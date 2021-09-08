@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-white-200']) }}>
    {{ $value ?? $slot }}
</label>
