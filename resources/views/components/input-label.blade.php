@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm mb-2', 'style' => 'color: #957C62;']) }}>
    {{ $value ?? $slot }}
</label>
