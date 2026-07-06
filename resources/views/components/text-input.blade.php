@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-blue-500 focus:bg-white focus:ring-blue-500']) }}>
