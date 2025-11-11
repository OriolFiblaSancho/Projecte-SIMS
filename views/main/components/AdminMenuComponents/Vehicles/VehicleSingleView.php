<div class="rounded-md bg-white/90 border border-[#7E3FBC] p-4 w-full max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="?admin=ViewVehicles" class="text-2xl text-[#7E3FBC] hover:opacity-80">&#8592;</a>
            <h2 class="text-xl font-semibold text-[#2d0a4a]">Vehicle details</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="/vehicles/delete/<?= $vehicle['vehicle_id'] ?>" onclick="return confirm('Delete this vehicle?');" class="px-4 py-2 rounded-md bg-purple-500 text-white hover:bg-purple-600">Delete</a>
            <a href="?admin=FormVehicles&id=<?= $vehicle['vehicle_id'] ?>" class="px-4 py-2 rounded-md bg-green-700 text-white hover:bg-green-800">Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Model -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Model</div>
            <div class="text-xl font-bold text-gray-800"><?= htmlspecialchars($vehicle['model'] ?? '') ?></div>
        </div>

        <!-- License Plate -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">License plate</div>
            <div class="text-xl font-bold text-gray-800"><?= htmlspecialchars($vehicle['license_plate'] ?? '') ?></div>
        </div>

        <!-- Type -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Type</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($type['name'] ?? ($vehicle['vehicle_type_id'] ?? '')) ?></div>
        </div>

        <!-- Status -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Status</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($vehicle['status'] ?? '') ?></div>
        </div>

        <!-- Battery level -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Battery level</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars((isset($vehicle['battery_level']) ? $vehicle['battery_level'] . '%' : 'N/A')) ?></div>
        </div>

        <!-- Current range -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Current range</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars((isset($vehicle['current_range']) ? $vehicle['current_range'] . ' km' : 'N/A')) ?></div>
        </div>

        <!-- Total kilometers -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm md:col-span-2">
            <div class="text-xs text-gray-500 uppercase">Total kilometers</div>
            <div class="text-2xl font-bold text-gray-800"><?= htmlspecialchars(number_format((float)($vehicle['total_km'] ?? 0), 2)) ?> km</div>
        </div>
    </div>
</div>
