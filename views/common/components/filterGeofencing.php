<?php
$currentSearch = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$currentType = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
$filterBase = isset($paginationBase) ? $paginationBase : '/main?admin=ViewGeofencing';
?>
<div class="bg-white border border-gray-300 rounded-lg p-4 mb-4 shadow-sm">
    <form method="GET" action="/main" class="flex flex-wrap gap-3 items-end">
        <input type="hidden" name="admin" value="ViewGeofencing">
        
        <!-- Search Input -->
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input 
                type="text" 
                id="search" 
                name="search" 
                value="<?php echo $currentSearch; ?>"
                placeholder="Zone name..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
        </div>

        <!-- Type Filter -->
        <div class="flex-1 min-w-[180px]">
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Zone Type</label>
            <select 
                id="type" 
                name="type"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
                <option value="">All Types</option>
                <option value="school" <?php echo $currentType === 'school' ? 'selected' : ''; ?>>School</option>
                <option value="hospital" <?php echo $currentType === 'hospital' ? 'selected' : ''; ?>>Hospital</option>
                <option value="historic_center" <?php echo $currentType === 'historic_center' ? 'selected' : ''; ?>>Historic Center</option>
                <option value="residential_area" <?php echo $currentType === 'residential_area' ? 'selected' : ''; ?>>Residential Area</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button 
                type="submit"
                class="px-4 py-2 bg-[#0D6344] text-white rounded-md hover:bg-[#0a4d33] transition-colors duration-200 text-sm font-medium"
            >
                Apply Filters
            </button>
            <a 
                href="<?php echo $filterBase; ?>"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-200 text-sm font-medium"
            >
                Clear
            </a>
        </div>
    </form>
</div>
