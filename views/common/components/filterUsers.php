<?php
$currentSearch = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$currentUserType = isset($_GET['user_type']) ? htmlspecialchars($_GET['user_type']) : '';
$currentStatus = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
$filterBase = isset($paginationBase) ? $paginationBase : '/main?admin=ViewUsers';
?>
<div class="bg-white border border-gray-300 rounded-lg p-4 mb-4 shadow-sm">
    <form method="GET" action="/main" class="flex flex-wrap gap-3 items-end">
        <input type="hidden" name="admin" value="ViewUsers">
        
        <!-- Search Input -->
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input 
                type="text" 
                id="search" 
                name="search" 
                value="<?php echo $currentSearch; ?>"
                placeholder="Name, email, username..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
        </div>

        <!-- User Type Filter -->
        <div class="flex-1 min-w-[150px]">
            <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
            <select 
                id="user_type" 
                name="user_type"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
                <option value="">All Types</option>
                <option value="customer" <?php echo $currentUserType === 'customer' ? 'selected' : ''; ?>>Customer</option>
                <option value="admin" <?php echo $currentUserType === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="flex-1 min-w-[150px]">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select 
                id="status" 
                name="status"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D6344] focus:border-transparent text-sm"
            >
                <option value="">All Status</option>
                <option value="verified" <?php echo $currentStatus === 'verified' ? 'selected' : ''; ?>>Verified</option>
                <option value="non-verified" <?php echo $currentStatus === 'non-verified' ? 'selected' : ''; ?>>Non-verified</option>
                <option value="suspended" <?php echo $currentStatus === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
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
