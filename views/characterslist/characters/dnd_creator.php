<?php
$title = "Создание персонажа D&D";
include __DIR__ . 'modelviews/header/header.php';

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 mb-4">Создание персонажа D&D</h1>
            
            <form id="characterForm" class="needs-validation" novalidate>
                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Основная информация</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="characterName" class="form-label">Имя персонажа</label>
                                <input type="text" class="form-control bg-dark text-light" id="characterName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="playerName" class="form-label">Имя игрока</label>
                                <input type="text" class="form-control bg-dark text-light" id="playerName" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Раса и класс</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="race" class="form-label">Раса</label>
                                <select class="form-select bg-dark text-light" id="race" required>
                                    <option value="">Выберите расу</option>
                                    <option value="human">Человек</option>
                                    <option value="elf">Эльф</option>
                                    <option value="dwarf">Дварф</option>
                                    <option value="halfling">Полурослик</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="class" class="form-label">Класс</label>
                                <select class="form-select bg-dark text-light" id="class" required>
                                    <option value="">Выберите класс</option>
                                    <option value="fighter">Воин</option>
                                    <option value="wizard">Волшебник</option>
                                    <option value="cleric">Жрец</option>
                                    <option value="rogue">Плут</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Характеристики</h2>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="strength" class="form-label">Сила</label>
                                <input type="number" class="form-control bg-dark text-light" id="strength" min="3" max="20" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="dexterity" class="form-label">Ловкость</label>
                                <input type="number" class="form-control bg-dark text-light" id="dexterity" min="3" max="20" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="constitution" class="form-label">Телосложение</label>
                                <input type="number" class="form-control bg-dark text-light" id="constitution" min="3" max="20" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="intelligence" class="form-label">Интеллект</label>
                                <input type="number" class="form-control bg-dark text-light" id="intelligence" min="3" max="20" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="wisdom" class="form-label">Мудрость</label>
                                <input type="number" class="form-control bg-dark text-light" id="wisdom" min="3" max="20" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="charisma" class="form-label">Харизма</label>
                                <input type="number" class="form-control bg-dark text-light" id="charisma" min="3" max="20" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Предыстория</h2>
                        <div class="mb-3">
                            <label for="background" class="form-label">Выберите предысторию</label>
                            <select class="form-select bg-dark text-light" id="background" required>
                                <option value="">Выберите предысторию</option>
                                <option value="soldier">Солдат</option>
                                <option value="sage">Мудрец</option>
                                <option value="criminal">Преступник</option>
                                <option value="noble">Благородный</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="backstory" class="form-label">Расскажите о своем персонаже</label>
                            <textarea class="form-control bg-dark text-light" id="backstory" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Создать персонажа</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('characterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    alert('Персонаж создан!');
});
</script>

<?php include '../includes/footer.php'; ?> 