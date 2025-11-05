<?php
$googleApiKey = getenv(name:'GOOGLE_MAPS_API_KEY');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blink</title>

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
  <?php require_once __DIR__ . '/../components/AdminMenu.php'; ?>
  <?php require_once __DIR__ . '/../components/Header.php'; ?>
  <?php
    if (!empty($_SESSION['error'])) {
      $msg = htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
      echo "<div class='flash flash-error' role='alert' style='background:#fee; color:#800; padding:8px; border:1px solid #f99; margin:8px;'>$msg</div>";
      unset($_SESSION['error']);
    }
    if (!empty($_SESSION['success'])) {
      $msg = htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8');
      echo "<div class='flash flash-success' role='status' style='background:#e7f9ed; color:#14532d; padding:8px; border:1px solid #86efac; margin:8px;'>$msg</div>";
      unset($_SESSION['success']);
    }
  ?>
  <div id="map" class="fixed inset-0"></div>
  <?php require_once __DIR__ . '/../components/SideBar.php'; ?>
  <?php require_once __DIR__ . '/../components/BottomBar.php'; ?>
  <?php require_once __DIR__ . '/../components/ReserveModal.php'; ?>

  <script type="module" src="/views/main/scripts/init.js"></script>
  <script src="/views/main/scripts/reserve.js" defer></script>
  <script src="/views/main/scripts/sideBar.js" defer></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleApiKey ?>&callback=initMap&v=weekly" defer></script>
</body>
</html>