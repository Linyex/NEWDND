const editions = {
    dnd: [
        { value: '5e', label: '5th Edition' }
    ],
    vtm: [
        { value: '3e', label: '3rd Edition' }
    ],
    cthulhu: [
        { value: '7e', label: '7th Edition' }
    ]
};

const systemSelect = document.getElementById('system-select');
const editionSelect = document.getElementById('edition-select');
const formContainer = document.getElementById('character-form-container');

// Объект с описаниями всех параметров
const descriptions = {
    // Атрибуты
    attributes: {
        physical: {
            strength: "Физическая сила персонажа. Влияет на урон в ближнем бою, поднятие тяжестей и физические действия.",
            dexterity: "Ловкость и координация. Влияет на инициативу, уклонение, стрельбу и акробатику.",
            stamina: "Выносливость и стойкость. Влияет на здоровье, сопротивление урону и физическим эффектам."
        },
        social: {
            charisma: "Природное обаяние и харизма. Влияет на убеждение, лидерство и социальные взаимодействия.",
            manipulation: "Способность манипулировать другими. Влияет на обман, запугивание и социальные манипуляции.",
            appearance: "Внешняя привлекательность. Влияет на первое впечатление и социальные взаимодействия."
        },
        mental: {
            perception: "Внимательность и наблюдательность. Влияет на поиск, обнаружение скрытого и осведомленность.",
            intelligence: "Умственные способности. Влияет на обучение, анализ и решение проблем.",
            wits: "Сообразительность и реакция. Влияет на инициативу, быстроту мышления и импровизацию."
        }
    },
    // Навыки
    skills: {
        talents: {
            alertness: "Внимательность и бдительность. Помогает замечать опасность и скрытые угрозы.",
            athletics: "Физическая подготовка и спортивные навыки. Включает бег, прыжки, плавание.",
            awareness: "Осведомленность об окружении. Помогает чувствовать настроение и намерения других.",
            brawl: "Навыки рукопашного боя без оружия.",
            empathy: "Понимание эмоций других. Помогает в социальных взаимодействиях.",
            expression: "Способность выражать мысли и эмоции. Включает речь, пение, актерское мастерство.",
            intimidation: "Способность запугивать других.",
            leadership: "Навыки руководства и вдохновения других.",
            streetwise: "Знание уличной жизни и криминального мира.",
            subterfuge: "Искусство обмана и манипуляции."
        },
        skills: {
            animal_ken: "Понимание и взаимодействие с животными.",
            crafts: "Ремесленные навыки. Включает создание и ремонт предметов.",
            drive: "Управление транспортными средствами.",
            etiquette: "Знание правил поведения в обществе.",
            firearms: "Владение огнестрельным оружием.",
            larceny: "Навыки воровства и взлома.",
            melee: "Владение холодным оружием.",
            performance: "Исполнительское мастерство.",
            stealth: "Скрытность и незаметность.",
            survival: "Выживание в дикой природе."
        },
        knowledges: {
            academics: "Академические знания. Включает историю, литературу, философию.",
            computer: "Навыки работы с компьютерами и технологиями.",
            finance: "Знание финансов и экономики.",
            investigation: "Навыки расследования и поиска информации.",
            law: "Знание законов и правовой системы.",
            linguistics: "Знание языков и лингвистики.",
            medicine: "Медицинские знания и навыки.",
            occult: "Знание оккультных наук и сверхъестественного.",
            politics: "Понимание политических систем и интриг.",
            science: "Научные знания. Включает физику, химию, биологию."
        }
    },
    // Дисциплины
    disciplines: {
        animalism: "Дисциплина контроля над животными и связи с ними.",
        auspex: "Дисциплина сверхъестественного восприятия и экстрасенсорных способностей.",
        celerity: "Дисциплина сверхъестественной скорости и рефлексов.",
        chimerstry: "Дисциплина создания иллюзий.",
        dementation: "Дисциплина манипуляции разумом и безумием.",
        dominate: "Дисциплина контроля над разумом других.",
        fortitude: "Дисциплина сверхъестественной стойкости.",
        obfuscate: "Дисциплина скрытности и невидимости.",
        potence: "Дисциплина сверхъестественной силы.",
        presence: "Дисциплина влияния на эмоции других.",
        protean: "Дисциплина изменения формы и тела.",
        quietus: "Дисциплина яда и смерти.",
        serpentis: "Дисциплина змеиных способностей.",
        thaumaturgy: "Дисциплина крови и магии.",
        vicissitude: "Дисциплина изменения плоти."
    },
    // Добродетели
    virtues: {
        conscience: "Совесть - способность различать добро и зло, чувство моральной ответственности.",
        self_control: "Самоконтроль - способность контролировать свои эмоции и инстинкты.",
        courage: "Храбрость - способность противостоять страху и опасности."
    },
    // Другие параметры
    other: {
        humanity: "Человечность - мера моральной целостности и связи с человечностью. Влияет на контроль над Зверем.",
        willpower: "Сила воли - способность противостоять влиянию и контролировать свои действия.",
        blood_pool: "Запас крови - количество крови, доступное для использования дисциплин и исцеления.",
        health: "Здоровье - количество уровней урона, которое может получить персонаж."
    }
};

