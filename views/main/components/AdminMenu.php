<div class="absolute top-20 left-4 z-10 bg-[#CB97FF] rounded-md p-4 shadow-lg hidden md:block border border-[#7E3FBC] max-h-[calc(100vh-6rem)] overflow-y-auto scrolling-touch" id="adminMenu">
    <div class="flex relative justify-between">
        <h1 class="text-lg font-semibold mb-2">Admin Menu</h1>
        <button class="absolute right-0 top-0" id='closeAdminMenu'>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
            </svg>
        </button>
    </div>


    <nav aria-label="Admin navigation" class="bg-white/70 rounded-md border border-[#7E3FBC] w-full max-w-[280px]">
        <ul class="flex">
            <li class="border-r border-[#7E3FBC]">
                <a href="?admin=ViewUsers" class="text-center mx-3 hover:bg-[#d5c3eb] font-medium text-md text-[#2d0a4a]">Users</a>
            </li>
            <li class="border-r border-[#7E3FBC]">
                <a href="?admin=ViewVehicles" class="text-center mx-3 hover:bg-[#d5c3eb] font-medium text-md text-[#2d0a4a]">Vehicles</a>
            </li>
            <li class="">
                <a href="?admin=ViewGeofencing" class="text-center mx-3 hover:bg-[#d5c3eb] font-medium text-md text-[#2d0a4a]">Geofencing</a>
            </li>
        </ul>
    </nav>
    <?php require_once __DIR__ . '/../../../controllers/AdminMenuController.php'; ?>
</div>
<script>
    document.getElementById('closeAdminMenu').addEventListener('click', function(event) {
        window.location.href = '?';
    });
</script>
