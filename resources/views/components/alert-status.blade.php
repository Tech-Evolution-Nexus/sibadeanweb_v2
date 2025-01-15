@props(['status', 'message'])

@if ($status == "success" && isset($message))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    {{ $attributes->merge(['class' => 'rounded-md font-normal bg-green-500 p-4 text-white text-sm']) }}>
    {{ $message }}
</div>
@elseif($status == "error" && isset($message))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    {{ $attributes->merge(['class' => 'rounded-md font-normal bg-red-500 p-4 text-white text-sm']) }}>
    {{ $message }}
</div>
@endif