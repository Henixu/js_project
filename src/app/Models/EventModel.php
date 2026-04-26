<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class EventModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->ensureTableExists();
    }

    public function create(
        string $titre,
        string $hotel,
        string $chanteur,
        string $dateDebut,
        string $dateFin,
        string $description,
        ?string $imageUrl
    ): void {
        $imageUrl = $this->sanitizeUploadedImagePath($imageUrl);

        $stmt = $this->pdo->prepare(
            'INSERT INTO events (titre, hotel, chanteur, date_debut, date_fin, description, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$titre, $hotel, $chanteur, $dateDebut, $dateFin, $description, $imageUrl]);
    }

    public function findAll(): array
    {
        $events = $this->pdo->query(
            'SELECT * FROM events ORDER BY date_debut DESC, id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $event): array {
            $event['image_url'] = $this->sanitizeUploadedImagePath($event['image_url'] ?? null);
            return $event;
        }, $events);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM events WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);

        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($event === false) {
            return null;
        }

        $event['image_url'] = $this->sanitizeUploadedImagePath($event['image_url'] ?? null);
        return $event;
    }

    public function update(
        int $id,
        string $titre,
        string $hotel,
        string $chanteur,
        string $dateDebut,
        string $dateFin,
        string $description,
        ?string $imageUrl
    ): void {
        $imageUrl = $this->sanitizeUploadedImagePath($imageUrl);

        $stmt = $this->pdo->prepare(
            'UPDATE events
             SET titre = ?, hotel = ?, chanteur = ?, date_debut = ?, date_fin = ?, description = ?, image_url = ?
             WHERE id = ?'
        );
        $stmt->execute([$titre, $hotel, $chanteur, $dateDebut, $dateFin, $description, $imageUrl, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM events WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function findPublicFeed(int $limit = 6): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, titre, hotel, chanteur, date_debut, date_fin, description, image_url
             FROM events
             WHERE date_fin >= CURDATE()
             ORDER BY date_debut ASC, id DESC
             LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $event): array {
            $event['image_url'] = $this->sanitizeUploadedImagePath($event['image_url'] ?? null);
            return $event;
        }, $events);
    }

    private function sanitizeUploadedImagePath(?string $imagePath): ?string
    {
        if (!is_string($imagePath)) {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', trim($imagePath)), '/');
        if ($normalized === '' || !str_starts_with($normalized, 'uploads/events/')) {
            return null;
        }

        return $normalized;
    }

    private function ensureTableExists(): void
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titre VARCHAR(180) NOT NULL,
                hotel VARCHAR(120) NOT NULL,
                chanteur VARCHAR(120) NOT NULL,
                date_debut DATE NOT NULL,
                date_fin DATE NOT NULL,
                description TEXT NOT NULL,
                image_url VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );
    }
}
