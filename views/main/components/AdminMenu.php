<!-- Admin Sidebar -->
<div id="adminSidebar" class="fixed top-16 left-0 h-[calc(100vh-4rem)] z-30 flex">
    <!-- Icon Bar (Always Visible) -->
    <div class="w-[70px] md:w-[70px] bg-[#ddfae8] flex flex-col items-center pt-4 md:pt-6 pb-5 gap-4 shadow-[2px_0_8px_rgba(0,0,0,0.15)] border-r-2 border-[#0D6344]">
        <a href="?admin=ViewVehicles" title="Vehicles">
            <button class="w-12 h-12 md:w-12 md:h-12 bg-[#0D6344] rounded-xl flex items-center justify-center cursor-pointer text-white hover:bg-[#0a4d34]">
        <svg xmlns="http://www.w3.org/2000/svg" height="14" width="17.5" viewBox="0 0 640 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M147 106.7l-29.8 85.3 122.9 0 0-96-77.9 0c-6.8 0-12.9 4.3-15.1 10.7zM48.6 193.9L86.5 85.6C97.8 53.5 128.1 32 162.1 32L360 32c25.2 0 48.9 11.9 64 32l96.2 128.3C587.1 196.5 640 252.1 640 320l0 16c0 35.3-28.7 64-64 64l-16.4 0c-4 44.9-41.7 80-87.6 80s-83.6-35.1-87.6-80l-144.7 0c-4 44.9-41.7 80-87.6 80s-83.6-35.1-87.6-80l-.4 0c-35.3 0-64-28.7-64-64l0-80c0-30.1 20.7-55.3 48.6-62.1zM440 192l-67.2-89.6c-3-4-7.8-6.4-12.8-6.4l-72 0 0 96 152 0zM152 432a40 40 0 1 0 0-80 40 40 0 1 0 0 80zm360-40a40 40 0 1 0 -80 0 40 40 0 1 0 80 0z"/></svg>    
            </button>
        </a>
        <a href="?admin=ViewUsers" title="Users">
            <button class="w-12 h-12 md:w-12 md:h-12 bg-[#0D6344] rounded-xl flex items-center justify-center cursor-pointer text-white hover:bg-[#0a4d34]">
<svg xmlns="http://www.w3.org/2000/svg" height="14" width="17.5" viewBox="0 0 640 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M320 16a104 104 0 1 1 0 208 104 104 0 1 1 0-208zM96 88a72 72 0 1 1 0 144 72 72 0 1 1 0-144zM0 416c0-70.7 57.3-128 128-128 12.8 0 25.2 1.9 36.9 5.4-32.9 36.8-52.9 85.4-52.9 138.6l0 16c0 11.4 2.4 22.2 6.7 32L32 480c-17.7 0-32-14.3-32-32l0-32zm521.3 64c4.3-9.8 6.7-20.6 6.7-32l0-16c0-53.2-20-101.8-52.9-138.6 11.7-3.5 24.1-5.4 36.9-5.4 70.7 0 128 57.3 128 128l0 32c0 17.7-14.3 32-32 32l-86.7 0zM472 160a72 72 0 1 1 144 0 72 72 0 1 1 -144 0zM160 432c0-88.4 71.6-160 160-160s160 71.6 160 160l0 16c0 17.7-14.3 32-32 32l-256 0c-17.7 0-32-14.3-32-32l0-16z"/></svg>            </button>
        </a>
        <a href="?admin=ViewGeofencing" title="Geofencing">
            <button class="w-12 h-12 md:w-12 md:h-12 bg-[#0D6344] rounded-xl flex items-center justify-center cursor-pointer text-white hover:bg-[#0a4d34]">
                <svg xmlns="http://www.w3.org/2000/svg" height="14" width="17.5" viewBox="0 0 640 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M576 48c0-11.1-5.7-21.4-15.2-27.2s-21.2-6.4-31.1-1.4L413.5 77.5 234.1 17.6c-8.1-2.7-16.8-2.1-24.4 1.7l-128 64C70.8 88.8 64 99.9 64 112l0 352c0 11.1 5.7 21.4 15.2 27.2s21.2 6.4 31.1 1.4l116.1-58.1 173.3 57.8c-4.3-6.4-8.5-13.1-12.6-19.9-11-18.3-21.9-39.3-30-61.8l-101.2-33.7 0-284.5 128 42.7 0 99.3c31-35.8 77-58.4 128-58.4 22.6 0 44.2 4.4 64 12.5L576 48zM512 224c-66.3 0-120 52.8-120 117.9 0 68.9 64.1 150.4 98.6 189.3 11.6 13 31.3 13 42.9 0 34.5-38.9 98.6-120.4 98.6-189.3 0-65.1-53.7-117.9-120-117.9zM472 344a40 40 0 1 1 80 0 40 40 0 1 1 -80 0z"/></svg>
            </button>
        </a>
    </div>

    <!-- Content Panel -->
    <?php
    $adminSection = $_GET['admin'] ?? null;
    if ($adminSection !== null):
        $title = '';
        if (strpos($adminSection, 'Vehicle') !== false) {
            $title = 'Vehicles';
        } else if (strpos($adminSection, 'User') !== false) {
            $title = 'Users';
        } else if (strpos($adminSection, 'Geofencing') !== false) {
            $title = 'Geofencing';
        }
    ?>
    <div id="adminContentPanel" class="w-fit bg-white overflow-hidden border-r border-[#0D6344] flex flex-col">
        <div class="p-5 bg-[#0D6344] border-b-2 border-[#0D6344] flex justify-between items-center min-h-[70px]">
            <h2 id="adminPanelTitle" class="text-xl font-semibold text-white m-0"><?= $title ?></h2>
            <a href="?" class="bg-transparent border-none cursor-pointer text-white p-1 rounded hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5">
                    <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                </svg>
            </a>
        </div>
        <div id="adminPanelContent" class="flex-1 overflow-y-auto p-5">
            <?php require_once __DIR__ . '/../../../controllers/AdminMenuController.php'; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
