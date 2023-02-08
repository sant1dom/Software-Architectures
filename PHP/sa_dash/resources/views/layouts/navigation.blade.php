<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex">

				<!-- Logo Start -->
				<div class="shrink-0 flex items-center">
					<a href="{{route('bill.index')}}">
						<x-other.logo class="block h-9 w-auto fill-current text-gray-800"/>
					</a>
				</div>
				<!-- Logo End -->

				<!-- Links Start -->
				@include("layouts.links")
				<!-- Links Emd -->
			</div>

			@if ($auth)
				<div class="hidden sm:flex sm:items-center sm:ml-6">

					<x-menu.dropdown align="right" width="48">
						<x-slot name="trigger">
							<button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
								<div>
									Welcome {{ $auth->name }} {{ $auth->surname }}
								</div>
							</button>
						</x-slot>

						<x-slot name="content"></x-slot>
					</x-menu.dropdown>
				</div>
			@endif

		</div>
	</div>
</nav>