<div>
    @if($status === "view")
        <button wire:click="$set('status', 'new')">Добавить студента</button>
        <div style="width: 100%; padding: 10px; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <div style="text-align: center;"><h1 style="font-size: 20px;">Таблица «Студенты»</h1></div>
            <div style="margin: 10px 0">
                <label>
                    <select wire:model="filterFaculty" wire:change="changeFaculty">
                        <option value="0">Все факультеты</option>
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <select wire:model="filterSpecialization" wire:change="changeSpecialization">
                        <option value="0">Все специальности</option>
                        @foreach($specializations as $specialization)
                            <option value="{{$specialization->id}}">
                                {{$specialization->specialization_name}}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <select wire:model="filterGroup" wire:change="updatePage">
                        <option value="0">Все группы</option>
                        @foreach($groups as $group)
                            <option value="{{$group->id}}">
                                {{$group->group_name}}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <select wire:model="filterCourse" wire:change="updatePage">
                        <option value="0">Все курсы</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </label>
                <label>
                    Количество студентов: {{count($students)}}
                </label>
                <label>
                    <select wire:model="filterAge" wire:change="updatePage">
                        <option value="0">Все студенты</option>
                        <option value="1">Не достигли 18 лет к зачислению</option>
                        <option value="2">Достигли 18 лет к зачислению</option>
                    </select>
                </label>
            </div>
            <table style="width: 100%;">
                <thead>
                <tr>
                    <th style="border: 1px solid gray;">id</th>
                    <th style="border: 1px solid gray;">Факультет</th>
                    <th style="border: 1px solid gray;">Специальность</th>
                    <th style="border: 1px solid gray;">Год зачисления</th>
                    <th style="border: 1px solid gray;">Курс</th>
                    <th style="border: 1px solid gray;">Группа</th>
                    <th style="border: 1px solid gray;">ФИО</th>
                    <th style="border: 1px solid gray;">Пол</th>
                    <th style="border: 1px solid gray;">Дата рождения</th>
                    <th style="border: 1px solid gray;">Семейное положение</th>
                    <th style="border: 1px solid gray;">Семья</th>
                    <th style="border: 1px solid gray;">Стипендия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr title="Нажмите для редактирования" style="cursor: pointer;" wire:click="openEditor({{$student->id}})">
                        <td style="text-align: center; border: 1px solid gray;">{{$student->id}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->faculty_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->specialization_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->group_year}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->course}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->group_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->fio}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->student_gender ? 'Мужчина': 'Женщина'}}</td>
                        <td style="text-align: center; border: 1px solid gray;">
                            {{date('d.m.Y', strtotime($student->student_birth))}}
                        </td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->student_marital ? 'Женат/Замужем':
                        'Не женат/не замужем'}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$student->student_family}}</td>
                        <td style="text-align: center; border: 1px solid gray;
                        ">{{$student->scholarship_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @elseif ($status === "edit")
        <button wire:click="$set('status', 'view')">Отменить</button>
        <div style="width: 600px; margin: auto; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <div style="padding: 20px; text-align: center;">
                <h1 style="font-size: 20px;">Форма редактирования студента</h1>
                @if ($faculties)
                    <label>
                        <p style="margin-top: 10px;">Фамилия:</p>
                        <input wire:model="surname"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите фамилию"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Имя:</p>
                        <input wire:model="name"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите имя"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Отчество:</p>
                        <input wire:model="patronymic"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите отчество"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Пол:</p>
                        <select wire:model="gender" style="width: 100%;">
                            <option value="1">Мужчина</option>
                            <option value="0">Женщина</option>
                        </select>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Факультет:</p>
                        <select wire:model="idFaculty" wire:change="changeFaculty" style="width: 100%;">
                            @foreach($faculties as $faculty)
                                <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                            @endforeach
                        </select>
                    </label>
                    @if($specializations->isNotEmpty())
                        <label>
                            <p style="margin-top: 10px;">Специальность:</p>
                            <select wire:model="idSpecialization" wire:change="updatePage" style="width: 100%;">
                                @foreach($specializations as $specialization)
                                    <option value="{{$specialization->id}}">
                                        {{$specialization->specialization_name}}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        @if($groups->isNotEmpty())
                            <label>
                                <p style="margin-top: 10px;">Группа:</p>
                                <select wire:model="idGroup" style="width: 100%;">
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">
                                            {{$group->group_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Дата рождения:</p>
                                <input wire:model="birth"
                                       style="width: 100%;"
                                       type="date"
                                       placeholder="Введите дату"/>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Семейное положение:</p>
                                <select wire:model="marital" style="width: 100%;">
                                    <option value="0">Не женат/не замужем</option>
                                    <option value="1">Женат/Замужем</option>
                                </select>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Семья:</p>
                                <textarea
                                    wire:model="family"
                                    style="width: 100%;"
                                    placeholder="Введите данные о семье"
                                    rows="4">
                                </textarea>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Стипендия:</p>
                                <select wire:model="idScholarship" style="width: 100%;">
                                    @foreach($scholarships as $scholarship)
                                        <option value="{{$scholarship->id}}">
                                            {{$scholarship->scholarship_name}} ({{$scholarship->scholarship_count}})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <p></p>
                            <button style="margin-top: 15px;" wire:click="update({{$updateId}})">Сохранить</button>
                        @else
                            <h1 style="font-size: 20px;">По данной специальности нет групп</h1>
                        @endif
                    @else
                        <h1 style="font-size: 20px;">По данному факультету специальностей нет</h1>
                    @endif
                @else
                    <h1 style="font-size: 20px;">Отсутствуют факультеты!</h1>
                @endif
            </div>
        </div>
    @elseif ($status === "new")
        <button wire:click="$set('status', 'view')">Отменить</button>
        <div style="width: 600px; margin: auto; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <form wire:submit="save" style="padding: 20px; text-align: center;">
                <h1 style="font-size: 20px;">Форма добавления студента</h1>
                @if ($faculties)
                    <label>
                        <p style="margin-top: 10px;">Фамилия:</p>
                        <input wire:model="surname"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите фамилию"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Имя:</p>
                        <input wire:model="name"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите имя"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Отчество:</p>
                        <input wire:model="patronymic"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите отчество"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Пол:</p>
                        <select wire:model="gender" style="width: 100%;">
                            <option value="1">Мужчина</option>
                            <option value="0">Женщина</option>
                        </select>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Факультет:</p>
                        <select wire:model="idFaculty" wire:change="changeFaculty" style="width: 100%;">
                            @foreach($faculties as $faculty)
                                <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                            @endforeach
                        </select>
                    </label>
                    @if($specializations->isNotEmpty())
                        <label>
                            <p style="margin-top: 10px;">Специальность:</p>
                            <select wire:model="idSpecialization" wire:change="updatePage" style="width: 100%;">
                                @foreach($specializations as $specialization)
                                    <option value="{{$specialization->id}}">
                                        {{$specialization->specialization_name}}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        @if($groups->isNotEmpty())
                            <label>
                                <p style="margin-top: 10px;">Группа:</p>
                                <select wire:model="idGroup" style="width: 100%;">
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">
                                            {{$group->group_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Дата рождения:</p>
                                <input wire:model="birth"
                                       style="width: 100%;"
                                       type="date"
                                       placeholder="Введите дату"/>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Семейное положение:</p>
                                <select wire:model="marital" style="width: 100%;">
                                    <option value="0">Не женат/не замужем</option>
                                    <option value="1">Женат/Замужем</option>
                                </select>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Семья:</p>
                                <textarea
                                        wire:model="family"
                                        style="width: 100%;"
                                        placeholder="Введите данные о семье"
                                        rows="4">
                                </textarea>
                            </label>
                            <label>
                                <p style="margin-top: 10px;">Стипендия:</p>
                                <select wire:model="idScholarship" style="width: 100%;">
                                    @foreach($scholarships as $scholarship)
                                        <option value="{{$scholarship->id}}">
                                            {{$scholarship->scholarship_name}} ({{$scholarship->scholarship_count}})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <p></p>
                            <button style="margin-top: 15px;">Добавить</button>
                        @else
                            <h1 style="font-size: 20px;">По данной специальности нет групп</h1>
                        @endif
                    @else
                        <h1 style="font-size: 20px;">По данному факультету специальностей нет</h1>
                    @endif
                @else
                    <h1 style="font-size: 20px;">Отсутствуют факультеты!</h1>
                @endif
            </form>
        </div>
    @endif
</div>
