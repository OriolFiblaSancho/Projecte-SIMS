<?php
// Expects $vehicle (assoc) and $vehicleTypes (array of types)
if (!isset($vehicle)) {
    echo "<div class='p-4'>" . htmlspecialchars(t('vehicle_view_no_data'), ENT_QUOTES) . "</div>";
    return;
}
?>

<div class="max-w-3xl mx-auto mt-2">
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <a href="/main?admin=ViewVehicles" class="mt-1 inline-block text-sm text-[#0D6344] hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
            </a>
            <div class="flex flex-wrap gap-3">
                <a href="/vehicles/delete/<?php echo urlencode($vehicle['vehicle_id']); ?>" onclick="return confirm('<?= htmlspecialchars(t('confirm_delete_vehicle'), ENT_QUOTES) ?>');" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"><?= htmlspecialchars(t('action_delete'), ENT_QUOTES) ?></a>
                <a href="/main?admin=FormVehicles&edit=<?php echo urlencode($vehicle['vehicle_id']); ?>" class="inline-flex items-center gap-2 bg-[#0D6344] hover:bg-[#0a4d34] text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0D6344]"><?= htmlspecialchars(t('action_edit'), ENT_QUOTES) ?></a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php
            // small helper to render a label/value pair
            function renderField($label, $value, $colSpan = 1) {
                    $col = $colSpan > 1 ? 'md:col-span-2' : '';
                ?>
                <div class="bg-[#ddfae8] border border-[#0D6344]/20 p-4 rounded-md <?php echo $col; ?>">
                    <p class="text-xs text-gray-600 uppercase tracking-wider"><?php echo $label; ?></p>
                    <p class="mt-1 text-lg font-semibold text-[#0D6344]"><?php echo $value; ?></p>
                </div>
                <?php
            }            renderField(t('vehicle_field_model'), htmlspecialchars($vehicle['model']));
            renderField(t('vehicle_field_license_plate'), htmlspecialchars($vehicle['license_plate']));

            $typeName = 'Unknown';
            if (!empty($vehicleTypes)) {
                foreach ($vehicleTypes as $t) {
                    if (isset($t['type_id']) && $t['type_id'] == $vehicle['vehicle_type_id']) {
                        $typeName = $t['name'];
                        break;
                    }
                }
            }
            renderField(t('vehicle_field_type'), htmlspecialchars($typeName));
            renderField(t('vehicle_field_status'), htmlspecialchars($vehicle['status']));
            renderField(t('vehicle_field_battery_level'), htmlspecialchars($vehicle['battery_level']) . '%');
            renderField(t('vehicle_field_current_range'), htmlspecialchars($vehicle['current_range']) . ' km');
            renderField(t('vehicle_field_total_kilometers'), htmlspecialchars($vehicle['total_km']) . ' km', 2);
            ?>
        </div>
    </div>
</div>
