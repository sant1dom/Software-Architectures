<x-app-layout>
	<x-slot name="header">
		Bill List
	</x-slot>

	<x-slot name="main_info">
		<strong style="font-size: 2rem;">
		List of all your bills:
		</strong>
		<br><br>

		<table>
			<tr>
				<x-table.th>Id</x-table.th>
				<x-table.th>Date</x-table.th>
			</tr>
			@foreach ($bills as $bill)
				<tr>
					<x-table.td>
						<a style="text-decoration: underline; color: blue"
						   href="{{ route("bill.show") }}?id={{ $bill->id }}">
							{{ $bill->id }}
						</a>
					</x-table.td>
					<x-table.td>
						<a style="text-decoration: underline; color: blue"
						   href="{{ route("bill.show") }}?id={{ $bill->id }}">
							{{ $bill->date }}
						</a>
					</x-table.td>
				</tr>
			@endforeach
		</table>
	</x-slot>
</x-app-layout>