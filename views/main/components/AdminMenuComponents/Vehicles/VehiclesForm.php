<div>
    <?php $isEdit = isset($vehicle) && !empty($vehicle); ?>
    <form class="mt-5" action="<?php echo $isEdit ? '/vehicles/update' : '/vehicles/create'; ?>" method="POST">
        <?php if ($isEdit): ?>
            <input type="hidden" name="vehicle_id" value="<?php echo htmlspecialchars($vehicle['vehicle_id']); ?>">
        <?php endif; ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="model" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_form_model_label'), ENT_QUOTES) ?></label>
                <input type="text" name="model" placeholder="<?= htmlspecialchars(t('vehicle_form_model_placeholder'), ENT_QUOTES) ?>" value="<?php echo $isEdit ? htmlspecialchars($vehicle['model']) : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div>
                <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_form_license_plate_label'), ENT_QUOTES) ?></label>
                <input type="text" name="license_plate" placeholder="<?= htmlspecialchars(t('vehicle_form_license_plate_placeholder'), ENT_QUOTES) ?>" value="<?php echo $isEdit ? htmlspecialchars($vehicle['license_plate']) : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div>
                <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_form_type_label'), ENT_QUOTES) ?></label>
                <select name="vehicle_type_id" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value=""><?= htmlspecialchars(t('vehicle_form_type_select_placeholder'), ENT_QUOTES) ?></option>
                    <?php foreach ($vehicleTypes as $type): ?>
                        <option value="<?php echo htmlspecialchars($type['type_id']); ?>" <?php echo ($isEdit && $vehicle['vehicle_type_id'] == $type['type_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($type['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="total_km" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_form_total_km_label'), ENT_QUOTES) ?></label>
                <input type="number" name="total_km" placeholder="<?= htmlspecialchars(t('vehicle_form_total_km_placeholder'), ENT_QUOTES) ?>" value="<?php echo $isEdit ? htmlspecialchars($vehicle['total_km']) : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div>
                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_form_latitude_label'), ENT_QUOTES) ?></label>
                <input id="vehicle-latitude" type="text" name="latitude" placeholder="<?= htmlspecialchars(t('vehicle_form_latitude_placeholder'), ENT_QUOTES) ?>" readonly value="<?php echo $isEdit ? htmlspecialchars($vehicle['latitude'] ?? '') : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full bg-gray-50">
            </div>

            <div>
                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_form_longitude_label'), ENT_QUOTES) ?></label>
                <input id="vehicle-longitude" type="text" name="longitude" placeholder="<?= htmlspecialchars(t('vehicle_form_longitude_placeholder'), ENT_QUOTES) ?>" readonly value="<?php echo $isEdit ? htmlspecialchars($vehicle['longitude'] ?? '') : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full bg-gray-50">
            </div>

            <div class="md:col-span-2">
                <div class="">
                    <h3 class="text-sm font-medium text-gray-700"><?= htmlspecialchars(t('vehicle_form_pick_location_title'), ENT_QUOTES) ?></h3>
                        <button id="pick-on-map" type="button" class="text-sm px-3 py-1 rounded bg-white border border-gray-300 hover:bg-gray-100"><?= htmlspecialchars(t('vehicle_form_pick_on_map'), ENT_QUOTES) ?></button>
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('vehicle_field_status'), ENT_QUOTES) ?></label>
                <select name="status" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="available" <?php echo ($isEdit && $vehicle['status'] == 'available') ? 'selected' : ''; ?>><?= htmlspecialchars(t('vehicle_status_available'), ENT_QUOTES) ?></option>
                    <option value="reserved" <?php echo ($isEdit && $vehicle['status'] == 'reserved') ? 'selected' : ''; ?>><?= htmlspecialchars(t('vehicle_status_reserved'), ENT_QUOTES) ?></option>
                    <option value="in_use" <?php echo ($isEdit && $vehicle['status'] == 'in_use') ? 'selected' : ''; ?>><?= htmlspecialchars(t('vehicle_status_in_use'), ENT_QUOTES) ?></option>
                    <option value="out_of_service" <?php echo ($isEdit && $vehicle['status'] == 'out_of_service') ? 'selected' : ''; ?>><?= htmlspecialchars(t('vehicle_status_out_of_service'), ENT_QUOTES) ?></option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="bg-[#ddfae8] text-[#0D6344] rounded-md p-2 w-full hover:bg-[#0D6344] hover:text-white border border-[#0D6344] border-2"><?php echo $isEdit ? htmlspecialchars(t('action_save_changes'), ENT_QUOTES) : htmlspecialchars(t('vehicle_table_add_button'), ENT_QUOTES); ?></button>
            </div>
        </div>
    </form>
</div>