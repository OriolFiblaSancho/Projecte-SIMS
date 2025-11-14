<?php
require_once __DIR__ . '/../../helpers/i18n.php';
set_locale();
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(get_locale(), ENT_QUOTES) ?>">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars(t('cookie_policy_title'), ENT_QUOTES) ?> - Blink</title>
  <link rel="stylesheet" href="/views/common/styles/base.css">
  <link rel="stylesheet" href="/views/common/styles/theme.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="font-montserrat bg-gray-50 min-h-screen">

    <header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <img src="/assets/logos/logoPC.jpeg" alt="<?= htmlspecialchars(t('app_logo_alt'), ENT_QUOTES) ?>" class="hidden md:block h-10 w-auto">
          <img src="/assets/logos/logoMobile.jpeg" alt="<?= htmlspecialchars(t('app_logo_alt'), ENT_QUOTES) ?>" class="md:hidden h-10 w-auto">
        </div>
  <a href="/main" class="text-primary hover:text-primary/80 font-semibold transition-colors"><?= htmlspecialchars(t('cookie_back'), ENT_QUOTES) ?></a>
      </div>
    </div>
  </header>

  <main class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-6 text-gray-800"><?= htmlspecialchars(t('cookie_policy_title'), ENT_QUOTES) ?></h1>
    <p class="text-gray-600 mb-8 text-lg"><?= htmlspecialchars(t('cookie_last_updated'), ENT_QUOTES) ?></p>

    <section class="mb-8">
      <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars(t('cookie_what_are'), ENT_QUOTES) ?></h2>
      <p class="text-gray-600 mb-4">
        <?= htmlspecialchars(t('cookie_what_are'), ENT_QUOTES) ?>
      </p>
    </section>

    <section class="mb-8">
      <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars(t('cookie_types'), ENT_QUOTES) ?></h2>
      <div class="space-y-4">
        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h3 class="text-xl font-semibold mb-2 text-primary"><?= htmlspecialchars(t('cookie_necessary'), ENT_QUOTES) ?></h3>
          <p class="text-gray-600">
            <?= htmlspecialchars(t('cookie_necessary'), ENT_QUOTES) ?>
          </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h3 class="text-xl font-semibold mb-2 text-primary"><?= htmlspecialchars(t('cookie_preference'), ENT_QUOTES) ?></h3>
          <p class="text-gray-600">
            <?= htmlspecialchars(t('cookie_preference'), ENT_QUOTES) ?>
          </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h3 class="text-xl font-semibold mb-2 text-primary"><?= htmlspecialchars(t('cookie_analytical'), ENT_QUOTES) ?></h3>
          <p class="text-gray-600">
            <?= htmlspecialchars(t('cookie_analytical'), ENT_QUOTES) ?>
          </p>
        </div>
      </div>
    </section>

    <section class="mb-8">
      <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars(t('cookie_management'), ENT_QUOTES) ?></h2>
      <p class="text-gray-600 mb-4">
        <?= htmlspecialchars(t('cookie_management'), ENT_QUOTES) ?>
      </p>
      <p class="text-gray-600 mb-6">
        <?= htmlspecialchars(t('cookie_what_are'), ENT_QUOTES) ?>
      </p>
      <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-6">
        <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener" class="text-primary hover:underline">Google Chrome</a></li>
        <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener" class="text-primary hover:underline">Mozilla Firefox</a></li>
        <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener" class="text-primary hover:underline">Safari</a></li>
        <li><a href="https://support.microsoft.com/es-es/microsoft-edge/eliminar-las-cookies-en-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener" class="text-primary hover:underline">Microsoft Edge</a></li>
      </ul>

      <div class="bg-primary/10 p-6 rounded-lg">
        <p class="text-gray-700 mb-4">
          <strong>Please note:</strong> <?= htmlspecialchars(t('cookie_management'), ENT_QUOTES) ?>
        </p>
      </div>
    </section>

    <section class="mb-8">
      <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars(t('cookie_modifications'), ENT_QUOTES) ?></h2>
      <p class="text-gray-600 mb-4">
        <?= htmlspecialchars(t('cookie_modifications'), ENT_QUOTES) ?>
      </p>
    </section>

    <section class="mb-8">
      <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= htmlspecialchars(t('cookie_contact'), ENT_QUOTES) ?></h2>
      <p class="text-gray-600 mb-4">
        <?= htmlspecialchars(t('cookie_contact'), ENT_QUOTES) ?>
      </p>
      <ul class="list-none text-gray-600 space-y-2">
        <li><strong><?= htmlspecialchars(t('cookie_email'), ENT_QUOTES) ?>:</strong> info@blink.com</li>
        <li><strong><?= htmlspecialchars(t('cookie_phone'), ENT_QUOTES) ?>:</strong> +34 600 123 456</li>
      </ul>
    </section>

    <div class="mt-12 pt-8 border-t border-gray-300">
      <a href="/main" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
        <?= htmlspecialchars(t('cookie_back'), ENT_QUOTES) ?>
      </a>
    </div>
  </main>

  <footer class="bg-primary text-white mt-16">
    <div class="container mx-auto px-4 py-8 text-center">
      <p><?= htmlspecialchars(t('copyright'), ENT_QUOTES) ?></p>
    </div>
  </footer>
</body>
</html>
