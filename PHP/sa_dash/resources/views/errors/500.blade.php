<x-app-layout>
    <x-slot name="title">
        500: Errore durante il caricamento della pagina
    </x-slot>
    <x-slot name="error">
        Errore 500:
        <br><br>
        @isset ($exception)
            {{ $exception->getMessage() }}
        @else
            Errore durante il caricamento della pagina
        @endisset
    </x-slot>
</x-app-layout>
