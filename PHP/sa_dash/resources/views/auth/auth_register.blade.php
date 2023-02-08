<x-guest-layout>
	<form method="POST" action="{{ route('auth.register') }}">
		@csrf

		<!-- Email Address -->
		<div class="mt-4">
			<x-form.label for="email" value="Email"/>

			<x-form.text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
			              required/>

			<x-form.error :messages="$errors->get('email')" class="mt-2"/>
		</div>

		<!-- Password -->
		<div class="mt-4">
			<x-form.label for="password" value="Password"/>

			<x-form.text id="password" class="block mt-1 w-full"
			              type="password"
			              name="password"
			              required autocomplete="new-password"/>

			<x-form.error :messages="$errors->get('password')" class="mt-2"/>
		</div>

		<!-- Confirm Password -->
		<div class="mt-4">
			<x-form.label for="password_confirmation" value="Confirm Password"/>

			<x-form.text id="password_confirmation" class="block mt-1 w-full"
			              type="password"
			              name="password_confirmation" required/>

			<x-form.error :messages="$errors->get('password_confirmation')" class="mt-2"/>
		</div>

		<!-- Username -->
		<div class="mt-4">
			<x-form.label for="username" value="Username"/>

			<x-form.text id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
			              required autofocus/>

			<x-form.error :messages="$errors->get('username')" class="mt-2"/>
		</div>		
		
		<!-- Name -->
		<div class="mt-4">
			<x-form.label for="name" value="Name"/>

			<x-form.text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
			              required autofocus/>

			<x-form.error :messages="$errors->get('name')" class="mt-2"/>
		</div>


		<!-- Surname -->
		<div class="mt-4">
			<x-form.label for="surname" value="Surname"/>

			<x-form.text id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')"
			              required autofocus/>

			<x-form.error :messages="$errors->get('surname')" class="mt-2"/>
		</div>

		<!-- Phone -->
		<div class="mt-4">
			<x-form.label for="phone" value="Phone"/>

			<x-form.text id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
			              required autofocus/>

			<x-form.error :messages="$errors->get('phone')" class="mt-2"/>
		</div>		
		
		<div class="flex items-center mt-4">
			<x-other.button>
				Register
			</x-other.button>
		</div>
	</form>

	<br>
	<a style="font-weight: bold; color: blue"
	   class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
	   href="{{ route('auth.login') }}">
		Or Login
	</a>	
</x-guest-layout>