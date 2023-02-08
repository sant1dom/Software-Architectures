<div style="border-left: 1px solid #e5e7eb; margin: 0 10px 0 10px"></div>

<x-menu.nav-link
		:href="route('bill.index')"
		:active="$controller == 'bill'">
	Bills
</x-menu.nav-link>

<div style="border-left: 1px solid #e5e7eb; margin: 0 10px 0 10px"></div>

<x-menu.nav-link
		:href="route('prediction.index')"
		:active="$controller == 'prediction'">
	Predictions
</x-menu.nav-link>

<div style="border-left: 1px solid #e5e7eb; margin: 0 10px 0 10px"></div>

<x-menu.nav-link
		:href="route('auth.logout')">
	Log out
</x-menu.nav-link>
