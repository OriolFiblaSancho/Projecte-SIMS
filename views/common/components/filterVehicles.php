<?php
$currentSearch = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$currentVehicleType = isset($_GET['vehicle_type_id']) ? htmlspecialchars($_GET['vehicle_type_id']) : '';
$currentStatus = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
$filterBase = isset($paginationBase) ? $paginationBase : '/main?admin=ViewVehicles';
// Vehicle types should be passed from controller
$vehicleTypes = isset($vehicleTypes) ? $vehicleTypes : [];
?>
<div class="bg-white border border-gray-300 rounded-lg p-4 mb-4 shadow-sm">
    <form method="GET" action="/main" class="flex flex-wrap gap-3 items-end">
        <input type="hidden" name="admin" value="ViewVehicles">
        
        <!-- Search Input -->
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1"><?php echo t('filter_search_label'); ?></label>
            <input 
                type="text" 
                id="search" 
                name="search" 
                value="<?php echo $currentSearch; ?>"
                placeholder="<?php echo t('filter_vehicle_placeholder'); ?>"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
        </div>

        <!-- Vehicle Type Filter -->
        <div class="flex-1 min-w-[150px]">
            <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-1"><?php echo t('vehicle_form_type_label'); ?></label>
            <select 
                id="vehicle_type_id" 
                name="vehicle_type_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
                <option value=""><?php echo t('filter_all_types'); ?></option>
                <?php foreach ($vehicleTypes as $type): ?>
                    <option value="<?php echo htmlspecialchars($type['type_id']); ?>" <?php echo $currentVehicleType == $type['type_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($type['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="flex-1 min-w-[150px]">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1"><?php echo t('status_label'); ?></label>
            <select 
                id="status" 
                name="status"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
                <option value=""><?php echo t('filter_all_status'); ?></option>
                <option value="available" <?php echo $currentStatus === 'available' ? 'selected' : ''; ?>><?php echo t('vehicle_status_available'); ?></option>
                <option value="reserved" <?php echo $currentStatus === 'reserved' ? 'selected' : ''; ?>><?php echo t('vehicle_status_reserved'); ?></option>
                <option value="in_use" <?php echo $currentStatus === 'in_use' ? 'selected' : ''; ?>><?php echo t('vehicle_status_in_use'); ?></option>
                <option value="out_of_service" <?php echo $currentStatus === 'out_of_service' ? 'selected' : ''; ?>><?php echo t('vehicle_status_out_of_service'); ?></option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button 
                type="submit"
                class="px-4 py-2 bg-[#0D6344] text-white rounded-md hover:bg-[#0a4d33] transition-colors duration-200 text-sm font-medium"
            >
                <?php echo t('filter_apply_filters'); ?>
            </button>
            <a 
                href="<?php echo $filterBase; ?>"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-200 text-sm font-medium"
            >
                <?php echo t('filter_clear'); ?>
            </a>
        </div>
    </form>
</div>
