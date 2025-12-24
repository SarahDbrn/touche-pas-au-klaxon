<?php
declare(strict_types=1);

class HomeController extends Controller
{
    public function index(): void
    {
        // Appel au modèle pour récupérer les trajets à venir
        $trips = Trip::getUpcomingAvailableTrips();

        $this->render('home/index', [
            'title' => 'Accueil - Touche pas au klaxon',
            'trips' => $trips
        ]);
    }
}
