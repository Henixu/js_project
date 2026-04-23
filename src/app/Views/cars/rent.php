<?php $car_types = ['economique' => 'Économique', 'compact' => 'Compact', 'berline' => 'Berline', 'suv' => 'SUV', 'luxe' => 'Luxe']; ?>
<?php $carburants = ['essence' => 'Essence', 'diesel' => 'Diesel', 'hybride' => 'Hybride', 'electrique' => 'Électrique']; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location de Voiture - Seabel Hotels</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f5f5f5; color: #333; }

        .topbar {
            background: #0f3460;
            color: white;
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar img { height: 35px; filter: brightness(0) invert(1); }
        .topbar-right { display: flex; align-items: center; gap: 20px; font-size: 13px; }
        .topbar-right a { color: rgba(255,255,255,0.8); text-decoration: none; }
        .topbar-right a:hover { color: white; }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

        h2 { font-family: 'Playfair Display', serif; font-size: 28px; color: #0f3460; margin-bottom: 25px; }

        .card { background: white; border-radius: 12px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 35px; }

        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #666; }
        select, input[type="date"] {
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }
        select:focus, input:focus { border-color: #0f3460; }

        .btn { padding: 12px 22px; background: linear-gradient(135deg, #0f3460 0%, #16213e 100%); color: white; border: none; border-radius: 999px; font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; box-shadow: 0 10px 20px rgba(15, 52, 96, 0.15); }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 14px 24px rgba(15, 52, 96, 0.2); }
        .btn-secondary { background: #f4f6fb; color: #0f3460; box-shadow: inset 0 0 0 1px rgba(15, 52, 96, 0.08); }
        .btn-secondary:hover { background: #e9edf7; }

        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #e6f7e7; color: #0b4d1d; border: 1px solid #b7deb1; }
        .alert-error { background: #fdf0f1; color: #7a1220; border: 1px solid #f4c2c6; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 20px; }
        th { background: #0f3460; color: white; padding: 12px 15px; text-align: left; font-weight: 500; letter-spacing: 0.5px; }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; }
        tr:hover td { background: #f9f9f9; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-en_attente { background: #fff3cd; color: #856404; }
        .badge-confirmee { background: #d1e7dd; color: #0a3622; }
        .badge-annulee { background: #f8d7da; color: #842029; }
        .badge-terminee { background: #e2e3e5; color: #383d41; }

        .car-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            background: white;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .car-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }
        .car-image {
            width: 100%;
            height: 180px;
            margin-bottom: 15px;
            overflow: hidden;
            border-radius: 8px;
        }
        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .car-info h4 {
            margin: 0 0 8px 0;
            color: #0f3460;
            font-size: 18px;
            font-weight: 600;
        }
        .car-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .car-type {
            background: #0f3460;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .car-specs {
            font-size: 12px;
            color: #666;
        }
        .car-price {
            font-weight: 600;
            color: #0f3460;
            font-size: 16px;
        }
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .modal-header {
            padding: 20px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 {
            margin: 0;
            color: #0f3460;
        }
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #0f3460;
        }
        .modal-body {
            padding: 30px;
        }

        /* Calendar styles */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 20px;
        }
        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 10px;
        }
        .calendar-day, .calendar-date {
            padding: 10px;
            text-align: center;
            border-radius: 6px;
            font-size: 14px;
        }
        .calendar-day {
            font-weight: 600;
            color: #0f3460;
            background: #f5f5f5;
        }
        .calendar-date {
            cursor: pointer;
            border: 1px solid #e0e0e0;
            transition: background-color 0.2s;
        }
        .calendar-date:hover {
            background-color: #f0f8ff;
        }
        .calendar-date.available {
            background-color: #e6f7e7;
            color: #0b4d1d;
        }
        .calendar-date.unavailable {
            background-color: #fdf0f1;
            color: #7a1220;
            cursor: not-allowed;
        }
        .calendar-date.booked {
            position: relative;
        }
        .calendar-date.booked::after {
            content: "●";
            position: absolute;
            top: 2px;
            right: 2px;
            color: #d32f2f;
            font-size: 8px;
        }
        .calendar-date.selected {
            background-color: #0f3460;
            color: white;
        }
        .calendar-date.today {
            border: 2px solid #0f3460;
        }

        @media (max-width: 600px) {
            .cars-grid { grid-template-columns: 1fr; }
            .modal-content { margin: 10% auto; width: 95%; }
        }

        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="topbar">
        <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel">
        <div class="topbar-right">
            <span>Bonjour, <?= htmlspecialchars((string) ($_SESSION['prenom'] ?? 'Client')) ?></span>
            <a href="<?= htmlspecialchars(app_url('reservation')) ?>">Reservations</a>
            <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
        </div>
    </div>

    <div class="container">
        <h2>Location de Voiture</h2>

        <?php if (!empty($success)): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
        <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <div class="card">
            <h3 style="margin-bottom: 20px; color: #0f3460;">Choisissez votre voiture</h3>
            <div class="cars-grid">
                <?php foreach ($available_cars as $car): ?>
                <div class="car-card" onclick="selectCar(<?= (int) $car['id'] ?>, '<?= htmlspecialchars(addslashes($car['marque'] . ' ' . $car['modele'])) ?>')">
                    <?php if (!empty($car['image'])): ?>
                        <div class="car-image">
                            <img src="<?= htmlspecialchars('../../uploads/cars/' . $car['image']) ?>" alt="<?= htmlspecialchars($car['marque']) ?> <?= htmlspecialchars($car['modele']) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="car-info">
                        <h4 class="car-title"><?= htmlspecialchars($car['marque']) ?> <?= htmlspecialchars($car['modele']) ?></h4>
                        <div class="car-details">
                            <span class="car-type"><?= htmlspecialchars(ucfirst($car['type'])) ?></span>
                            <span class="car-specs"><?= (int) $car['portes'] ?> portes • <?= htmlspecialchars(ucfirst($car['carburant'])) ?></span>
                        </div>
                        <div class="car-price">
                            <?= number_format((float) $car['prix_par_jour'], 2) ?> € / jour
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="calendar-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modal-title">Calendrier de disponibilité</h3>
                    <span class="close" onclick="closeModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <div id="calendar-container">
                    </div>
                    <form id="rental-form" method="POST" action="<?= htmlspecialchars(app_url('cars/rent/create')) ?>" style="display: none;">
                        <input type="hidden" name="car_id" id="selected-car-id">
                        <div class="form-grid" style="margin-top: 20px;">
                            <div class="form-group">
                                <label>Date de début *</label>
                                <input type="date" name="date_debut" id="date-debut" required>
                            </div>
                            <div class="form-group">
                                <label>Date de fin *</label>
                                <input type="date" name="date_fin" id="date-fin" required>
                            </div>
                        </div>
                        <div style="margin-top: 20px;">
                            <button type="submit" class="btn">Confirmer la location</button>
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($user_rentals)): ?>
        <div class="card">
            <h3 style="margin-bottom: 20px; color: #0f3460;">Mes locations de voitures</h3>
            <table>
                <thead>
                    <tr>
                        <th>Voiture</th>
                        <th>Période</th>
                        <th>Prix total</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_rentals as $rental): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($rental['marque']) ?> <?= htmlspecialchars($rental['modele']) ?><br>
                            <small style="color: #666;"><?= htmlspecialchars(ucfirst($rental['type'])) ?> • <?= htmlspecialchars(ucfirst($rental['carburant'])) ?></small>
                        </td>
                        <td>
                            Du <?= date('d/m/Y', strtotime($rental['date_debut'])) ?><br>
                            Au <?= date('d/m/Y', strtotime($rental['date_fin'])) ?>
                        </td>
                        <td><?= number_format((float) $rental['prix_total'], 2) ?> €</td>
                        <td>
                            <span class="badge badge-<?= htmlspecialchars($rental['statut']) ?>">
                                <?= htmlspecialchars(str_replace('_', ' ', $rental['statut'])) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <script>
        let selectedCarId = null;
        let selectedDates = [];
        let bookedDates = [];

        function selectCar(carId, carName) {
            selectedCarId = carId;
            document.getElementById('modal-title').textContent = `Calendrier de disponibilité - ${carName}`;
            document.getElementById('selected-car-id').value = carId;

            // Charger les dates réservées pour cette voiture
            loadBookedDates(carId);

            // Afficher le modal
            document.getElementById('calendar-modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('calendar-modal').style.display = 'none';
            selectedDates = [];
            document.getElementById('rental-form').style.display = 'none';
            document.getElementById('calendar-container').innerHTML = '<div style="text-align: center; padding: 40px;">Chargement du calendrier...</div>';
        }

        function loadBookedDates(carId) {
            // Faire une requête AJAX pour récupérer les dates réservées
            fetch(`<?= htmlspecialchars(app_url('cars/rent/api/booked-dates')) ?>?car_id=${carId}`)
                .then(response => response.json())
                .then(data => {
                    bookedDates = data.booked_dates || [];
                    generateCalendar();
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des dates:', error);
                    generateCalendar();
                });
        }

        function generateCalendar() {
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();

            let calendarHTML = '<div style="text-align: center; margin-bottom: 20px;">';
            calendarHTML += '<button onclick="changeMonth(-1)" class="btn btn-secondary" style="margin-right: 10px;">&larr; Précédent</button>';
            calendarHTML += '<span id="current-month-year" style="font-weight: 600; margin: 0 20px;">' + getMonthName(currentMonth) + ' ' + currentYear + '</span>';
            calendarHTML += '<button onclick="changeMonth(1)" class="btn btn-secondary">&rarr; Suivant</button>';
            calendarHTML += '</div>';

            calendarHTML += '<div class="calendar-header">';
            ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'].forEach(day => {
                calendarHTML += `<div class="calendar-day">${day}</div>`;
            });
            calendarHTML += '</div>';

            calendarHTML += '<div class="calendar" id="calendar-grid">';
            calendarHTML += generateMonthCalendar(currentMonth, currentYear);
            calendarHTML += '</div>';

            document.getElementById('calendar-container').innerHTML = calendarHTML;
        }

        function generateMonthCalendar(month, year) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            let html = '';
            let currentDate = new Date(startDate);

            for (let week = 0; week < 6; week++) {
                for (let day = 0; day < 7; day++) {
                    const dateStr = currentDate.toISOString().split('T')[0];
                    const isCurrentMonth = currentDate.getMonth() === month;
                    const isPast = currentDate < new Date() && !isSameDay(currentDate, new Date());
                    const isBooked = bookedDates.includes(dateStr);
                    const isToday = isSameDay(currentDate, new Date());

                    let classes = 'calendar-date';
                    if (!isCurrentMonth) classes += ' unavailable';
                    else if (isPast) classes += ' unavailable';
                    else if (isBooked) classes += ' unavailable booked';
                    else classes += ' available';
                    if (isToday) classes += ' today';

                    html += `<div class="${classes}" data-date="${dateStr}" onclick="selectDate('${dateStr}')" title="${isBooked ? 'Réservation confirmée' : isPast ? 'Date passée' : 'Disponible'}">${currentDate.getDate()}</div>`;
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                if (currentDate > lastDay && currentDate.getDay() === 0) break;
            }

            return html;
        }

        function selectDate(dateStr) {
            const dateElement = document.querySelector(`[data-date="${dateStr}"]`);
            if (!dateElement || dateElement.classList.contains('unavailable')) return;

            if (selectedDates.length === 0) {
                // Première sélection
                selectedDates = [dateStr];
                dateElement.classList.add('selected');
            } else if (selectedDates.length === 1) {
                // Deuxième sélection
                const firstDate = new Date(selectedDates[0]);
                const secondDate = new Date(dateStr);

                if (secondDate < firstDate) {
                    // Si la deuxième date est avant la première, inverser
                    selectedDates = [dateStr, selectedDates[0]];
                } else {
                    selectedDates = [selectedDates[0], dateStr];
                }

                // Marquer toutes les dates entre les deux comme sélectionnées
                updateSelectedRange();

                // Afficher le formulaire
                showRentalForm();
            } else {
                // Réinitialiser et sélectionner une nouvelle date
                clearSelection();
                selectedDates = [dateStr];
                dateElement.classList.add('selected');
            }
        }

        function updateSelectedRange() {
            // Effacer toutes les sélections
            document.querySelectorAll('.calendar-date.selected').forEach(el => {
                el.classList.remove('selected');
            });

            if (selectedDates.length === 2) {
                const startDate = new Date(selectedDates[0]);
                const endDate = new Date(selectedDates[1]);

                let currentDate = new Date(startDate);
                while (currentDate <= endDate) {
                    const dateStr = currentDate.toISOString().split('T')[0];
                    const dateElement = document.querySelector(`[data-date="${dateStr}"]`);
                    if (dateElement && !dateElement.classList.contains('unavailable')) {
                        dateElement.classList.add('selected');
                    }
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }
        }

        function clearSelection() {
            selectedDates = [];
            document.querySelectorAll('.calendar-date.selected').forEach(el => {
                el.classList.remove('selected');
            });
        }

        function showRentalForm() {
            if (selectedDates.length === 2) {
                document.getElementById('date-debut').value = selectedDates[0];
                document.getElementById('date-fin').value = selectedDates[1];
                document.getElementById('rental-form').style.display = 'block';
            }
        }

        function changeMonth(direction) {
            // Cette fonction pourrait être étendue pour changer de mois
            // Pour l'instant, on régénère juste le calendrier actuel
            generateCalendar();
        }

        function getMonthName(month) {
            const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            return months[month];
        }

        function isSameDay(date1, date2) {
            return date1.getFullYear() === date2.getFullYear() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getDate() === date2.getDate();
        }

        // Fermer le modal si on clique en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('calendar-modal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>