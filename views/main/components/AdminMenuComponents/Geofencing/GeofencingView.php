<?php
// Expects $zoneData (assoc)
if (!isset($zoneData)) {
    echo "<div class='p-4'>No zone data available.</div>";
    return;
}
?>

<div class="max-w-3xl mx-auto mt-2">
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <a href="/main?admin=ViewGeofencing" class="mt-1 inline-block text-sm text-primary hover:underline">&larr; Tornar</a>
            <div class="flex flex-wrap gap-3">
                <a href="/geofencing/delete/<?php echo urlencode($zoneData['zone_id']); ?>" onclick="return confirm('Estàs segur que vols eliminar aquesta zona?');" class="inline-flex items-center gap-2 bg-accent hover:brightness-95 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">Eliminar</a>
                <a href="/main?admin=FormGeofencing&edit=<?php echo urlencode($zoneData['zone_id']); ?>" class="inline-flex items-center gap-2 bg-primary hover:brightness-95 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">Editar</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-[#CAF0D8] border border-gray-100 p-4 rounded-md">
                <p class="text-xs text-neutral-800 uppercase tracking-wider">Nom de la zona</p>
                <p class="mt-1 text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($zoneData['zone_name']); ?></p>
            </div>
            <div class="bg-[#CAF0D8] border border-gray-100 p-4 rounded-md">
                <p class="text-xs text-neutral-800 uppercase tracking-wider">Tipus</p>
                <p class="mt-1 text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($zoneData['type']); ?></p>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-md">
                <p class="text-xs text-neutral-800 uppercase tracking-wider">Centre (lat, lon)</p>
                <p class="mt-1 text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($zoneData['center_latitude']) . ', ' . htmlspecialchars($zoneData['center_longitude']); ?></p>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-md">
                <p class="text-xs text-neutral-800 uppercase tracking-wider">Radi (m)</p>
                <p class="mt-1 text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($zoneData['radius_meters']); ?></p>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-md">
                <p class="text-xs text-neutral-800 uppercase tracking-wider">Velocitat màxima (km/h)</p>
                <p class="mt-1 text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($zoneData['max_speed_allowed']); ?></p>
            </div>
        </div>
    </div>
</div>