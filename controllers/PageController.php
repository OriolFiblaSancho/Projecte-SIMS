<?php

class PageController {
    public function landing() {
        // Mostra la landing existent (index.html)
        require __DIR__ . '/../index.html';
    }

    public function main() {
        // Mostra la pàgina principal del mapa
        require __DIR__ . '/../views/main/pages/main.php';
    }
}
