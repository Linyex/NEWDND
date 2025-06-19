<!-- VTM 3rd Edition Character Sheet (максимально близко к бумажному листу) -->
<form id="character-sheet-form" class="vtm3e-sheet">
    <input type="hidden" name="system" value="vtm">
    <input type="hidden" name="edition" value="3e">
    <div class="vtm3e-header">
        <div class="vtm3e-title">VAMPIRE</div>
        <div class="vtm3e-header-fields">
            <div><label>Имя: <input type="text" name="name" required></label></div>
            <div><label>Игрок: <input type="text" name="player"></label></div>
            <div><label>Хроника: <input type="text" name="chronicle"></label></div>
            <div><label>Натура: <select name="nature"><option value="Архитектор">Архитектор</option><option value="Авантюрист">Авантюрист</option><option value="Бонвиван">Бонвиван</option><option value="Бюрократ">Бюрократ</option><option value="Дитя">Дитя</option><option value="Завоеватель">Завоеватель</option><option value="Мученик">Мученик</option><option value="Мятежник">Мятежник</option><option value="Одиночка">Одиночка</option><option value="Опекун">Опекун</option><option value="Отшельник">Отшельник</option><option value="Правитель">Правитель</option><option value="Преступник">Преступник</option><option value="Приспособленец">Приспособленец</option><option value="Рыцарь">Рыцарь</option><option value="Служитель">Служитель</option><option value="Созидатель">Созидатель</option><option value="Стратег">Стратег</option><option value="Ученый">Ученый</option><option value="Шут">Шут</option></select></label></div>
            <div><label>Маска: <select name="demeanor"><option value="Архитектор">Архитектор</option><option value="Авантюрист">Авантюрист</option><option value="Бонвиван">Бонвиван</option><option value="Бюрократ">Бюрократ</option><option value="Дитя">Дитя</option><option value="Завоеватель">Завоеватель</option><option value="Мученик">Мученик</option><option value="Мятежник">Мятежник</option><option value="Одиночка">Одиночка</option><option value="Опекун">Опекун</option><option value="Отшельник">Отшельник</option><option value="Правитель">Правитель</option><option value="Преступник">Преступник</option><option value="Приспособленец">Приспособленец</option><option value="Рыцарь">Рыцарь</option><option value="Служитель">Служитель</option><option value="Созидатель">Созидатель</option><option value="Стратег">Стратег</option><option value="Ученый">Ученый</option><option value="Шут">Шут</option></select></label></div>
            <div><label>Клан: <select name="clan"><option value="Бруха">Бруха</option><option value="Вентру">Вентру</option><option value="Гангрел">Гангрел</option><option value="Малкавиан">Малкавиан</option><option value="Носферату">Носферату</option><option value="Тремер">Тремер</option><option value="Тореадор">Тореадор</option><option value="Тзимисце">Тзимисце</option><option value="Ласомбра">Ласомбра</option><option value="Равнос">Равнос</option><option value="Сетит">Сетит</option><option value="Джованни">Джованни</option><option value="Самеди">Самеди</option><option value="Салюбри">Салюбри</option><option value="Каппадокий">Каппадокий</option><option value="Даниэль">Даниэль</option><option value="Баали">Баали</option></select></label></div>
            <div><label>Поколение: <input type="text" name="generation"></label></div>
            <div><label>Убежище: <input type="text" name="haven"></label></div>
            <div><label>Концепция: <select name="concept"><option value="Воин">Воин</option><option value="Аристократ">Аристократ</option><option value="Детектив">Детектив</option><option value="Жрец">Жрец</option><option value="Искатель">Искатель</option><option value="Мистик">Мистик</option><option value="Мошенник">Мошенник</option><option value="Наемник">Наемник</option><option value="Охотник">Охотник</option><option value="Поэт">Поэт</option><option value="Пророк">Пророк</option><option value="Рабочий">Рабочий</option><option value="Священник">Священник</option><option value="Ученый">Ученый</option><option value="Художник">Художник</option><option value="Шут">Шут</option></select></label></div>
        </div>
    </div>
    <div class="vtm3e-main-grid">
        <div class="vtm3e-block vtm3e-attributes">
            <div class="block-title">Атрибуты</div>
            <div class="attr-group" data-group="physical">
                <div class="group-title">Физические</div>
                <div class="attr-row">Сила <span class="dots" data-name="strength" data-max="5" title="Сила — физическая мощь персонажа, влияет на урон и физические действия"></span></div>
                <div class="attr-row">Ловкость <span class="dots" data-name="dexterity" data-max="5" title="Ловкость — гибкость и координация персонажа, влияет на уклонение и скрытность"></span></div>
                <div class="attr-row">Выносливость <span class="dots" data-name="stamina" data-max="5" title="Выносливость — сопротивление усталости и боли"></span></div>
            </div>
            <div class="attr-group" data-group="social">
                <div class="group-title">Социальные</div>
                <div class="attr-row">Обаяние <span class="dots" data-name="charisma" data-max="5" title="Обаяние — способность привлекать внимание и симпатию"></span></div>
                <div class="attr-row">Манипулирование <span class="dots" data-name="manipulation" data-max="5" title="Манипулирование — умение влиять на поведение других людей"></span></div>
                <div class="attr-row">Внешность <span class="dots" data-name="appearance" data-max="5" title="Внешность — внешний вид персонажа"></span></div>
            </div>
            <div class="attr-group" data-group="mental">
                <div class="group-title">Ментальные</div>
                <div class="attr-row">Восприятие <span class="dots" data-name="perception" data-max="5" title="Восприятие — способность воспринимать информацию из окружающей среды"></span></div>
                <div class="attr-row">Интеллект <span class="dots" data-name="intelligence" data-max="5" title="Интеллект — умственные способности персонажа"></span></div>
                <div class="attr-row">Сообразительность <span class="dots" data-name="wits" data-max="5" title="Сообразительность — способность решать проблемы и находить выходы из сложных ситуаций"></span></div>
            </div>
            <div class="attr-limits">Атрибуты: 7/5/3</div>
        </div>
        <div class="vtm3e-block vtm3e-talents">
            <div class="block-title">Таланты</div>
            <div class="talent-row">Актёрство <span class="dots" data-name="acting" data-max="5" title="Актёрство — умение играть роли и имитировать поведение"></span></div>
            <div class="talent-row">Бдительность <span class="dots" data-name="alertness" data-max="5" title="Бдительность — способность внимательно следить за окружающей средой"></span></div>
            <div class="talent-row">Атлетизм <span class="dots" data-name="athletics" data-max="5" title="Атлетизм — способность выполнять физические упражнения"></span></div>
            <div class="talent-row">Драка <span class="dots" data-name="brawl" data-max="5" title="Драка — умение использовать оружие и физические действия"></span></div>
            <div class="talent-row">Уклонение <span class="dots" data-name="dodge" data-max="5" title="Уклонение — способность избегать ударов и атак"></span></div>
            <div class="talent-row">Эмпатия <span class="dots" data-name="empathy" data-max="5" title="Эмпатия — способность понимать и сопереживать другим людям"></span></div>
            <div class="talent-row">Запугивание <span class="dots" data-name="intimidation" data-max="5" title="Запугивание — умение использовать угрозу и давление"></span></div>
            <div class="talent-row">Лидерство <span class="dots" data-name="leadership" data-max="5" title="Лидерство — умение руководить и управлять группой"></span></div>
            <div class="talent-row">Знание улиц <span class="dots" data-name="streetwise" data-max="5" title="Знание улиц — знание местности и людей"></span></div>
            <div class="talent-row">Хитрость <span class="dots" data-name="subterfuge" data-max="5" title="Хитрость — умение обмануть или обхитрить кого-то"></span></div>
            <div class="talent-limits">13</div>
        </div>
        <div class="vtm3e-block vtm3e-skills">
            <div class="block-title">Навыки</div>
            <div class="skill-row">Знание животных <span class="dots" data-name="animalken" data-max="5" title="Знание животных — знание о животных и их поведении"></span></div>
            <div class="skill-row">Вождение <span class="dots" data-name="drive" data-max="5" title="Вождение — умение управлять транспортным средством"></span></div>
            <div class="skill-row">Этикет <span class="dots" data-name="etiquette" data-max="5" title="Этикет — знание правил общения и поведения"></span></div>
            <div class="skill-row">Стрельба <span class="dots" data-name="firearms" data-max="5" title="Стрельба — умение использовать оружие и стрелять"></span></div>
            <div class="skill-row">Фехтование <span class="dots" data-name="melee" data-max="5" title="Фехтование — умение использовать оружие в ближнем бою"></span></div>
            <div class="skill-row">Музыка <span class="dots" data-name="music" data-max="5" title="Музыка — знание музыкальных жанров и исполнителей"></span></div>
            <div class="skill-row">Ремонт <span class="dots" data-name="repair" data-max="5" title="Ремонт — умение ремонтировать и восстанавливать предметы"></span></div>
            <div class="skill-row">Безопасность <span class="dots" data-name="security" data-max="5" title="Безопасность — умение защищаться и обеспечивать безопасность"></span></div>
            <div class="skill-row">Скрытность <span class="dots" data-name="stealth" data-max="5" title="Скрытность — умение оставаться незамеченным"></span></div>
            <div class="skill-row">Выживание <span class="dots" data-name="survival" data-max="5" title="Выживание — умение выживать в природной среде"></span></div>
            <div class="skill-limits">9</div>
        </div>
        <div class="vtm3e-block vtm3e-knowledges">
            <div class="block-title">Познания</div>
            <div class="knowledge-row">Бюрократия <span class="dots" data-name="bureaucracy" data-max="5" title="Бюрократия — знание правил и процедур"></span></div>
            <div class="knowledge-row">Компьютер <span class="dots" data-name="computer" data-max="5" title="Компьютер — знание компьютерных технологий"></span></div>
            <div class="knowledge-row">Финансы <span class="dots" data-name="finance" data-max="5" title="Финансы — знание финансовых операций"></span></div>
            <div class="knowledge-row">Расследование <span class="dots" data-name="investigation" data-max="5" title="Расследование — умение исследовать и анализировать"></span></div>
            <div class="knowledge-row">Правоведение <span class="dots" data-name="law" data-max="5" title="Правоведение — знание юридических правил"></span></div>
            <div class="knowledge-row">Лингвистика <span class="dots" data-name="linguistics" data-max="5" title="Лингвистика — знание языков и культур"></span></div>
            <div class="knowledge-row">Медицина <span class="dots" data-name="medicine" data-max="5" title="Медицина — знание медицинских знаний"></span></div>
            <div class="knowledge-row">Оккультизм <span class="dots" data-name="occult" data-max="5" title="Оккультизм — знание оккультных явлений"></span></div>
            <div class="knowledge-row">Политика <span class="dots" data-name="politics" data-max="5" title="Политика — знание политических процессов"></span></div>
            <div class="knowledge-row">Наука <span class="dots" data-name="science" data-max="5" title="Наука — знание научных знаний"></span></div>
            <div class="knowledge-limits">5</div>
        </div>
        <div class="vtm3e-block vtm3e-disciplines">
            <div class="block-title">Дисциплины</div>
            <div class="discipline-row"><select name="discipline1"><option value="Животное">Животное</option><option value="Превращение">Превращение</option><option value="Присутствие">Присутствие</option><option value="Доминирование">Доминирование</option><option value="Прорицание">Прорицание</option><option value="Сила">Сила</option><option value="Стойкость">Стойкость</option><option value="Скорость">Скорость</option><option value="Колдовство">Колдовство</option><option value="Обфускация">Обфускация</option><option value="Потенция">Потенция</option><option value="Протеан">Протеан</option><option value="Целительство">Целительство</option><option value="Демонология">Демонология</option><option value="Некромантия">Некромантия</option><option value="Тенебрация">Тенебрация</option><option value="Витаэ">Витаэ</option><option value="Серпентис">Серпентис</option><option value="Мимикрия">Мимикрия</option><option value="Мистицизм">Мистицизм</option></select> <span class="dots" data-name="discipline1_val" data-max="5"></span></div>
            <div class="discipline-row"><select name="discipline2"><option value="Животное">Животное</option><option value="Превращение">Превращение</option><option value="Присутствие">Присутствие</option><option value="Доминирование">Доминирование</option><option value="Прорицание">Прорицание</option><option value="Сила">Сила</option><option value="Стойкость">Стойкость</option><option value="Скорость">Скорость</option><option value="Колдовство">Колдовство</option><option value="Обфускация">Обфускация</option><option value="Потенция">Потенция</option><option value="Протеан">Протеан</option><option value="Целительство">Целительство</option><option value="Демонология">Демонология</option><option value="Некромантия">Некромантия</option><option value="Тенебрация">Тенебрация</option><option value="Витаэ">Витаэ</option><option value="Серпентис">Серпентис</option><option value="Мимикрия">Мимикрия</option><option value="Мистицизм">Мистицизм</option></select> <span class="dots" data-name="discipline2_val" data-max="5"></span></div>
            <div class="discipline-row"><select name="discipline3"><option value="Животное">Животное</option><option value="Превращение">Превращение</option><option value="Присутствие">Присутствие</option><option value="Доминирование">Доминирование</option><option value="Прорицание">Прорицание</option><option value="Сила">Сила</option><option value="Стойкость">Стойкость</option><option value="Скорость">Скорость</option><option value="Колдовство">Колдовство</option><option value="Обфускация">Обфускация</option><option value="Потенция">Потенция</option><option value="Протеан">Протеан</option><option value="Целительство">Целительство</option><option value="Демонология">Демонология</option><option value="Некромантия">Некромантия</option><option value="Тенебрация">Тенебрация</option><option value="Витаэ">Витаэ</option><option value="Серпентис">Серпентис</option><option value="Мимикрия">Мимикрия</option><option value="Мистицизм">Мистицизм</option></select> <span class="dots" data-name="discipline3_val" data-max="5"></span></div>
            <div class="discipline-limits">3</div>
        </div>
        <div class="vtm3e-block vtm3e-backgrounds">
            <div class="block-title">Дополнения</div>
            <div class="background-row"><input type="text" name="background1" maxlength="32"> <span class="dots" data-name="background1_val" data-max="5"></span></div>
            <div class="background-row"><input type="text" name="background2" maxlength="32"> <span class="dots" data-name="background2_val" data-max="5"></span></div>
            <div class="background-row"><input type="text" name="background3" maxlength="32"> <span class="dots" data-name="background3_val" data-max="5"></span></div>
            <div class="background-row"><input type="text" name="background4" maxlength="32"> <span class="dots" data-name="background4_val" data-max="5"></span></div>
            <div class="background-row"><input type="text" name="background5" maxlength="32"> <span class="dots" data-name="background5_val" data-max="5"></span></div>
            <div class="background-limits">5</div>
        </div>
        <div class="vtm3e-block vtm3e-virtues">
            <div class="block-title">Добродетели</div>
            <div class="virtue-row">Сознательность <span class="dots" data-name="conscience" data-max="5" title="Сознательность — умение понимать свои действия и их последствия"></span></div>
            <div class="virtue-row">Самоконтроль <span class="dots" data-name="selfcontrol" data-max="5" title="Самоконтроль — умение управлять своими эмоциями и поведением"></span></div>
            <div class="virtue-row">Смелость <span class="dots" data-name="courage" data-max="5" title="Смелость — умение брать на себя ответственность и риск"></span></div>
            <div class="virtue-limits">7</div>
        </div>
        <div class="vtm3e-block vtm3e-other">
            <div class="block-title">Другие черты</div>
            <div class="other-row"><input type="text" name="other_trait1" maxlength="32"> <span class="dots" data-name="other_trait1_val" data-max="5"></span></div>
            <div class="other-row"><input type="text" name="other_trait2" maxlength="32"> <span class="dots" data-name="other_trait2_val" data-max="5"></span></div>
            <div class="other-row"><input type="text" name="other_trait3" maxlength="32"> <span class="dots" data-name="other_trait3_val" data-max="5"></span></div>
            <div class="other-row"><input type="text" name="other_trait4" maxlength="32"> <span class="dots" data-name="other_trait4_val" data-max="5"></span></div>
        </div>
        <div class="vtm3e-block vtm3e-humanity">
            <div class="block-title">Человечность</div>
            <span class="circles" data-name="humanity" data-max="10"></span>
            <div class="block-title">Сила воли</div>
            <span class="circles" data-name="willpower" data-max="10"></span>
            <div class="block-title">Запас крови</div>
            <span class="circles" data-name="bloodpool" data-max="10"></span>
        </div>
        <div class="vtm3e-block vtm3e-health">
            <div class="block-title">Здоровье</div>
            <div class="health-row"><label><input type="checkbox" name="health_bruised"> Синяки</label></div>
            <div class="health-row"><label><input type="checkbox" name="health_hurt"> Задет</label></div>
            <div class="health-row"><label><input type="checkbox" name="health_injured"> Сильно задет</label></div>
            <div class="health-row"><label><input type="checkbox" name="health_wounded"> Ранен</label></div>
            <div class="health-row"><label><input type="checkbox" name="health_mauled"> Тяжело ранен</label></div>
            <div class="health-row"><label><input type="checkbox" name="health_crippled"> Искалечен</label></div>
            <div class="health-row"><label><input type="checkbox" name="health_incapacitated"> Обездвижен</label></div>
        </div>
        <div class="vtm3e-block vtm3e-combat">
            <div class="block-title">Сражение</div>
            <table class="weapons-table">
                <thead><tr><th>Оружие</th><th>Сложн.</th><th>Урон</th></tr></thead>
                <tbody>
                    <tr><td><input type="text" name="weapon1_name"></td><td><input type="text" name="weapon1_diff"></td><td><input type="text" name="weapon1_dmg"></td></tr>
                    <tr><td><input type="text" name="weapon2_name"></td><td><input type="text" name="weapon2_diff"></td><td><input type="text" name="weapon2_dmg"></td></tr>
                    <tr><td><input type="text" name="weapon3_name"></td><td><input type="text" name="weapon3_diff"></td><td><input type="text" name="weapon3_dmg"></td></tr>
                </tbody>
            </table>
        </div>
        <div class="vtm3e-block vtm3e-exp">
            <div class="block-title">Опыт</div>
            <input type="number" name="exp" min="0" max="999" value="0">
        </div>
    </div>
    <div class="vtm3e-footer">
        <div>Атрибуты: 7/5/3 Способности: 13/9/5 Дисциплины: 3 Дополнения: 5 Добродетели: 7 СО: 15 (7/5/2/1)</div>
        <label><input type="checkbox" id="no-limits-checkbox" name="no_limits"> Заполнять без ограничений</label>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить персонажа</button>
</form>
<!-- JS для точек/кружков и лимитов подключается отдельно --> 