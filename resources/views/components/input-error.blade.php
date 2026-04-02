@props(['messages'])

@if ($messages)
    <ul class="text-sm space-y-1 mt-2" style="color: #C85A54;" {{ $attributes }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center">
                <span class="inline-block w-2 h-2 rounded-full mr-2" style="background-color: #C85A54;"></span>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
