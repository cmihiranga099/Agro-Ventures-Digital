@php
    $map = [
        'pending' => ['bg' => 'bg-amber-50 text-amber-700 ring-amber-200', 'label' => 'Pending'],
        'in_progress' => ['bg' => 'bg-blue-50 text-blue-700 ring-blue-200', 'label' => 'In Progress'],
        'completed' => ['bg' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'label' => 'Completed'],
    ];
    $style = $map[$status] ?? $map['pending'];
@endphp
<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $style['bg'] }}">
    {{ $style['label'] }}
</span>
