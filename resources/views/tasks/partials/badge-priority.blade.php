@php
    $map = [
        'low' => ['bg' => 'bg-slate-50 text-slate-700 ring-slate-200', 'label' => 'Low'],
        'medium' => ['bg' => 'bg-orange-50 text-orange-700 ring-orange-200', 'label' => 'Medium'],
        'high' => ['bg' => 'bg-rose-50 text-rose-700 ring-rose-200', 'label' => 'High'],
    ];
    $style = $map[$priority] ?? $map['low'];
@endphp
<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $style['bg'] }}">
    {{ $style['label'] }}
</span>