// Функция для добавления всплывающих подсказок
function addTooltips() {
    const form = document.getElementById('character-sheet-form');
    if (!form) return;

    // Добавляем подсказки для атрибутов
    Object.entries(descriptions.attributes).forEach(([group, attrs]) => {
        Object.entries(attrs).forEach(([attr, desc]) => {
            // Добавляем подсказку к контейнеру с точками
            const dotsContainer = form.querySelector(`.attr-group[data-group="${group}"] .dots[data-name="${attr}"]`);
            if (dotsContainer) {
                dotsContainer.title = desc;
            }
            // Добавляем подсказку к названию атрибута
            const attrRow = form.querySelector(`.attr-group[data-group="${group}"] .attr-row`);
            if (attrRow) {
                const attrName = attrRow.textContent.trim().split(' ')[0];
                if (attrName.toLowerCase() === attr) {
                    attrRow.title = desc;
                }
            }
        });
    });

    // Добавляем подсказки для навыков
    Object.entries(descriptions.skills).forEach(([category, skills]) => {
        Object.entries(skills).forEach(([skill, desc]) => {
            // Добавляем подсказку к контейнеру с точками
            const dotsContainer = form.querySelector(`.skill-group[data-category="${category}"] .dots[data-name="${skill}"]`);
            if (dotsContainer) {
                dotsContainer.title = desc;
            }
            // Добавляем подсказку к названию навыка
            const skillRow = form.querySelector(`.skill-group[data-category="${category}"] .skill-row`);
            if (skillRow) {
                const skillName = skillRow.textContent.trim().split(' ')[0];
                if (skillName.toLowerCase() === skill) {
                    skillRow.title = desc;
                }
            }
        });
    });

    // Добавляем подсказки для дисциплин
    Object.entries(descriptions.disciplines).forEach(([discipline, desc]) => {
        // Добавляем подсказку к контейнеру с точками
        const dotsContainer = form.querySelector(`.discipline-group .dots[data-name="${discipline}"]`);
        if (dotsContainer) {
            dotsContainer.title = desc;
        }
        // Добавляем подсказку к названию дисциплины
        const disciplineRow = form.querySelector(`.discipline-group .discipline-row`);
        if (disciplineRow) {
            const disciplineName = disciplineRow.textContent.trim().split(' ')[0];
            if (disciplineName.toLowerCase() === discipline) {
                disciplineRow.title = desc;
            }
        }
    });

    // Добавляем подсказки для добродетелей
    Object.entries(descriptions.virtues).forEach(([virtue, desc]) => {
        // Добавляем подсказку к контейнеру с точками
        const dotsContainer = form.querySelector(`.virtue-group .dots[data-name="${virtue}"]`);
        if (dotsContainer) {
            dotsContainer.title = desc;
        }
        // Добавляем подсказку к названию добродетели
        const virtueRow = form.querySelector(`.virtue-group .virtue-row`);
        if (virtueRow) {
            const virtueName = virtueRow.textContent.trim().split(' ')[0];
            if (virtueName.toLowerCase() === virtue) {
                virtueRow.title = desc;
            }
        }
    });

    // Добавляем подсказки для других параметров
    Object.entries(descriptions.other).forEach(([param, desc]) => {
        // Добавляем подсказку к контейнеру с точками
        const dotsContainer = form.querySelector(`.other-stats .dots[data-name="${param}"]`);
        if (dotsContainer) {
            dotsContainer.title = desc;
        }
        // Добавляем подсказку к названию параметра
        const paramRow = form.querySelector(`.other-stats .other-row`);
        if (paramRow) {
            const paramName = paramRow.textContent.trim().split(' ')[0];
            if (paramName.toLowerCase() === param) {
                paramRow.title = desc;
            }
        }
    });
}

// Обработчик изменения системы
systemSelect.addEventListener('change', () => {
    editionSelect.innerHTML = '<option value="">Выберите редакцию</option>';
    editionSelect.disabled = !systemSelect.value;
    
    if (systemSelect.value) {
        editions[systemSelect.value].forEach(ed => {
            const opt = document.createElement('option');
            opt.value = ed.value;
            opt.textContent = ed.label;
            editionSelect.appendChild(opt);
        });
    }
    formContainer.innerHTML = '';
});

// Обработчик изменения редакции
editionSelect.addEventListener('change', () => {
    if (systemSelect.value && editionSelect.value) {
        fetch(`/engine/characters/get_form.php?system=${systemSelect.value}&edition=${editionSelect.value}`)
            .then(res => res.text())
            .then(html => {
                formContainer.innerHTML = html;
                // Гарантированная инициализация интерактивных элементов:
                renderVtm3eDotsAndCircles();
                renderVtm3ePrioritySelectors();
                strictVtm3eValidation();
                addTooltips(); // Добавляем вызов функции для подсказок
                const charForm = document.getElementById('character-sheet-form');
                if (charForm) {
                    charForm.addEventListener('submit', handleFormSubmit);
                }
            })
            .catch(error => {
                console.error('Ошибка загрузки формы:', error);
                formContainer.innerHTML = '<div class="error">Ошибка загрузки формы. Пожалуйста, попробуйте позже.</div>';
            });
    } else {
        formContainer.innerHTML = '';
    }
});

