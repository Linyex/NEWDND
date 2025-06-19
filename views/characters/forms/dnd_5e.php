<form id="character-sheet-form" class="character-sheet">
    <input type="hidden" name="system" value="dnd">
    <input type="hidden" name="edition" value="5e">
    
    <div class="form-group">
        <label for="name">Имя персонажа:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="class">Класс:</label>
        <select id="class" name="class" required>
            <option value="">Выберите класс...</option>
            <option value="barbarian">Варвар</option>
            <option value="bard">Бард</option>
            <option value="cleric">Жрец</option>
            <option value="druid">Друид</option>
            <option value="fighter">Воин</option>
            <option value="monk">Монах</option>
            <option value="paladin">Паладин</option>
            <option value="ranger">Следопыт</option>
            <option value="rogue">Плут</option>
            <option value="sorcerer">Чародей</option>
            <option value="warlock">Колдун</option>
            <option value="wizard">Волшебник</option>
        </select>
    </div>

    <div class="form-group">
        <label for="race">Раса:</label>
        <select id="race" name="race" required>
            <option value="">Выберите расу...</option>
            <option value="human">Человек</option>
            <option value="elf">Эльф</option>
            <option value="dwarf">Дварф</option>
            <option value="halfling">Полурослик</option>
            <option value="gnome">Гном</option>
            <option value="half-elf">Полуэльф</option>
            <option value="half-orc">Полуорк</option>
            <option value="tiefling">Тифлинг</option>
        </select>
    </div>

    <div class="form-group">
        <label for="background">Предыстория:</label>
        <select id="background" name="background" required>
            <option value="">Выберите предысторию...</option>
            <option value="acolyte">Послушник</option>
            <option value="criminal">Преступник</option>
            <option value="folk-hero">Народный герой</option>
            <option value="noble">Благородный</option>
            <option value="sage">Мудрец</option>
            <option value="soldier">Солдат</option>
        </select>
    </div>

    <div class="form-group">
        <label for="alignment">Мировоззрение:</label>
        <select id="alignment" name="alignment" required>
            <option value="">Выберите мировоззрение...</option>
            <option value="lawful-good">Законно-добрый</option>
            <option value="neutral-good">Нейтрально-добрый</option>
            <option value="chaotic-good">Хаотично-добрый</option>
            <option value="lawful-neutral">Законно-нейтральный</option>
            <option value="neutral">Нейтральный</option>
            <option value="chaotic-neutral">Хаотично-нейтральный</option>
            <option value="lawful-evil">Законно-злой</option>
            <option value="neutral-evil">Нейтрально-злой</option>
            <option value="chaotic-evil">Хаотично-злой</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить персонажа</button>
</form> 