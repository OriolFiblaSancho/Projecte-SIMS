<div class="flex flex-col rounded-md p-3 max-h-[60vh] overflow-auto">
    <div class="flex justify-center">
        <a href="?admin=FormGeofencing">
        <button class="bg-[#f0e0ff] text-black rounded-md p-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
            </svg>
        </button>
    </a>
    </div>

    <div class="overflow-x-auto mt-2">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-sm rounded-md overflow-hidden">
            <thead class="bg-[#7E3FBC] text-white text-left text-xs font-semibold uppercase">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Radius (m)</th>
                    <th class="px-4 py-2">Coordinates</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if (empty($zones)): ?>
                <tr>
                    <td class="px-4 py-6 text-sm text-gray-500 text-center" colspan="5">No zones found.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($zones as $zone): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-800"><?php echo htmlspecialchars($zone['zone_name']); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($zone['type']); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($zone['radius_meters']); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($zone['center_latitude']) . ', ' . htmlspecialchars($zone['center_longitude']); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <a href="/main?admin=ViewGeofencingSingle&id=<?= $zone['zone_id'] ?>" class="mr-2">View</a>
                        <a href="/main?admin=FormGeofencing&edit=<?= $zone['zone_id'] ?>" class="mr-2">Edit</a>
                        <a href="/geofencing/delete/<?= $zone['zone_id'] ?>" onclick="return confirm('Estàs segur que vols eliminar aquesta zona?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>