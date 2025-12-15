@props([
	'options' => [], // Array de objetos con 'id' y 'title'
	'items' => null, // El valor de ID actualmente seleccionado (ej. 5)
	'placeholder' => null,
    'disabled' => false
])

<div wire:ignore {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
	<select
        {{ $disabled ? 'disabled' : '' }}

	x-data="{
		tomSelectInstance: null,
		options: {{ collect($options) }},
		items: '{{ $items }}', // Usamos el valor directamente

		// Renderizado simple para solo mostrar el título
		renderTemplate(data, escape) {
			return `<div><span class='block font-medium text-gray-700'>${escape(data.title)}</span></div>`;
		},
		itemTemplate(data, escape) {
			return `<div><span class='block font-medium text-gray-700'>${escape(data.title)}</span></div>`;
		}
	}"
	x-init="tomSelectInstance = new TomSelect($refs.input, {
		valueField: 'id',
		labelField: 'title',
		searchField: 'title',
		options: options,
		items: items ? [items] : [], // Si hay items, lo ponemos en un array para inicializar la selección

		// Esta línea asegura que Livewire pueda actualizar el valor de la propiedad department_id
		// al seleccionar una opción.
		onBlur: function() {
			let value = this.getValue();
			if (value != this.settings.items) {
				@this.set('{{ $attributes->whereStartsWith('wire:model')->first() }}', value)
			}
		},

		@if (! empty($items) && ! $attributes->has('multiple'))
			placeholder: undefined,
		@else
			placeholder: '{{ $placeholder }}',
		@endif
		render: {
			option: renderTemplate,
			item: itemTemplate
		}
	});"
	x-ref="input"
 	x-cloak
	{{ $attributes->whereDoesntStartWith('options')->whereDoesntStartWith('items') }}
	placeholder="{{ $placeholder }}"
	>
	</select>
</div>

