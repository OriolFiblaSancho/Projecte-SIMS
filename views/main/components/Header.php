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
<button id="sideBarButton" aria-label="<?= htmlspecialchars(function_exists('t') ? t('open_menu') : 'Open menu', ENT_QUOTES) ?>" class="block md:hidden">
  <svg id="openSideBar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
    <path fill-rule="evenodd"
      d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
      clip-rule="evenodd" />
  </svg>
</button>

<header class="fixed inset-x-0 top-0 z-40 hidden md:flex h-16 items-center justify-between bg-[#ddfae8]/95 backdrop-blur-md border-b border-[#0D6344]/20 px-6 shadow-md">
  <div class="flex items-center gap-3 bg-white p-1 border border-[#7E3FBC] rounded">
    <img src="/assets/logos/logoPC.jpeg" alt="<?= htmlspecialchars(function_exists('t') ? t('app_logo_alt') : 'App logo', ENT_QUOTES) ?>" class="h-8 w-auto" />
  </div>

  <div class="flex items-center justify-end gap-3">
  <div class="flex items-center gap-2 mr-2 relative">
    <?php $currentLang = function_exists('get_locale') ? get_locale() : 'en'; ?>
    <label class="sr-only"><?= htmlspecialchars(function_exists('t') ? t('language_label') : 'Language', ENT_QUOTES) ?></label>
    <div class="relative">
      <button id="langMenuButton" aria-haspopup="true" aria-expanded="false" type="button" class="inline-flex items-center gap-2 bg-white border border-gray-200 shadow-sm rounded-full px-3 py-1 text-sm font-medium hover:shadow-md transition">
        <span class="flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 text-xs font-semibold"><?= htmlspecialchars(strtoupper($currentLang), ENT_QUOTES) ?></span>
          <span class="hidden sm:inline text-neutral-700"><?php echo htmlspecialchars(function_exists('t') ? ($currentLang === 'ca' ? t('catala') : t('english')) : ($currentLang === 'ca' ? 'Català' : 'English'), ENT_QUOTES); ?></span>
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/></svg>
      </button>

      <div id="langMenu" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-lg z-50 overflow-hidden">
        <button type="button" onclick="changeLang('ca')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-emerald-50 text-xs font-medium">CA</span>
          <span class="text-sm text-neutral-700"><?= htmlspecialchars(function_exists('t') ? t('catala') : 'Català', ENT_QUOTES) ?></span>
        </button>
        <button type="button" onclick="changeLang('en')" class="w-full text-left px-4 py-2 hover:bg-gray-50 flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-sky-50 text-xs font-medium">EN</span>
          <span class="text-sm text-neutral-700"><?= htmlspecialchars(function_exists('t') ? t('english') : 'English', ENT_QUOTES) ?></span>
        </button>
      </div>
    </div>
  </div>
  <div id="userMenu" class="flex flex-col hidden fixed top-14 right-4 w-64 bg-[#e7fff6] border border-[#8bd7bf] rounded-lg shadow-md p-3 z-30">
      <div class="px-3 py-2 rounded-md">
        <p class="text-sm text-neutral-700"><?php echo htmlspecialchars(function_exists('t') ? t('current_balance') : 'Current Balance', ENT_QUOTES); ?>: <b class="text-black">43,56€</b></p>
      </div>

      <div class="mt-3 flex flex-col gap-3 px-3">
        <button
          onclick="window.location.href='/views/addBalance/pages/addBalance.php'"
          class="w-full flex items-center justify-between bg-[#7E3FBC] text-white font-semibold rounded-lg px-4 py-3 shadow-sm hover:opacity-95 transition">
          <span><?= htmlspecialchars(function_exists('t') ? t('add_balance') : 'Add balance', ENT_QUOTES) ?></span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </button>

        <button
          onclick="window.location.href='/views/scan/pages/scan.php'"
          class="w-full flex items-center justify-between bg-[#7E3FBC] text-white font-semibold rounded-lg px-4 py-3 shadow-sm hover:opacity-95 transition">
          <span><?= htmlspecialchars(function_exists('t') ? t('buy_single_ticket') : 'Buy single ticket', ENT_QUOTES) ?></span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M5 6h14M5 18h14" />
          </svg>
        </button>

        <button
          onclick="window.location.href='/views/pages/cookies.php'"
            class="w-full flex items-center justify-between bg-white border rounded-lg px-4 py-3 shadow-sm hover:bg-gray-50 transition">
            <span><?= htmlspecialchars(function_exists('t') ? t('cookie_policy') : 'Cookie Policy', ENT_QUOTES) ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
      </div>

      <div class="flex items-center justify-between mt-3 px-3">
        <button id="userMenuConfigButton" class="p-2 text-black">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.59-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
          </svg>
        </button>

        <button id="Logout" onclick="window.location.href='/'" class="p-2 text-black" title="<?= htmlspecialchars(function_exists('t') ? t('logout') : 'Logout', ENT_QUOTES) ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

    <button id="userMenuButton" aria-label="<?= htmlspecialchars(function_exists('t') ? t('user') : 'User', ENT_QUOTES) ?>">
      <span class="text-md text-black font-bold"><?php if (empty($displayName)) { echo htmlspecialchars(function_exists('t') ? t('guest') : 'Guest', ENT_QUOTES); } else { echo htmlspecialchars($displayName, ENT_QUOTES); } ?></span>
    </button>

    <script>
      function changeLang(lang) {
        try {
          const url = new URL(window.location.href);
          url.searchParams.set('lang', lang);
          // Reload to same path with updated lang param
          window.location.href = url.toString();
        } catch (e) {
          // Fallback: append ?lang=
          const sep = window.location.search ? '&' : '?';
          window.location.href = window.location.pathname + window.location.search + sep + 'lang=' + encodeURIComponent(lang);
        }
      }

      const userMenuButton = document.getElementById('userMenuButton');
      const userMenu = document.getElementById('userMenu');
      const langMenuButton = document.getElementById('langMenuButton');
      const langMenu = document.getElementById('langMenu');

      if (langMenuButton) {
        langMenuButton.addEventListener('click', (e) => {
          e.stopPropagation();
          const expanded = langMenuButton.getAttribute('aria-expanded') === 'true';
          langMenuButton.setAttribute('aria-expanded', String(!expanded));
          if (langMenu) langMenu.classList.toggle('hidden');
        });
      }

      userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
      });

      const userSettingsPanel = document.getElementById('userSettingsPanel');
      document.addEventListener('click', (e) => {
        // If the click is outside the user menu, the user menu button, AND outside
        // the settings panel, then hide the user menu. This prevents the settings
        // panel from causing the header click handler to close UI while interacting
        // with the panel.
        if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target) && !(userSettingsPanel && userSettingsPanel.contains(e.target))) {
          userMenu.classList.add('hidden');
        }

        // Close language menu if click is outside it
        if (langMenu && !langMenu.contains(e.target) && !(langMenuButton && langMenuButton.contains(e.target))) {
          langMenu.classList.add('hidden');
          if (langMenuButton) langMenuButton.setAttribute('aria-expanded', 'false');
        }
      });
    </script>

  </div>
</header>
