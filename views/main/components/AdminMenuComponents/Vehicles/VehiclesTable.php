<div class="flex flex-col rounded-md p-3 max-h-[60vh] overflow-auto">
    <div class="flex">
        <a href="?admin=FormVehicles">
            <button class="bg-[#ddfae8] text-[#0D6344] border border-[#0D6344] rounded-md p-1 hover:bg-[#0D6344] hover:text-white flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                <?= htmlspecialchars(t('vehicle_table_add_button'), ENT_QUOTES) ?>
            </button>
        </a>
    </div>
    
    <div class="overflow-x-auto mt-2 border border-gray-300 rounded-md">
        <table class=" min-w-full divide-y divide-gray-200 bg-white shadow-sm  overflow-hidden ">
            <thead class="bg-[#0D6344] text-white text-left text-xs font-semibold uppercase">
                <tr>
                    <th class="px-4 py-2"><?= htmlspecialchars(t('vehicle_table_header_model'), ENT_QUOTES) ?></th>
                    <th class="px-4 py-2"><?= htmlspecialchars(t('vehicle_table_header_license_plate'), ENT_QUOTES) ?></th>
                    <th class="px-4 py-2"><?= htmlspecialchars(t('vehicle_table_header_type'), ENT_QUOTES) ?></th>
                    <th class="px-4 py-2"><?= htmlspecialchars(t('vehicle_table_header_total_km'), ENT_QUOTES) ?></th>
                    <th class="px-4 py-2"><?= htmlspecialchars(t('vehicle_table_header_status'), ENT_QUOTES) ?></th>
                    <th class="px-4 py-2" colspan="4"><?= htmlspecialchars(t('vehicle_table_header_actions'), ENT_QUOTES) ?></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-10 border border-gray-300">
                <?php if (empty($vehicles)): ?>
                <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-4 py-6 text-sm text-gray-500 text-center" colspan="6"><?= htmlspecialchars(t('vehicle_table_no_data'), ENT_QUOTES) ?></td>
                </tr>
                <?php else: ?>
                <?php foreach ($vehicles as $vehicle): ?>
                <tr class="hover:bg-gray-50 ">
                    <td class="px-4 py-3 text-sm font-medium text-gray-800"><?php echo htmlspecialchars($vehicle['model']); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($vehicle['license_plate']); ?></td>
                    <?php foreach ($vehicleTypes as $type): ?>
                        <?php if ($type['type_id'] == $vehicle['vehicle_type_id']): ?>
                            <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($type['name']); ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($vehicle['total_km']); ?></td>
                    <td class="px-4 py-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <?php echo htmlspecialchars($vehicle['status']); ?>
                        </span>
                    </td>
                    <td>
                        <!-- View Button -->
                        <a href="?admin=ViewVehicle&id=<?= $vehicle['vehicle_id'] ?>">
                        <button class="px-2 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                <path fill-rule="evenodd" d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        </a>
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="?admin=FormVehicles&edit=<?php echo urlencode($vehicle['vehicle_id']); ?>">
                        <button class="px-2 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                            </svg>

                        </button>
                        </a>
                    </td>
                    <td>
                        <!-- Delete Button -->
                        <a href="/vehicles/delete/<?= $vehicle['vehicle_id'] ?>">
                        <button class="px-2 py-3" onclick="return confirm('<?= htmlspecialchars(t('confirm_delete_vehicle'), ENT_QUOTES) ?>');">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>