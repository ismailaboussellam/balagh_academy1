@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-green-800 dark:border-green-600 dark:bg-gray-900 dark:text-gray-300 focus:border-green-600 dark:focus:border-green-600 focus:ring-green-600 dark:focus:ring-green-600 rounded-md shadow-sm']) }}>
