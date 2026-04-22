<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use DateTime;
use PDO;

final class ReservationModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getTarifs(): array
    {
        return [
            'Seabel Rym Beach' => ['Standard' => 120, 'Superieure' => 160, 'Suite' => 250],
            'Seabel Aladin' => ['Standard' => 90, 'Superieure' => 130, 'Suite' => 200],
            'Seabel Alhambra' => ['Standard' => 150, 'Superieure' => 200, 'Suite' => 350],
        ];
    }

    public function calculateTotal(string $hotel, string $chambre, string $arrivee, string $depart): array
    {
        $nuits = (new DateTime($arrivee))->diff(new DateTime($depart))->days;
        $tarifNuit = $this->getTarifs()[$hotel][$chambre] ?? 100;

        return [
            'nuits' => $nuits,
            'prix_total' => $tarifNuit * $nuits,
        ];
    }

    public function create(
        int $userId,
        string $hotel,
        string $chambre,
        string $arrivee,
        string $depart,
        int $nbPersonnes,
        float $prixTotal
    ): void {
        $stmt = $this->pdo->prepare(
            'INSERT INTO reservations (user_id, hotel, chambre, date_arrivee, date_depart, nb_personnes, prix_total) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $hotel, $chambre, $arrivee, $depart, $nbPersonnes, $prixTotal]);
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM reservations WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDashboardStats(): array
    {
        return $this->pdo->query(
            "SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN statut = 'confirmee' THEN 1 ELSE 0 END) AS confirmees,
                SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) AS en_attente,
                SUM(CASE WHEN statut = 'annulee' THEN 1 ELSE 0 END) AS annulees,
                SUM(CASE WHEN statut = 'confirmee' THEN prix_total ELSE 0 END) AS revenus
             FROM reservations"
        )->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getReservationsByHotel(): array
    {
        return $this->pdo->query(
            'SELECT hotel, COUNT(*) AS nb, SUM(prix_total) AS total FROM reservations GROUP BY hotel'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationsByMonth(): array
    {
        return $this->pdo->query(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') AS mois, COUNT(*) AS nb
             FROM reservations
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
             GROUP BY mois
             ORDER BY mois"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus(int $id, string $status): void
    {
        $stmt = $this->pdo->prepare('UPDATE reservations SET statut = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
    }

    public function findAllWithUser(): array
    {
        return $this->pdo->query(
            'SELECT r.*, u.nom, u.prenom, u.email
             FROM reservations r
             JOIN users u ON r.user_id = u.id
             ORDER BY r.created_at DESC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}
