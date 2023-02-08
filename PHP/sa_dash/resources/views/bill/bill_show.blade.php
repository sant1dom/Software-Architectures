<x-app-layout>
	<x-slot name="header">
		Bill Details
	</x-slot>

	<x-slot name="main_info">
		<strong style="font-size: 2rem;">
			Bill Details:
		</strong>
		<br><br>

		<table>
			<tr>
				<x-table.th>Id</x-table.th>
				<x-table.td>
					{{ $bill->id }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>date</x-table.th>
				<x-table.td>
					{{ $bill->date }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>House id</x-table.th>
				<x-table.td>
					{{ $bill->house_id }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>energy_production</x-table.th>
				<x-table.td>
					{{ $bill->energy_production }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>energy_consumption</x-table.th>
				<x-table.td>
					{{ $bill->energy_consumption }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>total</x-table.th>
				<x-table.td>
					{{ $bill->total }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>paid</x-table.th>
				<x-table.td>
					{{ $bill->paid }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>address</x-table.th>
				<x-table.td>
					{{ $bill->address }}
				</x-table.td>
			</tr>
		</table>
	</x-slot>
</x-app-layout>