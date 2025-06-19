<form id="character-sheet-form" class="character-sheet">
    <input type="hidden" name="system" value="cthulhu">
    <input type="hidden" name="edition" value="7e">
    
    <div class="form-group">
        <label for="name">Имя персонажа:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="occupation">Профессия:</label>
        <select id="occupation" name="occupation" required>
            <option value="">Выберите профессию...</option>
            <option value="academic">Академик</option>
            <option value="artist">Художник</option>
            <option value="criminal">Преступник</option>
            <option value="dilettante">Дилетант</option>
            <option value="doctor">Доктор</option>
            <option value="engineer">Инженер</option>
            <option value="entertainer">Артист</option>
            <option value="journalist">Журналист</option>
            <option value="lawyer">Адвокат</option>
            <option value="librarian">Библиотекарь</option>
            <option value="police">Полицейский</option>
            <option value="private-investigator">Частный детектив</option>
            <option value="scientist">Учёный</option>
            <option value="soldier">Солдат</option>
            <option value="writer">Писатель</option>
        </select>
    </div>

    <div class="form-group">
        <label for="age">Возраст:</label>
        <input type="number" id="age" name="age" min="15" max="90" required>
    </div>

    <div class="form-group">
        <label for="sanity">Рассудок:</label>
        <input type="number" id="sanity" name="sanity" min="0" max="99" value="99" required>
    </div>

    <div class="form-group">
        <label for="luck">Удача:</label>
        <input type="number" id="luck" name="luck" min="0" max="99" value="50" required>
    </div>

    <div class="form-group">
        <label for="background">Предыстория:</label>
        <textarea id="background" name="background" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="personal-description">Личное описание:</label>
        <textarea id="personal-description" name="personal-description" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="ideology">Идеология/убеждения:</label>
        <textarea id="ideology" name="ideology" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="significant-people">Значимые люди:</label>
        <textarea id="significant-people" name="significant-people" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="meaningful-locations">Значимые места:</label>
        <textarea id="meaningful-locations" name="meaningful-locations" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="treasured-possessions">Ценные вещи:</label>
        <textarea id="treasured-possessions" name="treasured-possessions" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="traits">Черты характера:</label>
        <textarea id="traits" name="traits" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить персонажа</button>
</form> 