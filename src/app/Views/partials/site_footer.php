<?php
$nav_hotels = $nav_hotels ?? [];
$footer_hotels = array_slice($nav_hotels, 0, 3);
?>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-columns">
            <div class="footer-column">
                <?php foreach ($footer_hotels as $hotel): ?>
                    <a href="hotel-details.php?slug=<?= htmlspecialchars((string) ($hotel['slug'] ?? '')) ?>"><?= htmlspecialchars((string) ($hotel['nom'] ?? '')) ?></a>
                <?php endforeach; ?>
                <a href="#press">Presse & News</a>
                <a href="#b2b">Portail B2B</a>
            </div>
            <div class="footer-column">
                <a href="hotels.php">Nos hotels</a>
                <a href="#media">Photos & Videos</a>
                <a href="#protocol">Protocole sanitaire</a>
            </div>
            <div class="footer-column">
                <a href="events.php">Evenements</a>
                <a href="#contact">Contact</a>
                <a href="reservation.php">Reserver</a>
            </div>
        </div>

        <div class="footer-bottom">
            <form class="footer-form">
                <h3>Contact</h3>
                <input type="text" name="name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" placeholder="Message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>

            <div class="footer-left">
                <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel Hotels Tunisia" class="footer-logo">
                <div class="social-icons">
                    <a href="https://www.facebook.com/seabelhotels" class="social-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
                    </a>
                    <a href="https://x.com/seabelhotels" class="social-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter">
                    </a>
                    <a href="https://www.instagram.com/seabelhotels/" class="social-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram">
                    </a>
                    <a href="https://www.youtube.com/channel/UCIEZ0wWvn6tGSqJVrfM0qOQ" class="social-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733646.png" alt="YouTube">
                    </a>
                </div>
            </div>

            <div class="copyright">© 2025 SEABEL Hotels Tunisia</div>
        </div>
    </div>
</footer>
