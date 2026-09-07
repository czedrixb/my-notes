@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-200 focus:border-primary-400 focus:ring-primary-400 rounded-xl shadow-sm transition-colors duration-200']) !!}>
