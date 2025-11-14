<div>
    <?php
    $old = $old ?? [];
    $errors = $errors ?? [];
    $isEdit = !empty($old['zone_id']);
    $formAction = $isEdit ? '/geofencing/update' : '/geofencing/store';
    $submitLabel = $isEdit ? t('geofence_form_update') : t('geofence_form_submit');
    ?>

    <form class="mt-5" action="<?= $formAction ?>" method="POST">
        <?php if ($isEdit): ?>
            <input type="hidden" name="zone_id" value="<?= htmlspecialchars($old['zone_id']) ?>">
        <?php endif; ?>

        <label for="zone_name" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('geofence_form_name_label'), ENT_QUOTES) ?></label>
        <input type="text" name="zone_name" placeholder="<?= htmlspecialchars(t('geofence_form_name_label'), ENT_QUOTES) ?>" value="<?= htmlspecialchars($old['zone_name'] ?? '') ?>" class="border border-gray-300 rounded-md p-2 w-full mb-1">
        <?php if (!empty($errors['zone_name'])): ?><div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($errors['zone_name']) ?></div><?php endif; ?>

        <label for="center_latitude" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('geofence_form_center_lat_label'), ENT_QUOTES) ?></label>
        <input type="text" name="center_latitude" placeholder="e.g. 41.3851" value="<?= htmlspecialchars($old['center_latitude'] ?? '') ?>" class="border border-gray-300 rounded-md p-2 w-full mb-1">
        <?php if (!empty($errors['center_latitude'])): ?><div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($errors['center_latitude']) ?></div><?php endif; ?>

        <label for="center_longitude" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('geofence_form_center_lng_label'), ENT_QUOTES) ?></label>
        <input type="text" name="center_longitude" placeholder="e.g. 2.1734" value="<?= htmlspecialchars($old['center_longitude'] ?? '') ?>" class="border border-gray-300 rounded-md p-2 w-full mb-1">
        <?php if (!empty($errors['center_longitude'])): ?><div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($errors['center_longitude']) ?></div><?php endif; ?>

        <label for="radius_meters" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('geofence_form_radius_label'), ENT_QUOTES) ?></label>
        <input type="number" name="radius_meters" placeholder="Radi en metres" value="<?= htmlspecialchars($old['radius_meters'] ?? '') ?>" class="border border-gray-300 rounded-md p-2 w-full mb-1">
        <?php if (!empty($errors['radius_meters'])): ?><div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($errors['radius_meters']) ?></div><?php endif; ?>

        <label for="max_speed_allowed" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('geofence_form_max_speed_label'), ENT_QUOTES) ?></label>
        <input type="number" name="max_speed_allowed" placeholder="Velocitat màxima" value="<?= htmlspecialchars($old['max_speed_allowed'] ?? '') ?>" class="border border-gray-300 rounded-md p-2 w-full mb-1">
        <?php if (!empty($errors['max_speed_allowed'])): ?><div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($errors['max_speed_allowed']) ?></div><?php endif; ?>

        <label for="type" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('geofence_form_type_label'), ENT_QUOTES) ?></label>
        <select name="type" class="border border-gray-300 rounded-md p-2 w-full mb-4">
            <option value=""><?= htmlspecialchars(t('geofence_form_type_label'), ENT_QUOTES) ?></option>
            <?php
            $types = [
                'school' => t('geofence_type_school'),
                'hospital' => t('geofence_type_hospital'),
                'historic_center' => t('geofence_type_historic_center'),
                'residential_area' => t('geofence_type_residential_area')
            ];
            foreach ($types as $val => $label): ?>
                <option value="<?= $val ?>" <?= (isset($old['type']) && $old['type'] === $val) ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['type'])): ?><div class="text-red-600 text-sm mb-2"><?= htmlspecialchars($errors['type']) ?></div><?php endif; ?>

        <button type="submit" class="bg-[#CB97FF] text-black rounded-md p-2 w-full hover:bg-[#7E3FBC] hover:border-[#f0e0ff] hover:text-white border border-[#7E3FBC] border-[2px]"><?= htmlspecialchars($submitLabel) ?></button>
    </form>
</div>