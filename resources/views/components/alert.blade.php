@if (session('pesan') || session('edit') || session('hapus'))
@php
$message = session('pesan') ?? session('edit') ?? session('hapus');
$color = session('pesan') ? 'teal' : (session('edit') ? 'blue' : 'red');

$alertClasses = [
'teal' => 'bg-teal-50 border-teal-200 text-teal-800',
'blue' => 'bg-blue-50 border-blue-200 text-blue-800',
'red' => 'bg-red-50 border-red-200 text-red-800',
];

$buttonClasses = [
'teal' => 'bg-teal-50 text-teal-500 hover:bg-teal-100 focus:bg-teal-100',
'blue' => 'bg-blue-50 text-blue-500 hover:bg-blue-100 focus:bg-blue-100',
'red' => 'bg-red-50 text-red-500 hover:bg-red-100 focus:bg-red-100',
];

$icon = [
'teal' => '
<svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
    stroke="currentColor">
    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
    <path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
',
'blue' => '
<svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
    stroke="currentColor">
    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
    <path d="M12 8v8M8 12h8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
',
'red' => '
<svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
    stroke="currentColor">
    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
    <path d="M15 9l-6 6M9 9l6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
',
];
@endphp

<div id="dismiss-alert"
    class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 {{ $alertClasses[$color] }} text-sm rounded-lg p-4 mb-4"
    role="alert" tabindex="-1" aria-labelledby="hs-dismiss-button-label">

    <div class="flex">
        <div class="shrink-0">
            {!! $icon[$color] !!}
        </div>
        <div class="ms-2">
            <h3 id="hs-dismiss-button-label" class="text-sm font-medium">
                {{ $message }}
            </h3>
        </div>
        <div class="ps-3 ms-auto">
            <div class="-mx-1.5 -my-1.5">
                <button type="button"
                    class="inline-flex {{ $buttonClasses[$color] }} rounded-lg p-1.5 focus:outline-hidden"
                    data-hs-remove-element="#dismiss-alert">
                    <span class="sr-only">Dismiss</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endif