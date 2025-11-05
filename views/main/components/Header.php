<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$displayName = 'Guest';
if (!empty($_SESSION['user_id'])) {
  require_once __DIR__ . '/../../../models/userModel.php';
  try {
    $um = new UserModel();
    $u = $um->getById((int)$_SESSION['user_id']);
    if ($u) {
      $displayName = trim(($u['name'] ?? '') . ' ' . ($u['last_name'] ?? '')) ?: ($u['username'] ?? 'User');
    }
  } catch (Exception $e) {
    error_log('Header: could not load user: ' . $e->getMessage());
  }
}
?>
<button id="sideBarButton" aria-label="Open menu" class="block md:hidden">
  <svg id="openSideBar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
    <path fill-rule="evenodd"
      d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
      clip-rule="evenodd" />
  </svg>
</button>

<header class="fixed inset-x-0 top-0 z-40 hidden md:flex h-16 items-center justify-between bg-[#ddfae8] border-b border-[#0D6344] px-6">
  <div class="flex items-center gap-3 bg-white p-1 border border-[#7E3FBC] rounded">
    <img src="/assets/logos/logoPC.jpeg" alt="App logo" class="h-8 w-auto" />
  </div>

  <div class="flex items-center justify-end gap-3">
    <div id="userMenu" class="flex flex-col hidden fixed top-14 left-200 w-64 bg-[#ddfae8] border border-[#0D6344] rounded-lg shadow-2xl p-4 z-10">
      <div class="flex flex-col">
        <p class="text-sm ">Current Balance: <b>43,56€</b></p>
      </div>

      <div class="mt-4 flex flex-col gap-2">
        <button
          onclick="window.location.href='/views/addBalance/pages/addBalance.html'"
          class="flex items-center justify-between bg-[#7E3FBC] font-semibold text-white border rounded-md px-3 py-2 hover:bg-gray-200 transition">
          <span>Add balance</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4" />
          </svg>
        </button>

        <button
          class="flex items-center justify-between text-white font-semibold bg-[#7E3FBC] border rounded-md px-3 py-2 hover:bg-gray-200 transition">
          <span>Buy single ticket</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M3 14h18M5 6h14M5 18h14" />
          </svg>
        </button>

        <button
            onclick="window.location.href='/views/pages/cookies.html'"
            class="flex items-center justify-between bg-white border rounded-md px-3 py-2 hover:bg-gray-200 transition">
            <span>Cookie Policy</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
      </div>

      <div class="flex mt-4 justify-between">
        <button id="userMenuConfigButton">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.59-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
          </svg>
        </button>

        <button id="Logout" onclick="window.location.href='/index.html'">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path fill-rule="evenodd"
              d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

    <button id="userMenuButton" aria-label="User">
      <span class="text-md text-black font-bold"><?= htmlspecialchars($displayName) ?></span>
    </button>

    <script>
      const userMenuButton = document.getElementById('userMenuButton');
      const userMenu = document.getElementById('userMenu');

      // Mostrar / ocultar el menú al hacer click
      userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
      });

      // Cerrar el menú si se hace click fuera
      document.addEventListener('click', (e) => {
        if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
          userMenu.classList.add('hidden');
        }
      });
    </script>

  </div>
</header>
