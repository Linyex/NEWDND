<form id="character-sheet-form" class="character-sheet">
    <input type="hidden" name="system" value="vtm">
    <input type="hidden" name="edition" value="5e">
    <h2>Vampire: The Masquerade 5th Edition</h2>
    <div class="form-group">
        <label for="name">Имя персонажа:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="clan">Клан:</label>
        <select id="clan" name="clan" required>
            <option value="">Выберите клан...</option>
            <option value="brujah">Бруха</option>
            <option value="gangrel">Гангрел</option>
            <option value="malkavian">Малкавиан</option>
            <option value="nosferatu">Носферату</option>
            <option value="toreador">Тореадор</option>
            <option value="tremere">Тремер</option>
            <option value="ventrue">Вентру</option>
            <option value="banu_haqim">Бану Хаким</option>
            <option value="lasombra">Ласомбра</option>
            <option value="ministry">Министерство</option>
            <option value="thin_blood">Тонкокровка</option>
        </select>
    </div>
    <div class="form-group">
        <label for="sire">Сир:</label>
        <input type="text" id="sire" name="sire">
    </div>
    <div class="form-group">
        <label for="chronicle">Хроника:</label>
        <input type="text" id="chronicle" name="chronicle">
    </div>
    <div class="form-group">
        <label for="concept">Концепция:</label>
        <input type="text" id="concept" name="concept">
    </div>
    <div class="form-group">
        <label for="ambition">Амбиция:</label>
        <input type="text" id="ambition" name="ambition">
    </div>
    <div class="form-group">
        <label for="desire">Желание:</label>
        <input type="text" id="desire" name="desire">
    </div>
    <div class="form-group">
        <label for="predator_type">Тип хищника:</label>
        <input type="text" id="predator_type" name="predator_type">
    </div>
    <h3>Атрибуты</h3>
    <div class="form-group">
        <label>Сила:</label>
        <input type="number" name="strength" min="1" max="5" value="1">
        <label>Ловкость:</label>
        <input type="number" name="dexterity" min="1" max="5" value="1">
        <label>Выносливость:</label>
        <input type="number" name="stamina" min="1" max="5" value="1">
    </div>
    <div class="form-group">
        <label>Харизма:</label>
        <input type="number" name="charisma" min="1" max="5" value="1">
        <label>Манипуляция:</label>
        <input type="number" name="manipulation" min="1" max="5" value="1">
        <label>Внешность:</label>
        <input type="number" name="composure" min="1" max="5" value="1">
    </div>
    <div class="form-group">
        <label>Восприятие:</label>
        <input type="number" name="resolve" min="1" max="5" value="1">
        <label>Интеллект:</label>
        <input type="number" name="intelligence" min="1" max="5" value="1">
        <label>Смекалка:</label>
        <input type="number" name="wits" min="1" max="5" value="1">
    </div>
    <h3>Навыки</h3>
    <div class="form-group">
        <label>Таланты:</label>
        <input type="text" name="talents" placeholder="Список через запятую">
        <label>Умения:</label>
        <input type="text" name="skills" placeholder="Список через запятую">
        <label>Знания:</label>
        <input type="text" name="knowledges" placeholder="Список через запятую">
    </div>
    <h3>Дисциплины, преимущества, недостатки</h3>
    <div class="form-group">
        <label>Дисциплины:</label>
        <input type="text" name="disciplines" placeholder="Список через запятую">
        <label>Преимущества:</label>
        <input type="text" name="merits" placeholder="Список через запятую">
        <label>Недостатки:</label>
        <input type="text" name="flaws" placeholder="Список через запятую">
    </div>
    <h3>Показатели</h3>
    <div class="form-group">
        <label for="hunger">Голод:</label>
        <input type="number" id="hunger" name="hunger" min="0" max="5" value="0">
        <label for="willpower">Сила воли:</label>
        <input type="number" id="willpower" name="willpower" min="0" max="10" value="5">
        <label for="health">Здоровье:</label>
        <input type="number" id="health" name="health" min="0" max="10" value="7">
        <label for="humanity">Человечность:</label>
        <input type="number" id="humanity" name="humanity" min="0" max="10" value="7">
    </div>
    <h3>Дополнительно</h3>
    <div class="form-group">
        <label for="contacts">Контакты, ресурсы:</label>
        <textarea id="contacts" name="contacts" rows="2"></textarea>
        <label for="appearance_desc">Описание внешности:</label>
        <textarea id="appearance_desc" name="appearance_desc" rows="2"></textarea>
        <label for="background">История персонажа:</label>
        <textarea id="background" name="background" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label><input type="checkbox" id="no-limits-checkbox" name="no_limits"> Заполнять без ограничений</label>
    </div>
    <div class="form-group">
        <div id="attribute-counter"></div>
        <div id="skills-counter"></div>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить персонажа</button>
</form> 