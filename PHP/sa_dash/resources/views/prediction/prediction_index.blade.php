<x-app-layout>
	<x-slot name="header">
		Prediction Consumption
	</x-slot>

	<x-slot name="main_info">

		<br><br>
		<a style="font-weight: bold; color: blue; font-size: 1.5rem;"
		   class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
		   href="{{ route('prediction.production') }}">
			Prediction on Production
		</a>
		<br><br>

		<br><br>
		<a style="font-weight: bold; color: blue; font-size: 1.5rem;"
		   class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
		   href="{{ route('prediction.consumption') }}">
			Prediction on Consumption
		</a>
		<br><br>

		<br><br>
		<a style="font-weight: bold; color: blue; font-size: 1.5rem;"
		   class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
		   href="{{ route('prediction.future') }}">
			Prediction on Future bill
		</a>
		<br><br>

	</x-slot>
</x-app-layout>