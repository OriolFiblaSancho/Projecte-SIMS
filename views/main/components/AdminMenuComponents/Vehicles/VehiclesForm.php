<div>
    <?php $isEdit = isset($vehicle) && !empty($vehicle); ?>
    <form class="mt-5" action="<?php echo $isEdit ? '/vehicles/update' : '/vehicles/create'; ?>" method="POST">
        <?php if ($isEdit): ?>
            <input type="hidden" name="vehicle_id" value="<?php echo htmlspecialchars($vehicle['vehicle_id']); ?>">
        <?php endif; ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Vehicle Model</label>
                <input type="text" name="model" placeholder="Vehicle Model" value="<?php echo $isEdit ? htmlspecialchars($vehicle['model']) : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div>
                <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1">License Plate</label>
                <input type="text" name="license_plate" placeholder="License Plate" value="<?php echo $isEdit ? htmlspecialchars($vehicle['license_plate']) : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div>
                <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1">Vehicle Type</label>
                <select name="vehicle_type_id" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="">Select Vehicle Type</option>
                    <?php foreach ($vehicleTypes as $type): ?>
                        <option value="<?php echo htmlspecialchars($type['type_id']); ?>" <?php echo ($isEdit && $vehicle['vehicle_type_id'] == $type['type_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($type['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="total_km" class="block text-sm font-medium text-gray-700 mb-1">Total KM</label>
                <input type="number" name="total_km" placeholder="Total KM" value="<?php echo $isEdit ? htmlspecialchars($vehicle['total_km']) : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div>
                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                <input id="vehicle-latitude" type="text" name="latitude" placeholder="Latitude" readonly value="<?php echo $isEdit ? htmlspecialchars($vehicle['latitude'] ?? '') : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full bg-gray-50">
            </div>

            <div>
                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                <input id="vehicle-longitude" type="text" name="longitude" placeholder="Longitude" readonly value="<?php echo $isEdit ? htmlspecialchars($vehicle['longitude'] ?? '') : ''; ?>" class="border border-gray-300 rounded-md p-2 w-full bg-gray-50">
            </div>

            <div class="md:col-span-2">
                <div class="">
                    <h3 class="text-sm font-medium text-gray-700">Pick vehicle location</h3>
                        <button id="pick-on-map" type="button" class="text-sm px-3 py-1 rounded bg-white border border-gray-300 hover:bg-gray-100">Pick on map</button>
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="available" <?php echo ($isEdit && $vehicle['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                    <option value="reserved" <?php echo ($isEdit && $vehicle['status'] == 'reserved') ? 'selected' : ''; ?>>Reserved</option>
                    <option value="in_use" <?php echo ($isEdit && $vehicle['status'] == 'in_use') ? 'selected' : ''; ?>>In Use</option>
                    <option value="out_of_service" <?php echo ($isEdit && $vehicle['status'] == 'out_of_service') ? 'selected' : ''; ?>>Out of Service</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button type="submit" class="bg-[#CB97FF] text-black rounded-md p-2 w-full hover:bg-[#7E3FBC] hover:border-[#f0e0ff] hover:text-white border border-[#7E3FBC] border-[2px]"><?php echo $isEdit ? 'Save Changes' : 'Add Vehicle'; ?></button>
            </div>
        </div>
    </form>
</div>