<x-guest-layout>
	<form method="POST" action="{{ route('auth.login') }}">
		@csrf

		<!-- Email Address -->
		<div>
			<x-form.label for="email" value="Email"/>

			<x-form.text id="email" class="block mt-1 w-full" type="email" name="email"
			             :value="old('email')" required autofocus/>

			<x-form.error :messages="$errors->get('email')" class="mt-2"/>
		</div>

		<!-- Password -->
		<div class="mt-4">
			<x-form.label for="password" value="Password"/>

			<x-form.text id="password" class="block mt-1 w-full"
			             type="password"
			             name="password"
			             required autocomplete="current-password"/>

			<x-form.error :messages="$errors->get('password')" class="mt-2"/>
		</div>

		<div class="flex items-center mt-4">
			<x-other.button>
				Log in
			</x-other.button>
		</div>
	</form>

	<br>
	<a style="font-weight: bold; color: blue"
	   class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
	   href="{{ route('auth.register') }}">
		Or Register
	</a>
</x-guest-layout>