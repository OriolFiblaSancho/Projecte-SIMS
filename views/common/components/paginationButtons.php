<?php $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0; ?>
<div class="flex items-center justify-center gap-2 mt-6">
    <a href="/main?admin=ViewVehicles&offset=<?php echo max(0, $offset - 5); ?>" 
       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm <?php if ($offset <= 0) echo 'pointer-events-none opacity-50'; ?>">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Previous
    </a>
    
    <span class="px-3 py-2 text-sm font-medium text-gray-700">
        Page <?php echo floor($offset / 5) + 1; ?>
    </span>
    
    <a href="/main?admin=ViewVehicles&offset=<?php echo $offset + 5; ?>" 
       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm">
        Next
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>