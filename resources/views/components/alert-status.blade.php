@props(['status',"message"])

@if ($status == "success" && isset($message))
<div {{ $attributes->merge(['class' => 'rounded-md font-normal bg-green-500 p-4  text-white text-sm text-gray-900']) }}>
    {{ $message }}
</div>
@elseif($status =="error" && isset($message))
<div {{ $attributes->merge(['class' => 'rounded-md font-normal bg-red-500 p-4  text-white text-sm text-gray-900']) }}>
    {{ $message }}
</div>
@endif