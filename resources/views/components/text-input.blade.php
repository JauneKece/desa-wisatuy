@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full px-4 py-3 border-2 rounded-lg transition-all duration-300 focus:outline-none focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed', 'style' => 'border-color: #E2B59A; color: #957C62; background-color: #FFE1AF;', 'focus-style' => 'border-color: #B77466; background-color: #FFFAED;']) }}>

