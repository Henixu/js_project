<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ReservationModel;
use App\Models\TaxiReservationModel;
use App\Models\CarRentalModel;

final class DashboardController extends Controller
{
    private ReservationModel $reservations;
    private TaxiReservationModel $taxiReservations;
    private CarRentalModel $carRentals;

    public function __construct()
    {
        $this->reservations = new ReservationModel();
        $this->taxiReservations = new TaxiReservationModel();
        $this->carRentals = new CarRentalModel();
    }

    public function index(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['statut'], $_POST['id'])) {
            $allowedStatus = ['en_attente', 'confirmee', 'annulee'];
            $status = (string) $_POST['statut'];
            $id = (int) $_POST['id'];

            if (in_array($status, $allowedStatus, true) && $id > 0) {
                $this->reservations->updateStatus($id, $status);
            }

            $this->redirect('dashboard');
        }

        $parMois = $this->reservations->getReservationsByMonth();
        $parHotel = $this->reservations->getReservationsByHotel();

        $this->view('dashboard/index', [
            'stats' => $this->reservations->getDashboardStats(),
            'reservations' => $this->reservations->findAllWithUser(),
            'mois_labels' => json_encode(array_column($parMois, 'mois')),
            'mois_data' => json_encode(array_column($parMois, 'nb')),
            'hotel_labels' => json_encode(array_column($parHotel, 'hotel')),
            'hotel_data' => json_encode(array_column($parHotel, 'nb')),
        ]);
    }

    public function taxis(): void
    {
        $this->requireAdmin();

        $this->view('dashboard/taxis', [
            'taxi_reservations' => $this->taxiReservations->findUpcomingReservations(),
        ]);
    }

    public function rentals(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['statut'], $_POST['id'])) {
            $allowedStatus = ['en_attente', 'confirmee', 'annulee', 'terminee'];
            $status = (string) $_POST['statut'];
            $id = (int) $_POST['id'];

            if (in_array($status, $allowedStatus, true) && $id > 0) {
                $this->carRentals->updateStatus($id, $status);
            }

            $this->redirect('dashboard/rentals');
        }

        $this->view('dashboard/rentals', [
            'car_rentals' => $this->carRentals->findAllWithUser(),
        ]);
    }
}