// Обработчик отправки формы
function handleFormSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    fetch('/engine/characters/save.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Персонаж успешно сохранён!');
            window.location.href = '/views/characters/list.php';
        } else {
            alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
        }
    })
    .catch(error => {
        console.error('Ошибка сохранения:', error);
        alert('Произошла ошибка при сохранении персонажа. Пожалуйста, попробуйте позже.');
    });
}

// === VTM: Валидация атрибутов и навыков ===
function vtmValidationSetup() {
    const form = document.getElementById('character-sheet-form');
    if (!form) return;
    const noLimits = form.querySelector('#no-limits-checkbox');
    const attrInputs = form.querySelectorAll('[name="strength"], [name="dexterity"], [name="stamina"], [name="charisma"], [name="manipulation"], [name="appearance"], [name="perception"], [name="intelligence"], [name="wits"], [name="composure"], [name="resolve"]');
    const skillsInput = form.querySelector('[name="skills"]');
    const talentsInput = form.querySelector('[name="talents"]');
    const knowledgesInput = form.querySelector('[name="knowledges"]');
    const attrCounter = form.querySelector('#attribute-counter');
    const skillsCounter = form.querySelector('#skills-counter');
    // Лимиты для 3e и 5e
    const is5e = form.querySelector('input[name="edition"]').value === '5e';
    const attrLimit = is5e ? 7+5+3 : 7+5+3; // Можно сделать раздельно, если потребуется
    const skillsLimit = is5e ? 13+9+5 : 13+9+5;
    function countAttrs() {
        let sum = 0;
        attrInputs.forEach(i => sum += parseInt(i.value) || 0);
        return sum;
    }
    function countSkills() {
        let sum = 0;
        // Для простоты считаем количество навыков через запятую
        let s = (skillsInput?.value || '').split(',').filter(Boolean).length;
        let t = (talentsInput?.value || '').split(',').filter(Boolean).length;
        let k = (knowledgesInput?.value || '').split(',').filter(Boolean).length;
        return s + t + k;
    }
    function updateCounters() {
        attrCounter.textContent = 'Сумма атрибутов: ' + countAttrs() + ' (лимит: ' + attrLimit + ')';
        skillsCounter.textContent = 'Сумма навыков: ' + countSkills() + ' (лимит: ' + skillsLimit + ')';
    }
    form.addEventListener('input', updateCounters);
    updateCounters();
    form.addEventListener('submit', function(e) {
        if (noLimits && noLimits.checked) return;
        if (countAttrs() > attrLimit) {
            e.preventDefault();
            alert('Превышен лимит атрибутов!');
        }
        if (countSkills() > skillsLimit) {
            e.preventDefault();
            alert('Превышен лимит навыков!');
        }
    });
    if (noLimits) {
        noLimits.addEventListener('change', function() {
            if (noLimits.checked) {
                attrCounter.style.opacity = '0.5';
                skillsCounter.style.opacity = '0.5';
            } else {
                attrCounter.style.opacity = '1';
                skillsCounter.style.opacity = '1';
            }
        });
    }
}

function vtmAttributeValidation() {
    const form = document.getElementById('character-sheet-form');
    if (!form) return;
    const noLimits = form.querySelector('#no-limits-checkbox');
    const attrGroups = {
        physical: ['strength','dexterity','stamina'],
        social: ['charisma','manipulation','appearance'],
        mental: ['perception','intelligence','wits']
    };
    const groupLimits = [7,5,3];
    const selects = [
        form.querySelector('#attr-primary'),
        form.querySelector('#attr-secondary'),
        form.querySelector('#attr-tertiary')
    ];
    const groupOrder = () => selects.map(s => s.value);
    const errorMsg = form.querySelector('#attr-error-msg');
    function validateAttrs() {
        if (noLimits && noLimits.checked) {
            errorMsg.style.display = 'none';
            form.querySelectorAll('.attr-group').forEach(g => g.style.border = '');
            return true;
        }
        let valid = true;
        let used = {};
        // Проверка на уникальность выбора
        const order = groupOrder();
        order.forEach(val => { used[val] = (used[val]||0)+1; });
        if (Object.values(used).some(v => v > 1)) {
            errorMsg.textContent = 'Группы приоритетов должны быть разными!';
            errorMsg.style.display = 'block';
            form.querySelectorAll('.attr-group').forEach(g => g.style.border = '');
            return false;
        }
        // Проверка лимитов
        form.querySelectorAll('.attr-group').forEach(g => g.style.border = '');
        let hasError = false;
        order.forEach((group, idx) => {
            const fields = attrGroups[group] || [];
            if (!fields.length) return;
            let sum = fields.reduce((acc, f) => acc + (parseInt(form.querySelector(`[name="${f}"]`).value)||0), 0);
            const groupDiv = form.querySelector(`.attr-group[data-group="${group}"]`);
            if (sum > groupLimits[idx]) {
                groupDiv.style.border = '2px solid #c00';
                hasError = true;
            } else {
                groupDiv.style.border = '';
            }
        });
        if (hasError) {
            errorMsg.textContent = 'Превышен лимит очков в одной из групп! (7/5/3)';
            errorMsg.style.display = 'block';
            valid = false;
        } else {
            errorMsg.style.display = 'none';
        }
        return valid;
    }
    selects.forEach(s => s.addEventListener('change', validateAttrs));
    form.querySelectorAll('.attr-group input').forEach(i => i.addEventListener('input', validateAttrs));
    if (noLimits) noLimits.addEventListener('change', validateAttrs);
    form.addEventListener('submit', function(e) {
        if (!validateAttrs()) e.preventDefault();
    });
    validateAttrs();
}

