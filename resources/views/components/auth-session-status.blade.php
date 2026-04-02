@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm px-4 py-3 rounded-lg', 'style' => 'background-color: #FFE1AF; color: #957C62; border-left: 4px solid #B77466;']) }}>
        {{ $status }}
    </div>
@endif
