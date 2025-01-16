@props(['disabled' => false, 'options' => []])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-[12px] py-[8px]']) }}>
    @foreach ($options as $value => $label)
    <option value="{{ $value }}" {{ $attributes->get('value') == $value ? 'selected' : '' }}>
        {{ $label }}
    </option>
    @endforeach
</select>