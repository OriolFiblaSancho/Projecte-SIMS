<?php
$googleApiKey = getenv(name:'GOOGLE_MAPS_API_KEY');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(function_exists('get_locale') ? get_locale() : 'en', ENT_QUOTES) ?>">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blink - <?= htmlspecialchars(function_exists('t') ? t('welcome') : 'Welcome', ENT_QUOTES) ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="stylesheet" href="/views/common/styles/theme.css">
  <link rel="stylesheet" href="/views/common/styles/base.css">
  <link rel="stylesheet" href="/views/main/styles/map.css">
  <link rel="stylesheet" href="/views/main/styles/bottom.css">
  <link rel="stylesheet" href="/views/main/styles/side.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-w-[390px] relative">
  <?php require_once __DIR__ . '/../components/Header.php'; ?>

  <?php
  if (session_status() === PHP_SESSION_NONE) session_start();

  if (!empty($_SESSION['user_id'])) {
    require_once __DIR__ . '/../../../models/userModel.php';
    $u = (new UserModel())->getById((int)$_SESSION['user_id']);
    if (!empty($u['user_type']) && $u['user_type'] === 'admin') {
      require_once __DIR__ . '/../components/AdminMenu.php';
    }
  }
  ?>
  
  <div id="map" class="fixed inset-0"></div>
  <?php require_once __DIR__ . '/../components/SideBar.php'; ?>
  <?php require_once __DIR__ . '/../components/BottomBar.php'; ?>
  <?php require_once __DIR__ . '/../components/ReserveModal.php'; ?>
  <?php require_once __DIR__ . '/../components/UserSettings.php'; ?>

  <script type="module" src="/views/main/scripts/init.js"></script>
  <script src="/views/main/scripts/reserve.js" defer></script>
  <script src="/views/main/scripts/sideBar.js" defer></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleApiKey ?>&callback=initMap&v=weekly" defer></script>
</body>
</html>