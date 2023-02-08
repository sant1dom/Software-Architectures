<th {{
		$attributes->merge([
			'class' => 'px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white',
            'style' => 'border: 1px solid black; text-align: left; text-transform: none; padding: 0.5rem; font-weight: 700; font-size: 1rem;'
        ])
    }}>
	{{ $slot }}
</th>