// Вызов для VTM форм
if (window.location.pathname.includes('/characters/create.php')) {
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            vtmValidationSetup();
            vtmAttributeValidation();
        }, 500);
    });
}

// === VTM 3e: dots/circles, приоритеты, автопроверка ===
// Все функции определены на верхнем уровне!

function setDotsValue(container, name, value, silent) {
  const form = container.closest('form');
  const dots = Array.from(container.children).filter(e => e.classList.contains('dot'));
  dots.forEach((dot, idx) => {
    if (idx < value) dot.classList.add('filled');
    else dot.classList.remove('filled');
  });
  const hidden = form.querySelector(`input[name="${name}"]`);
  if (hidden) hidden.value = value;
  if (!silent && typeof validateVtm3eLimitsWithPriority === 'function') validateVtm3eLimitsWithPriority(form);
}

function setCirclesValue(container, name, value, silent) {
  const form = container.closest('form');
  const circles = Array.from(container.children).filter(e => e.classList.contains('circle'));
  circles.forEach((circle, idx) => {
    if (idx < value) circle.classList.add('filled');
    else circle.classList.remove('filled');
  });
  const hidden = form.querySelector(`input[name="${name}"]`);
  if (hidden) hidden.value = value;
  if (!silent && typeof validateVtm3eLimitsWithPriority === 'function') validateVtm3eLimitsWithPriority(form);
}

// === VTM 3e: Генерация и анимация кружков/точек ===
function renderVtm3eDotsAndCircles() {
  const form = document.getElementById('character-sheet-form');
  if (!form || !form.classList.contains('vtm3e-sheet')) return;

  // Dots (атрибуты, навыки, добродетели и т.д.)
  form.querySelectorAll('.dots').forEach(container => {
    const name = container.dataset.name;
    const max = parseInt(container.dataset.max) || 5;
    container.innerHTML = '';
    for (let i = 1; i <= max; ++i) {
      const dot = document.createElement('span');
      dot.className = 'dot';
      dot.title = descriptions[name] || i;
      dot.tabIndex = 0;
      dot.setAttribute('role', 'button');
      dot.setAttribute('aria-label', `${name} ${i}`);
      dot.addEventListener('click', () => setDotsValue(container, name, i));
      dot.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') setDotsValue(container, name, i); });
      container.appendChild(dot);
    }
    // Скрытый input для отправки значения
    let hidden = form.querySelector(`input[name="${name}"]`);
    if (!hidden) {
      hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = name;
      container.appendChild(hidden);
    }
    setDotsValue(container, name, 0, true); // init
  });
  // Circles (человечность, сила воли, кровь)
  form.querySelectorAll('.circles').forEach(container => {
    const name = container.dataset.name;
    const max = parseInt(container.dataset.max) || 10;
    container.innerHTML = '';
    for (let i = 1; i <= max; ++i) {
      const circle = document.createElement('span');
      circle.className = 'circle';
      circle.title = descriptions[name] || i;
      circle.tabIndex = 0;
      circle.setAttribute('role', 'button');
      circle.setAttribute('aria-label', `${name} ${i}`);
      circle.addEventListener('click', () => setCirclesValue(container, name, i));
      circle.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') setCirclesValue(container, name, i); });
      container.appendChild(circle);
    }
    let hidden = form.querySelector(`input[name="${name}"]`);
    if (!hidden) {
      hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = name;
      container.appendChild(hidden);
    }
    setCirclesValue(container, name, 0, true);
  });
}

