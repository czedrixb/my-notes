<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-semibold text-xs text-slate-600 shadow-sm hover:bg-slate-50 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 disabled:opacity-25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0']) }}>
    {{ $slot }}
</button>
