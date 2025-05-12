@props(['status', 'message', 'autoHide' => true])

@if (($status === 'success' || $status === 'error') && isset($message))
    @php
        $baseClass = 'rounded-md font-normal p-4 text-white text-sm';
        $bgColor = $status === 'success' ? 'bg-green-500' : 'bg-red-500';
    @endphp

    <div x-data="{ show: true }" x-init="{{ $autoHide ? 'setTimeout(() => show = false, 5000)' : '' }}" x-show="show"
        x-transition:leave="transition-opacity duration-500 ease-out" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" {{ $attributes->merge(['class' => "$baseClass $bgColor"]) }}>
        {!!  $message !!}
    </div>
@endif