// === VTM 3e: Автозаполнение и строгая автопроверка ===
function strictVtm3eValidation() {
  const form = document.getElementById('character-sheet-form');
  if (!form || !form.classList.contains('vtm3e-sheet')) return;
  const noLimits = form.querySelector('#no-limits-checkbox');

  // --- Приоритеты ---
  const attrPriorityDiv = form.querySelector('.attr-priority-selects');
  if (attrPriorityDiv) {
    const selects = attrPriorityDiv.querySelectorAll('select');
    selects.forEach(sel => {
      sel.addEventListener('change', () => {
        const vals = Array.from(selects).map(s=>s.value);
        if (new Set(vals).size < 3) {
          sel.classList.add('error');
          sel.title = 'Группы приоритетов должны быть разными!';
        } else {
          selects.forEach(s=>s.classList.remove('error'));
          sel.title = '';
        }
      });
    });
  }

  // --- Блокировка точек при превышении лимита ---
  function blockDotsIfLimit() {
    // Атрибуты
    const attrGroups = {
      physical: ['strength','dexterity','stamina'],
      social: ['charisma','manipulation','appearance'],
      mental: ['perception','intelligence','wits']
    };
    const attrLimits = [7,5,3];
    let attrPriority = ['physical','social','mental'];
    if (attrPriorityDiv) {
      const selects = attrPriorityDiv.querySelectorAll('select');
      attrPriority = Array.from(selects).map(s=>s.value);
    }
    attrPriority.forEach((group, idx) => {
      const fields = attrGroups[group] || [];
      if (!fields.length) return;
      let sum = fields.reduce((acc, f) => acc + (parseInt(form.querySelector(`input[name="${f}"]`).value)||0), 0);
      fields.forEach(f => {
        const container = form.querySelector(`.dots[data-name="${f}"]`);
        if (!container) return;
        const dots = Array.from(container.children).filter(e => e.classList.contains('dot'));
        dots.forEach((dot, i) => {
          if (i >= (parseInt(form.querySelector(`input[name="${f}"]`).value)||0)) {
            dot.classList.remove('blocked');
            if (sum >= attrLimits[idx]) {
              dot.classList.add('blocked');
              dot.title = 'Лимит очков в группе исчерпан';
            } else {
              dot.title = '';
            }
          }
        });
      });
    });
    // Аналогично для талантов/навыков/познаний
    const skillGroups = {
      talent: ['acting','alertness','athletics','brawl','dodge','empathy','intimidation','leadership','streetwise','subterfuge'],
      skill: ['animalken','drive','etiquette','firearms','melee','music','repair','security','stealth','survival'],
      knowledge: ['bureaucracy','computer','finance','investigation','law','linguistics','medicine','occult','politics','science']
    };
    const skillLimits = [13,9,5];
    let skillPriority = ['talent','skill','knowledge'];
    const skillPriorityDiv = form.querySelector('.skill-priority-selects');
    if (skillPriorityDiv) {
      const selects = skillPriorityDiv.querySelectorAll('select');
      skillPriority = Array.from(selects).map(s=>s.value);
    }
    skillPriority.forEach((group, idx) => {
      const fields = skillGroups[group] || [];
      if (!fields.length) return;
      let sum = fields.reduce((acc, f) => acc + (parseInt(form.querySelector(`input[name="${f}"]`).value)||0), 0);
      fields.forEach(f => {
        const container = form.querySelector(`.dots[data-name="${f}"]`);
        if (!container) return;
        const dots = Array.from(container.children).filter(e => e.classList.contains('dot'));
        dots.forEach((dot, i) => {
          if (i >= (parseInt(form.querySelector(`input[name="${f}"]`).value)||0)) {
            dot.classList.remove('blocked');
            if (sum >= skillLimits[idx]) {
              dot.classList.add('blocked');
              dot.title = 'Лимит очков в группе исчерпан';
            } else {
              dot.title = '';
            }
          }
        });
      });
    });
    // Дисциплины, дополнения, добродетели
    function blockGroup(fields, limit) {
      let sum = fields.reduce((acc, f) => acc + (parseInt(form.querySelector(`input[name="${f}"]`).value)||0), 0);
      fields.forEach(f => {
        const container = form.querySelector(`.dots[data-name="${f}"]`);
        if (!container) return;
        const dots = Array.from(container.children).filter(e => e.classList.contains('dot'));
        dots.forEach((dot, i) => {
          if (i >= (parseInt(form.querySelector(`input[name="${f}"]`).value)||0)) {
            dot.classList.remove('blocked');
            if (sum >= limit) {
              dot.classList.add('blocked');
              dot.title = 'Лимит очков исчерпан';
            } else {
              dot.title = '';
            }
          }
        });
      });
    }
    blockGroup(['discipline1_val','discipline2_val','discipline3_val'], 3);
    blockGroup(['background1_val','background2_val','background3_val','background4_val','background5_val'], 5);
    blockGroup(['conscience','selfcontrol','courage'], 7);
  }

  // --- Автоматический пересчёт Человечности и Силы Воли ---
  function autoVirtues() {
    const conscience = parseInt(form.querySelector('input[name="conscience"]').value)||0;
    const selfcontrol = parseInt(form.querySelector('input[name="selfcontrol"]').value)||0;
    const courage = parseInt(form.querySelector('input[name="courage"]').value)||0;
    // Человечность = Совесть + Самоконтроль
    const humanity = form.querySelector('input[name="humanity"]');
    if (humanity) humanity.value = conscience + selfcontrol;
    // Сила воли = Смелость
    const willpower = form.querySelector('input[name="willpower"]');
    if (willpower) willpower.value = courage;
    // Обновить кружки
    const humanityCircles = form.querySelector('.circles[data-name="humanity"]');
    if (humanityCircles) setCirclesValue(humanityCircles, 'humanity', conscience+selfcontrol, true);
    const willpowerCircles = form.querySelector('.circles[data-name="willpower"]');
    if (willpowerCircles) setCirclesValue(willpowerCircles, 'willpower', courage, true);
  }

  // --- Блокировка отправки формы ---
  form.addEventListener('submit', function(e) {
    if (noLimits && noLimits.checked) return;
    // Проверка приоритетов
    if (attrPriorityDiv) {
      const selects = attrPriorityDiv.querySelectorAll('select');
      const vals = Array.from(selects).map(s=>s.value);
      if (new Set(vals).size < 3) {
        e.preventDefault();
        alert('Группы приоритетов должны быть разными!');
        return;
      }
    }
    // Проверка лимитов (цветные подсказки уже есть)
    let errors = form.querySelectorAll('.dot.blocked').length;
    if (errors) {
      e.preventDefault();
      alert('Превышен лимит очков в одной из групп!');
      return;
    }
  });

  // --- События ---
  form.querySelectorAll('.dots').forEach(container => {
    container.addEventListener('click', () => {
      blockDotsIfLimit();
      autoVirtues();
    });
  });
  form.querySelectorAll('.dots').forEach(container => {
    container.addEventListener('keydown', () => {
      blockDotsIfLimit();
      autoVirtues();
    });
  });
  form.querySelectorAll('input').forEach(inp => {
    inp.addEventListener('input', () => {
      blockDotsIfLimit();
      autoVirtues();
    });
  });
  if (attrPriorityDiv) {
    attrPriorityDiv.querySelectorAll('select').forEach(sel => {
      sel.addEventListener('change', blockDotsIfLimit);
    });
  }
  blockDotsIfLimit();
  autoVirtues();
}

