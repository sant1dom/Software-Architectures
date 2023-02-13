<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>


    <x-slot name="main_info">
        <div class="py-2">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            @if ($auth['role'] == 'admin')
                <label for="house_id">House ID</label>
                <select name="house_id" id="house_id">
                    @foreach ($houses as $house)
                        <option value="{{ $house }}">{{ $house }}</option>
                    @endforeach
                </select>
            @endif
            <iframe id="iframe" src="http://localhost:3000/d/L2DfNh0Vz/try?orgId=1&refresh=10s&var-house_id=140&var-time_avg=1m&kiosk&theme=light" width="100%" height=1200px frameborder="0" scrolling="no" style="pointer-events: none;"></iframe>
        </div>
    </x-slot>
</x-app-layout>

<script>
  document.getElementById("house_id").addEventListener("change", function() {
    var selectedHouseId = this.value;
    document.getElementById("iframe").src = "http://localhost:3000/d/L2DfNh0Vz/try?orgId=1&refresh=10s&var-house_id=" + selectedHouseId + "&var-time_avg=1m&kiosk&theme=light";
    });
</script>
