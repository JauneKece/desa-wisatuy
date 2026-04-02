<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-slate-800 border-2 border-purple-500/50 text-slate-100 font-semibold rounded-lg hover:border-pink-500 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-slate-900 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