// Вызов автопроверки для VTM 3e
if (window.location.pathname.includes('vtm_3e.php')) {
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      renderVtm3eDotsAndCircles();
      renderVtm3ePrioritySelectors();
      strictVtm3eValidation();
    }, 500);
  });
}

// === VTM 3e: Динамический выбор приоритетов для атрибутов и способностей ===
function renderVtm3ePrioritySelectors() {
  const form = document.getElementById('character-sheet-form');
  if (!form || !form.classList.contains('vtm3e-sheet')) return;

  // --- Атрибуты ---
  const attrGroups = ['physical','social','mental'];
  const attrLabels = { physical: 'Физические', social: 'Социальные', mental: 'Ментальные' };
  const attrLimits = [7,5,3];
  //let attrPriority = ['physical','social','mental']; // убираем автозаполнение

  // Создаём селекты для приоритетов
  let attrPriorityDiv = form.querySelector('.attr-priority-selects');
  if (!attrPriorityDiv) {
    attrPriorityDiv = document.createElement('div');
    attrPriorityDiv.className = 'attr-priority-selects';
    attrPriorityDiv.style.display = 'flex';
    attrPriorityDiv.style.gap = '1.5rem';
    attrPriorityDiv.style.margin = '0.5rem 0 0.5rem 0';
    attrPriorityDiv.innerHTML = attrLimits.map((lim, idx) => `
      <label>Приоритет ${idx+1} (${lim}):
        <select class="attr-priority-select" data-idx="${idx}">
          <option value="">Выберите...</option>
          ${attrGroups.map(g=>`<option value="${g}">${attrLabels[g]}</option>`).join('')}
        </select>
      </label>
    `).join('');
    const block = form.querySelector('.vtm3e-attributes');
    block.insertBefore(attrPriorityDiv, block.children[1]);
  }
  // Не выставляем значения по умолчанию!

  // Функция для обновления disabled-опций
  function updateAttrPriorityOptions() {
    const selects = Array.from(attrPriorityDiv.querySelectorAll('select'));
    const selected = selects.map(s=>s.value).filter(Boolean);
    selects.forEach((sel, idx) => {
      Array.from(sel.options).forEach(opt => {
        if (opt.value === "") { opt.disabled = false; return; }
        opt.disabled = selected.includes(opt.value) && sel.value !== opt.value;
      });
      // Подсветка если не выбран
      if (!sel.value) sel.style.border = '2px solid #c00';
      else sel.style.border = '';
    });
  }
  updateAttrPriorityOptions();

  // Обновление при изменении селектов
  attrPriorityDiv.querySelectorAll('select').forEach(sel => {
    sel.addEventListener('change', () => {
      const selects = Array.from(attrPriorityDiv.querySelectorAll('select'));
      const vals = selects.map(s=>s.value).filter(Boolean);
      updateAttrPriorityOptions();
      if (new Set(vals).size < 3) {
        // Не даём выбрать одинаковое значение или не все выбраны
        return;
      }
      // Все выбраны корректно
      form.dataset.attrPriority = JSON.stringify(vals);
      validateVtm3eLimitsWithPriority(form);
    });
  });

  // --- Способности (таланты/навыки/познания) ---
  const skillGroups = ['talent','skill','knowledge'];
  const skillLabels = { talent: 'Таланты', skill: 'Навыки', knowledge: 'Познания' };
  const skillLimits = [13,9,5];
  //let skillPriority = ['talent','skill','knowledge'];
  let skillPriorityDiv = form.querySelector('.skill-priority-selects');
  if (!skillPriorityDiv) {
    skillPriorityDiv = document.createElement('div');
    skillPriorityDiv.className = 'skill-priority-selects';
    skillPriorityDiv.style.display = 'flex';
    skillPriorityDiv.style.gap = '1.5rem';
    skillPriorityDiv.style.margin = '0.5rem 0 0.5rem 0';
    skillPriorityDiv.innerHTML = skillLimits.map((lim, idx) => `
      <label>Приоритет ${idx+1} (${lim}):
        <select class="skill-priority-select" data-idx="${idx}">
          <option value="">Выберите...</option>
          ${skillGroups.map(g=>`<option value="${g}">${skillLabels[g]}</option>`).join('')}
        </select>
      </label>
    `).join('');
    const block = form.querySelector('.vtm3e-talents');
    block.parentNode.insertBefore(skillPriorityDiv, block.nextSibling);
  }
  // Не выставляем значения по умолчанию!

  function updateSkillPriorityOptions() {
    const selects = Array.from(skillPriorityDiv.querySelectorAll('select'));
    const selected = selects.map(s=>s.value).filter(Boolean);
    selects.forEach((sel, idx) => {
      Array.from(sel.options).forEach(opt => {
        if (opt.value === "") { opt.disabled = false; return; }
        opt.disabled = selected.includes(opt.value) && sel.value !== opt.value;
      });
      if (!sel.value) sel.style.border = '2px solid #c00';
      else sel.style.border = '';
    });
  }
  updateSkillPriorityOptions();

  skillPriorityDiv.querySelectorAll('select').forEach(sel => {
    sel.addEventListener('change', () => {
      const selects = Array.from(skillPriorityDiv.querySelectorAll('select'));
      const vals = selects.map(s=>s.value).filter(Boolean);
      updateSkillPriorityOptions();
      if (new Set(vals).size < 3) {
        return;
      }
      form.dataset.skillPriority = JSON.stringify(vals);
      validateVtm3eLimitsWithPriority(form);
    });
  });
}

