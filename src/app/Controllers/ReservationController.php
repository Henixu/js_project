<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ReservationModel;

final class ReservationController extends Controller
{
    private ReservationModel $reservations;

    public function __construct()
    {
        $this->reservations = new ReservationModel();
    }

    public function index(): void
    {
        $this->requireLogin();

        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hotel = $_POST['hotel'] ?? '';
            $chambre = $_POST['chambre'] ?? '';
            $arrivee = $_POST['date_arrivee'] ?? '';
            $depart = $_POST['date_depart'] ?? '';
            $nbPers = (int) ($_POST['nb_personnes'] ?? 1);

            if ($hotel === '' || $chambre === '' || $arrivee === '' || $depart === '') {
                $error = 'Veuillez remplir tous les champs.';
            } elseif ($depart <= $arrivee) {
                $error = "La date de depart doit etre apres la date d'arrivee.";
            } else {
                $calculation = $this->reservations->calculateTotal($hotel, $chambre, $arrivee, $depart);
                $this->reservations->create(
                    (int) $_SESSION['user_id'],
                    $hotel,
                    $chambre,
                    $arrivee,
                    $depart,
                    $nbPers,
                    (float) $calculation['prix_total']
                );

                $success = sprintf(
                    'Reservation confirmee ! Total : <strong>%d EUR</strong> pour %d nuit(s).',
                    (int) $calculation['prix_total'],
                    (int) $calculation['nuits']
                );
            }
        }

        $this->view('reservation/index', [
            'success' => $success,
            'error' => $error,
            'tarifs' => $this->reservations->getTarifs(),
            'mes_reservations' => $this->reservations->findByUserId((int) $_SESSION['user_id']),
        ]);
    }
}
