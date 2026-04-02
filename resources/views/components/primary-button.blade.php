<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg font-bold text-white text-sm uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 hover:scale-105 active:scale-95', 'style' => 'background-color: #B77466; focus-ring-color: #957C62; focus-ring-offset-color: #FFE1AF;']) }}>
    {{ $slot }}
</button>
