<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-br from-red-400 to-rose-500 border border-transparent rounded-xl font-semibold text-xs text-white tracking-wide hover:shadow-lg hover:shadow-rose-400/30 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0']) }}>
    {{ $slot }}
</button>
