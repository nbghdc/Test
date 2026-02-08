<?php
class Controller
{
    protected array $viewData = [];

    protected function view(string $view, array $data = []): void
    {
        $this->viewData = array_merge($this->viewData, $data);
        extract($this->viewData);
        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/partials/footer.php';
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
