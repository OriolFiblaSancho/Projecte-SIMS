<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentUser = [];
$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    require_once __DIR__ . '/../../../config/database.php';
    $pdo = Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT username, name, last_name, email, phone, driver_license FROM users WHERE user_id = :id AND deleted = false");
    $stmt->bindValue(':id', (int)$userId, PDO::PARAM_INT);
    $stmt->execute();
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}
?>

<div id="userSettingsPanel" class="hidden fixed top-20 right-4 z-40 bg-white rounded-md shadow-lg border border-[#d6c3f0] w-[420px] max-w-[95vw] p-4">
  <div class="flex items-center justify-between mb-2">
   <h3 class="text-lg font-semibold text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('user_settings_title') : "Configuració d'usuari", ENT_QUOTES); ?></h3>
   <button id="closeUserSettings" class="p-1 hover:opacity-80" aria-label="<?= htmlspecialchars(function_exists('t') ? t('close') : 'Tancar', ENT_QUOTES) ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4">
        <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
      </svg>
    </button>
  </div>
    <div id="userSettingsMessage" class="hidden mb-2 text-sm rounded px-3 py-2"></div>


  <form id="userSettingsForm" method="post" action="/settings/save">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
      <div>
         <label class="block text-sm font-medium text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('name_label') : 'Nom', ENT_QUOTES); ?></label>
         <input name="name" value="<?php echo htmlspecialchars($currentUser['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
           class="mt-1 w-full rounded border px-3 py-2" placeholder="<?= htmlspecialchars(function_exists('t') ? t('optional') : 'Opcional', ENT_QUOTES) ?>" />
      </div>
      <div>
         <label class="block text-sm font-medium text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('label_last_name') : 'Cognoms', ENT_QUOTES); ?></label>
         <input name="last_name" value="<?php echo htmlspecialchars($currentUser['last_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
           class="mt-1 w-full rounded border px-3 py-2" placeholder="<?= htmlspecialchars(function_exists('t') ? t('optional') : 'Opcional', ENT_QUOTES) ?>" />
      </div>
      <div>
         <label class="block text-sm font-medium text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('label_phone') : 'Telèfon', ENT_QUOTES); ?></label>
         <input name="phone" value="<?php echo htmlspecialchars($currentUser['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
           class="mt-1 w-full rounded border px-3 py-2" placeholder="<?= htmlspecialchars(function_exists('t') ? t('optional') : 'Opcional', ENT_QUOTES) ?>" />
      </div>
      <div>
         <label class="block text-sm font-medium text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('label_driver_license') : 'Permís de conduir', ENT_QUOTES); ?></label>
         <input name="driver_license" value="<?php echo htmlspecialchars($currentUser['driver_license'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
           class="mt-1 w-full rounded border px-3 py-2" placeholder="<?= htmlspecialchars(function_exists('t') ? t('optional') : 'Opcional', ENT_QUOTES) ?>" />
      </div>
      <div>
         <label class="block text-sm font-medium text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('label_username') : 'Nom d\'usuari', ENT_QUOTES); ?></label>
         <input name="username" value="<?php echo htmlspecialchars($currentUser['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
           class="mt-1 w-full rounded border px-3 py-2" placeholder="<?= htmlspecialchars(function_exists('t') ? t('optional') : 'Opcional', ENT_QUOTES) ?>" />
      </div>
      <div>
        <label class="block text-sm font-medium text-[#2d0a4a]"><?php echo htmlspecialchars(function_exists('t') ? t('label_email_readonly') : "Email (només lectura)", ENT_QUOTES); ?></label>
        <input value="<?php echo htmlspecialchars($currentUser['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
               class="mt-1 w-full rounded border px-3 py-2 bg-gray-100 text-gray-600" disabled />
      </div>
    </div>

    <div class="flex justify-end gap-2 mt-3 md:col-span-2">
      <button type="button" id="cancelUserSettings" class="px-3 py-1 rounded border border-[#7E3FBC] text-[#2d0a4a] hover:bg-[#f2e9fb]"><?php echo htmlspecialchars(function_exists('t') ? t('btn_cancel') : 'Cancel·lar', ENT_QUOTES); ?></button>
      <button type="submit" class="px-3 py-1 rounded bg-[#7E3FBC] text-white hover:bg-[#6c36aa]"><?php echo htmlspecialchars(function_exists('t') ? t('btn_save') : 'Desar', ENT_QUOTES); ?></button>
    </div>
  </form>
</div>

<script>
  document.getElementById('userMenuConfigButton')?.addEventListener('click', (e) => {
    e.stopPropagation();
    e.preventDefault();
    const panel = document.getElementById('userSettingsPanel');
    if (panel) panel.classList.toggle('hidden');
  });

  document.getElementById('closeUserSettings')?.addEventListener('click', () => {
    document.getElementById('userSettingsPanel')?.classList.add('hidden');
  });
  document.getElementById('cancelUserSettings')?.addEventListener('click', () => {
    document.getElementById('userSettingsPanel')?.classList.add('hidden');
  });

  document.getElementById('userSettingsForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const fd = new FormData(form);
    try {
      const res = await fetch(form.action, {
        method: 'POST',
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const json = await res.json();
            const msg = document.getElementById('userSettingsMessage');
            if (msg) {
              msg.classList.remove('hidden');
              // reset visual state
              msg.classList.remove('bg-red-50','border-red-300','text-red-800','bg-green-50','border-green-300','text-green-800','border');
              if (json.success) {
                msg.classList.add('bg-green-50','border-green-300','text-green-800','border');
                msg.textContent = json.message || '<?= htmlspecialchars(function_exists('t') ? t('saved_success') : 'Saved successfully', ENT_QUOTES) ?>';
              } else {
                msg.classList.add('bg-red-50','border-red-300','text-red-800','border');
                msg.textContent = json.message || '<?= htmlspecialchars(function_exists('t') ? t('error_generic') : 'Error', ENT_QUOTES) ?>';
              }

          if (json.success && json.user) {
            try {
              const u = json.user;
              const nameParts = ((u.name || '') + ' ' + (u.last_name || '')).trim();
              const display = nameParts || (u.username || 'User');
              const headerSpan = document.querySelector('#userMenuButton span');
              if (headerSpan) headerSpan.textContent = display;
            } catch (e) {
            }
          }

          if (json.success) {
            setTimeout(() => {
              document.getElementById('userSettingsPanel')?.classList.add('hidden');
              msg.classList.add('hidden');
            }, 1400);
          }
        }
        
    } catch (err) {
      const msg = document.getElementById('userSettingsMessage');
      if (msg) {
        msg.classList.remove('hidden');
        msg.classList.remove('bg-green-50','border-green-300','text-green-800','border');
        msg.classList.add('bg-red-50','border-red-300','text-red-800','border');
        msg.textContent = '<?= htmlspecialchars(function_exists('t') ? t('error_network') : 'Network error', ENT_QUOTES) ?>';
      }
    }
  });
</script>
