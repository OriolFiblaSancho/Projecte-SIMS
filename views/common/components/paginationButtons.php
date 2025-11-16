<?php
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$step = isset($step) ? (int)$step : 7;
$paginationBase = isset($paginationBase) ? $paginationBase : '/main?admin=ViewVehicles';
$isLast = isset($maxOffset) ? ($offset >= $maxOffset) : false;
$nextOffset = $isLast ? $offset : $offset + $step;
$sep = (strpos($paginationBase, '?') !== false) ? '&' : '?';

// Build query string preserving all existing GET parameters except offset
$queryParams = [];
foreach ($_GET as $key => $value) {
    if ($key !== 'offset' && !empty($value)) {
        $queryParams[$key] = $value;
    }
}

// Function to build pagination URL with all parameters
function buildPaginationUrl($base, $separator, $offset, $params) {
    $url = $base . $separator . 'offset=' . $offset;
    foreach ($params as $key => $value) {
        $url .= '&' . urlencode($key) . '=' . urlencode($value);
    }
    return $url;
}

$prevUrl = buildPaginationUrl($paginationBase, $sep, max(0, $offset - $step), $queryParams);
$nextUrl = buildPaginationUrl($paginationBase, $sep, $nextOffset, $queryParams);
?>
<div class="flex items-center justify-center gap-2 mt-6">
    <a href="<?php echo $prevUrl; ?>" 
       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm <?php if ($offset <= 0) echo 'pointer-events-none opacity-50'; ?>">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <?php echo t('pagination_previous'); ?>
    </a>
    
    <span class="px-3 py-2 text-sm font-medium text-gray-700">
        <?php echo t('pagination_page'); ?> <?php echo floor($offset / $step) + 1; ?>
    </span>
    
     <a href="<?php echo $nextUrl; ?>" 
         class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm <?php if ($isLast) echo 'pointer-events-none opacity-50'; ?>">
        <?php echo t('pagination_next'); ?>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>