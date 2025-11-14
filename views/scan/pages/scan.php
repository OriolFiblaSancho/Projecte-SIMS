<?php
require_once __DIR__ . '/../../../helpers/i18n.php';
set_locale();
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(get_locale(), ENT_QUOTES) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t('scan_title'), ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="../styles/scan.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../common/styles/tailwindStyle.js"></script>
</head>
<body>

    <main>
    <a class="goBackBtn" href="/main">
            <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </a>
        

        <div class="header">
            
            <h1><?= htmlspecialchars(t('scan_header'), ENT_QUOTES) ?></h1>
            <h3 id="textSub"><?= htmlspecialchars(t('scan_sub'), ENT_QUOTES) ?></h3>
        </div>

        <div id="camera"></div>

        <div id="keyboard" style="display: none;">
            <input type="text" id="typedId" placeholder="<?= htmlspecialchars(t('type_id'), ENT_QUOTES) ?>" style="display: none;"/>
            <button id="submitIdBtn" class="btn"><?= htmlspecialchars(t('submit'), ENT_QUOTES) ?></button>
        </div>

        <div id="buttons">
            <button id="typeIdBtn" class="btn">
                <b id="changeModeText"><?= htmlspecialchars(t('type_id'), ENT_QUOTES) ?> </b>
                <!-- icons omitted for brevity -->
            </button>
        </div>

    </main>

    <script src="../scripts/scan.js" defer></script>
</body>
</html>
