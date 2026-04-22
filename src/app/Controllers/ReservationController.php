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
            $userId = (int) $_SESSION['user_id'];

            if ($this->reservations->hasPendingReservation($userId)) {
                $error = 'Vous avez deja une reservation en attente. Attendez la confirmation avant de creer une nouvelle reservation.';
            } elseif ($hotel === '' || $chambre === '' || $arrivee === '' || $depart === '') {
                $error = 'Veuillez remplir tous les champs.';
            } elseif ($depart <= $arrivee) {
                $error = "La date de depart doit etre apres la date d'arrivee.";
            } else {
                $calculation = $this->reservations->calculateTotal($hotel, $chambre, $arrivee, $depart);
                $this->reservations->create(
                    $userId,
                    $hotel,
                    $chambre,
                    $arrivee,
                    $depart,
                    $nbPers,
                    (float) $calculation['prix_total']
                );

                $success = sprintf(
                    'Reservation en attente enregistree ! Total : <strong>%d EUR</strong> pour %d nuit(s).',
                    (int) $calculation['prix_total'],
                    (int) $calculation['nuits']
                );
            }
        }

        $userId = (int) $_SESSION['user_id'];

        $this->view('reservation/index', [
            'success' => $success,
            'error' => $error,
            'tarifs' => $this->reservations->getTarifs(),
            'mes_reservations' => $this->reservations->findByUserId($userId),
            'has_pending_reservation' => $this->reservations->hasPendingReservation($userId),
            'has_confirmed_reservation' => $this->reservations->hasConfirmedReservation($userId),
        ]);
    }
}