// Вызов инициализации при подгрузке формы
(function(){
  const observer = new MutationObserver(() => {
    const form = document.getElementById('character-sheet-form');
    if (form && form.classList.contains('vtm3e-sheet')) {
      renderVtm3ePrioritySelectors();
      observer.disconnect();
    }
  });
  observer.observe(document.body, {childList:true,subtree:true});
})();

// === FREEBIE POINTS ===
const FREEBIE_TOTAL = 15;
const FREEBIE_COSTS = {
  attr: 5, // Атрибуты
  skill: 2, // Навыки/Таланты/Познания
  discipline: 7,
  background: 1,
  virtue: 2,
  humanity: 1,
  willpower: 1
};

function showFreebieBlock() {
  let form = document.getElementById('character-sheet-form');
  if (!form || !form.classList.contains('vtm3e-sheet')) return;
  if (form.querySelector('.freebie-block')) return; // Уже есть
  // Создаём блок
  let block = document.createElement('div');
  block.className = 'freebie-block';
  block.style.margin = '2rem 0';
  block.style.padding = '1rem';
  block.style.border = '2px dashed #bfa76a';
  block.style.background = '#fffbe8';
  block.innerHTML = `
    <h3 style="color:#bfa76a;">Свободные очки (Freebie Points)</h3>
    <div>Осталось: <span id="freebie-remaining">${FREEBIE_TOTAL}</span> / ${FREEBIE_TOTAL}</div>
    <div class="freebie-fields"></div>
    <div style="font-size:0.9em;color:#888;">Наведите на параметр, чтобы увидеть стоимость повышения</div>
  `;
  form.appendChild(block);
  // Для каждого параметра — поле для добавления freebie
  const fields = [
    { group: 'Атрибуты', names: ['strength','dexterity','stamina','charisma','manipulation','appearance','perception','intelligence','wits'], cost: FREEBIE_COSTS.attr },
    { group: 'Таланты', names: ['acting','alertness','athletics','brawl','dodge','empathy','intimidation','leadership','streetwise','subterfuge'], cost: FREEBIE_COSTS.skill },
    { group: 'Навыки', names: ['animalken','drive','etiquette','firearms','melee','music','repair','security','stealth','survival'], cost: FREEBIE_COSTS.skill },
    { group: 'Познания', names: ['bureaucracy','computer','finance','investigation','law','linguistics','medicine','occult','politics','science'], cost: FREEBIE_COSTS.skill },
    { group: 'Дисциплины', names: ['discipline1_val','discipline2_val','discipline3_val'], cost: FREEBIE_COSTS.discipline },
    { group: 'Дополнения', names: ['background1_val','background2_val','background3_val','background4_val','background5_val'], cost: FREEBIE_COSTS.background },
    { group: 'Добродетели', names: ['conscience','selfcontrol','courage'], cost: FREEBIE_COSTS.virtue },
    { group: 'Человечность', names: ['humanity'], cost: FREEBIE_COSTS.humanity },
    { group: 'Сила воли', names: ['willpower'], cost: FREEBIE_COSTS.willpower }
  ];
  let html = '';
  fields.forEach(f => {
    html += `<div style="margin:0.5em 0;"><b>${f.group}:</b> `;
    f.names.forEach(n => {
      html += `<label style="margin-right:1em;">
        <span title="+1 стоит ${f.cost} очков">${n}</span>
        <input type="number" min="0" max="99" value="0" class="freebie-input" data-name="${n}" data-cost="${f.cost}" style="width:2.5em;">
      </label>`;
    });
    html += '</div>';
  });
  block.querySelector('.freebie-fields').innerHTML = html;
  // Логика подсчёта
  function updateFreebie() {
    let total = 0;
    block.querySelectorAll('.freebie-input').forEach(inp => {
      total += (parseInt(inp.value)||0) * parseInt(inp.dataset.cost);
    });
    let remain = FREEBIE_TOTAL - total;
    let remainSpan = block.querySelector('#freebie-remaining');
    remainSpan.textContent = remain;
    remainSpan.style.color = remain < 0 ? '#c00' : '';
    // Подсветка превышения
    block.style.borderColor = remain < 0 ? '#c00' : '#bfa76a';
    // Суммировать с основными значениями
    block.querySelectorAll('.freebie-input').forEach(inp => {
      let base = form.querySelector(`input[name="${inp.dataset.name}"]`);
      if (base) {
        let baseVal = parseInt(base.getAttribute('data-base')) || parseInt(base.value) || 0;
        base.value = baseVal + (parseInt(inp.value)||0);
      }
    });
  }
  block.querySelectorAll('.freebie-input').forEach(inp => {
    inp.addEventListener('input', updateFreebie);
    inp.addEventListener('focus', function(){
      inp.title = `+1 к этому параметру стоит ${inp.dataset.cost} свободных очков`;
    });
  });
  // Сохраняем базовые значения
  block.querySelectorAll('.freebie-input').forEach(inp => {
    let base = form.querySelector(`input[name="${inp.dataset.name}"]`);
    if (base) base.setAttribute('data-base', base.value);
  });
  updateFreebie();
}

