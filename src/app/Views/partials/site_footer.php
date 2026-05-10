<?php
$nav_hotels = $nav_hotels ?? [];
$footer_hotels = array_slice($nav_hotels, 0, 3);
?>
<footer class="footer">
    <div class="footer-container">
        

        <div class="footer-bottom">
            <form class="footer-form">
                <h3>Contact</h3>
                <input type="text" name="name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" placeholder="Message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>

            <div class="footer-left">
                <img src="" alt="Seabel Hotels Tunisia" class="footer-logo">
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

            

        </div>
    </div>
</footer>
