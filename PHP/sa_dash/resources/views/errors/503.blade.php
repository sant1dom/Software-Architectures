<x-app-layout>
    <x-slot name="title">
        503: Errore durante il caricamento della pagina
    </x-slot>
    <x-slot name="error">
        Errore 503:
        <br><br>
        @isset ($exception)
            {{ $exception->getMessage() }}
        @else
            Errore durante il caricamento della pagina
        @endisset
    </x-slot>
</x-app-layout>
