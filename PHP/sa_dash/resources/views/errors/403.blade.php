<x-app-layout>
    <x-slot name="title">
        403: Accesso non permesso
    </x-slot>
    <x-slot name="error">
        Errore 403:
        <br><br>
        @isset ($exception)
            <!-- Messaggio proveniente dal Controller -->
            {{ $exception->getMessage() }}
        @else
            Non hai i privilegi neccessari per accedere a questa pagina
        @endisset
    </x-slot>
</x-app-layout>
