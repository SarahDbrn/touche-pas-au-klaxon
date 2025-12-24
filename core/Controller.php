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

        $header = APP_PATH . '/Views/layouts/header.php';
        $footer = APP_PATH . '/Views/layouts/footer.php';
        $flash  = APP_PATH . '/Views/layouts/flash.php';

        require $header;
        if (file_exists($flash)) {
            require $flash;
        }
        require $viewFile;
        require $footer;
    }
}
