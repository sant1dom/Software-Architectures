<x-app-layout>
	<x-slot name="header">
		Prediction Consumption
	</x-slot>

	<x-slot name="main_info">
		<strong style="font-size: 2rem;">
			Prediction Details:
		</strong>
		<br><br>

		<table>
			<tr>
				<x-table.th>Prediction</x-table.th>
				<x-table.td>
					 Consumption
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>Info1</x-table.th>
				<x-table.td>
					{{ $prediction->info1 }}
				</x-table.td>
			</tr>
			<tr>
				<x-table.th>Info2</x-table.th>
				<x-table.td>
					{{ $prediction->info2 }}
				</x-table.td>
			</tr>
		</table>
	</x-slot>
</x-app-layout>