// Показывать блок только после заполнения основных лимитов
function checkShowFreebieBlock() {
  let form = document.getElementById('character-sheet-form');
  if (!form || !form.classList.contains('vtm3e-sheet')) return;
  // Проверяем, что все основные лимиты заполнены (можно по наличию всех значений или по кнопке "далее")
  // Для простоты: если все атрибуты, таланты, навыки, познания, дисциплины, добродетели и дополнения не пустые
  let required = [
    'strength','dexterity','stamina','charisma','manipulation','appearance','perception','intelligence','wits',
    'acting','alertness','athletics','brawl','dodge','empathy','intimidation','leadership','streetwise','subterfuge',
    'animalken','drive','etiquette','firearms','melee','music','repair','security','stealth','survival',
    'bureaucracy','computer','finance','investigation','law','linguistics','medicine','occult','politics','science',
    'discipline1_val','discipline2_val','discipline3_val',
    'background1_val','background2_val','background3_val','background4_val','background5_val',
    'conscience','selfcontrol','courage'
  ];
  let allFilled = required.every(n => {
    let inp = form.querySelector(`input[name="${n}"]`);
    return inp && inp.value !== '' && inp.value !== '0';
  });
  if (allFilled) showFreebieBlock();
}

// Кнопка "Снятие ограничений"
function handleNoLimitsCheckbox() {
  let form = document.getElementById('character-sheet-form');
  if (!form) return;
  let noLimits = form.querySelector('#no-limits-checkbox');
  if (!noLimits) return;
  noLimits.addEventListener('change', function() {
    if (noLimits.checked) {
      // Скрыть freebie, снять все лимиты
      let fb = form.querySelector('.freebie-block');
      if (fb) fb.style.display = 'none';
      // Можно добавить снятие блокировок и подсветок
    } else {
      let fb = form.querySelector('.freebie-block');
      if (fb) fb.style.display = '';
      // Включить лимиты обратно (если нужно)
    }
  });
}

// Вызов checkShowFreebieBlock после каждого изменения основных параметров
function setupFreebieWatcher() {
  let form = document.getElementById('character-sheet-form');
  if (!form) return;
  let fields = form.querySelectorAll('input[type="hidden"]');
  fields.forEach(inp => {
    inp.addEventListener('input', checkShowFreebieBlock);
  });
}

// Вызов в конце инициализации формы:
// setupFreebieWatcher();
// handleNoLimitsCheckbox();
// checkShowFreebieBlock(); 