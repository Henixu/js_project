<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\EventModel;
use App\Models\ReservationModel;

final class EventAdminController extends Controller
{
    private const MAX_IMAGE_SIZE_BYTES = 3145728;
    private const ALLOWED_IMAGE_MIME_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    private EventModel $events;
    private ReservationModel $reservations;

    public function __construct()
    {
        $this->events = new EventModel();
        $this->reservations = new ReservationModel();
    }

    public function index(): void
    {
        $this->requireAdmin();

        $success = (string) ($_SESSION['flash_event_success'] ?? '');
        $error = (string) ($_SESSION['flash_event_error'] ?? '');
        unset($_SESSION['flash_event_success'], $_SESSION['flash_event_error']);

        $old = [
            'titre' => '',
            'hotel' => '',
            'chanteur' => '',
            'date_debut' => '',
            'date_fin' => '',
            'description' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = (string) ($_POST['event_action'] ?? '');

            if ($action === 'delete') {
                $id = (int) ($_POST['id'] ?? 0);
                if ($id > 0) {
                    $this->events->delete($id);
                    $_SESSION['flash_event_success'] = 'Evenement supprime avec succes.';
                }

                $this->redirect('events');
            }

            if ($action === 'create' || $action === 'update') {
                $old = $this->getEventPayloadFromPost();
                $validation = $this->validatePayload($old);

                if ($validation !== '') {
                    $error = $validation;
                } elseif ($action === 'create') {
                    $upload = $this->handleImageUpload();
                    if ($upload['error'] !== '') {
                        $error = $upload['error'];
                    } else {
                        $this->events->create(
                            $old['titre'],
                            $old['hotel'],
                            $old['chanteur'],
                            $old['date_debut'],
                            $old['date_fin'],
                            $old['description'],
                            $upload['path']
                        );
                        $_SESSION['flash_event_success'] = 'Evenement ajoute avec succes.';
                        $this->redirect('events');
                    }
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $existingEvent = $id > 0 ? $this->events->findById($id) : null;

                    if ($id <= 0 || $existingEvent === null) {
                        $error = 'Evenement introuvable pour la modification.';
                    } else {
                        $upload = $this->handleImageUpload((string) ($existingEvent['image_url'] ?? ''));
                        if ($upload['error'] !== '') {
                            $error = $upload['error'];
                        } else {
                            $this->events->update(
                                $id,
                                $old['titre'],
                                $old['hotel'],
                                $old['chanteur'],
                                $old['date_debut'],
                                $old['date_fin'],
                                $old['description'],
                                $upload['path']
                            );
                            $_SESSION['flash_event_success'] = 'Evenement modifie avec succes.';
                            $this->redirect('events');
                        }
                    }
                }
            }
        }

        $editId = (int) ($_GET['edit'] ?? 0);
        $editingEvent = $editId > 0 ? $this->events->findById($editId) : null;
        $hotels = array_keys($this->reservations->getTarifs());

        $this->view('event/index', [
            'success' => $success,
            'error' => $error,
            'events' => $this->events->findAll(),
            'editing_event' => $editingEvent,
            'old' => $old,
            'hotels' => $hotels,
        ]);
    }

    private function handleImageUpload(?string $currentImagePath = null): array
    {
        if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => ''];
        }

        $file = $_FILES['image'];
        $errorCode = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);

        if ($errorCode === UPLOAD_ERR_NO_FILE) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => ''];
        }

        if ($errorCode === UPLOAD_ERR_INI_SIZE || $errorCode === UPLOAD_ERR_FORM_SIZE) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'La taille maximale de l\'image est de 3 MB.'];
        }

        if ($errorCode !== UPLOAD_ERR_OK) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Le televersement de l\'image a echoue.'];
        }

        $size = (int) ($file['size'] ?? 0);
        if ($size <= 0) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Le fichier image est invalide.'];
        }

        if ($size > self::MAX_IMAGE_SIZE_BYTES) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'La taille maximale de l\'image est de 3 MB.'];
        }

        $tmpPath = (string) ($file['tmp_name'] ?? '');
        if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Le fichier image est invalide.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Impossible de verifier le type de fichier.'];
        }

        $mimeType = (string) finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        $extension = self::ALLOWED_IMAGE_MIME_TYPES[$mimeType] ?? null;
        if ($extension === null) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Format d\'image non supporte (JPG, PNG, GIF, WEBP).'];
        }

        $uploadDir = __DIR__ . '/../../uploads/events/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Impossible de creer le dossier de televersement.'];
        }

        $filename = uniqid('event_', true) . '.' . $extension;
        $targetPath = $uploadDir . $filename;

        if (!move_uploaded_file($tmpPath, $targetPath)) {
            return ['path' => $currentImagePath !== '' ? $currentImagePath : null, 'error' => 'Impossible d\'enregistrer l\'image sur le serveur.'];
        }

        if (is_string($currentImagePath) && $currentImagePath !== '' && str_starts_with($currentImagePath, 'uploads/events/')) {
            $oldAbsolutePath = __DIR__ . '/../../' . $currentImagePath;
            if (is_file($oldAbsolutePath)) {
                @unlink($oldAbsolutePath);
            }
        }

        return ['path' => 'uploads/events/' . $filename, 'error' => ''];
    }

    private function getEventPayloadFromPost(): array
    {
        return [
            'titre' => trim((string) ($_POST['titre'] ?? '')),
            'hotel' => trim((string) ($_POST['hotel'] ?? '')),
            'chanteur' => trim((string) ($_POST['chanteur'] ?? '')),
            'date_debut' => (string) ($_POST['date_debut'] ?? ''),
            'date_fin' => (string) ($_POST['date_fin'] ?? ''),
            'description' => trim((string) ($_POST['description'] ?? '')),
        ];
    }

    private function validatePayload(array $payload): string
    {
        $allowedHotels = array_keys($this->reservations->getTarifs());

        if (
            $payload['titre'] === '' ||
            $payload['hotel'] === '' ||
            $payload['chanteur'] === '' ||
            $payload['date_debut'] === '' ||
            $payload['date_fin'] === '' ||
            $payload['description'] === ''
        ) {
            return 'Veuillez remplir tous les champs obligatoires.';
        }

        if ($payload['date_fin'] < $payload['date_debut']) {
            return 'La date de fin doit etre superieure ou egale a la date de debut.';
        }

        if (!in_array($payload['hotel'], $allowedHotels, true)) {
            return 'Veuillez choisir un hotel valide dans la liste.';
        }

        return '';
    }
}
