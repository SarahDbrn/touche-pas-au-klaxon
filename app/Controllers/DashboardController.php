<?php
declare(strict_types=1);

class DashboardController extends Controller
{
    public function index(): void
    {
        requireLogin();

        $this->render('dashboard/index', [
            'title' => 'Dashboard',
        ]);
    }
}
