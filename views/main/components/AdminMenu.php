<div class="absolute top-20 left-4 z-10 bg-[#CB97FF] rounded-md p-4 shadow-lg hidden md:block border border-[#7E3FBC]" id="adminMenu">
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
        <?php
            $adminSection = $_GET['admin'] ?? null;
            if ($adminSection === 'ViewVehicles') {
                require_once __DIR__ . '/../../../controllers/vehicleController.php';
                $vc = new VehicleController();
                $vc->getAll();
            } else if ($adminSection === 'FormVehicles') {
                include __DIR__ . '/../../../controllers/vehicleTypeController.php';
                $vtc = new VehicleTypeController();
                $vtc->getAll();
            } else if ($adminSection === 'ViewUsers') {
                // Mostrar listado de usuarios
                require_once __DIR__ . '/../../../controllers/userController.php';
                $uc = new UserController();
                $uc->getAll();
            } else if ($adminSection === 'FormUsers') {
                // Mostrar formulario de usuario (nuevo/editar)
                require_once __DIR__ . '/../../../controllers/userController.php';
                $uc = new UserController();
                $uc->form($_GET['id'] ?? null);
            }
            // Add more sections as needed
        ?>

</div>
<script >
    // Close Menu when clicking outside
    document.getElementById('closeAdminMenu').addEventListener('click', function(event) {
        window.location.href = '?';
    });
</script>
