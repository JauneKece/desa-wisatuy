<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 border border-transparent rounded-lg font-bold text-white text-sm hover:shadow-lg hover:shadow-red-500/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition ease-in-out duration-150 hover:scale-105 active:scale-95']) }}>
    {{ $slot }}
</button>
