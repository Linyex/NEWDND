<?php require_once __DIR__ . '/views/modelviews/header/header.php'; ?>

    <video autoplay muted loop class="video-background">
        <source src="assets/mp4/index_main.mp4" type="video/mp4">
    </video>

    <main class="main-content">
        <div class="container">
            <h1 class="main-title">Добро пожаловать в мир настольных игр!</h1>
            
            <section class="worlds-section">
                <h2 class="section-title">Популярные игровые миры</h2>
                <div class="worlds-grid">
                    <article class="world-card">
                        <div class="world-card-image">
                            <img src="assets/images/worldcard/DND.png" alt="Dungeons & Dragons">
                        </div>
                        <div class="world-card-content">
                            <h3>Dungeons & Dragons</h3>
                            <p>Классическая фэнтезийная ролевая игра, где вы можете стать героем эпического приключения.</p>
                            <a href="views/worlds/dnd_lore/dnd.php" class="btn">Подробнее</a>
                        </div>
                    </article>

                    <article class="world-card">
                        <div class="world-card-image">
                            <img src="assets/images/worldcard/VTM.png" alt="Vampire: The Masquerade">
                        </div>
                        <div class="world-card-content">
                            <h3>Vampire: The Masquerade</h3>
                            <p>Мрачный мир вампиров, где политика и интриги переплетаются с сверхъестественным.</p>
                            <a href="views/worlds/vtm_lore/vtm.php" class="btn">Подробнее</a>
                        </div>
                    </article>

                    <article class="world-card">
                        <div class="world-card-image">
                            <img src="assets/images/worldcard/CoC.png" alt="Call of Cthulhu">
                        </div>
                        <div class="world-card-content">
                            <h3>Call of Cthulhu</h3>
                            <p>Хоррор-ролевая игра, основанная на произведениях Говарда Лавкрафта.</p>
                            <a href="views/worlds/cthulhu_lore/cthulhu.php" class="btn">Подробнее</a>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>2025 D&D World. Все права защищены.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
