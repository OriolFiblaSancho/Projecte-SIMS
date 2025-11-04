<div>
    <form class="mt-5" action="/vehicles/create" method="POST">
        <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Vehicle Model</label>
        <input type="text" name="model" placeholder="Vehicle Model" class="border border-gray-300 rounded-md p-2 w-full mb-4">
        <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1">License Plate</label>
        <input type="text" name="license_plate" placeholder="License Plate" class="border border-gray-300 rounded-md p-2 w-full mb-4">
        <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1">Vehicle Type</label>
        <select name="vehicle_type_id" class="border border-gray-300 rounded-md p-2 w-full mb-4">
            <option value="">Select Vehicle Type</option>
            <?php foreach ($vehicleTypes as $type): ?>
                <option value="<?php echo htmlspecialchars($type['type_id']); ?>"><?php echo htmlspecialchars($type['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="total_km" class="block text-sm font-medium text-gray-700 mb-1">Total KM</label>
        <input type="number" name="total_km" placeholder="Total KM" class="border border-gray-300 rounded-md p-2 w-full mb-4">
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="border border-gray-300 rounded-md p-2 w-full mb-4">
            <option value="available">Available</option>
            <option value="reserved">Reserved</option>
            <option value="in_use">In Use</option>
            <option value="out_of_service">Out of Service</option>
        </select>
        <button type="submit" class="bg-[#CB97FF] text-black rounded-md p-2 w-full hover:bg-[#7E3FBC] hover:border-[#f0e0ff] hover:text-white bg-[#f0e0ff] border border-[#7E3FBC] border-[2px]">Add Vehicle</button>
    </form>
</div>