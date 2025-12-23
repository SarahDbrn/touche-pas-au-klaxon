<?php
declare(strict_types=1);

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = APP_PATH . '/Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View not found: " . htmlspecialchars($view);
            return;
        }

        require $viewFile;
    }
}
