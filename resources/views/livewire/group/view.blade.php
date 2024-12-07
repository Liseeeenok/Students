<div>
    @if($status === "view")
        <button wire:click="$set('status', 'new')">Добавить группу</button>
        <div style="width: 100%; padding: 10px; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <div style="text-align: center;"><h1 style="font-size: 20px;">Таблица «Группы»</h1></div>
            <div style="margin: 10px 0">
                <label>
                    Название факультета:
                    <select wire:model="filterFaculty" wire:change="changeFaculty">
                        <option value="0">Все факультеты</option>
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Название специальности:
                    <select wire:model="filterSpecialization" wire:change="updatePage">
                        <option value="0">Все специальности</option>
                        @foreach($specializations as $specialization)
                            <option value="{{$specialization->id}}">
                                {{$specialization->specialization_name}}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Курс:
                    <select wire:model="filterCourse" wire:change="updatePage">
                        <option value="0">Все курсы</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </label>
            </div>
            <table style="width: 100%;">
                <thead>
                <tr>
                    <th style="border: 1px solid gray;">id</th>
                    <th style="border: 1px solid gray;">Факультет</th>
                    <th style="border: 1px solid gray;">Специальность</th>
                    <th style="border: 1px solid gray;">Курс</th>
                    <th style="border: 1px solid gray;">Название</th>
                    <th style="border: 1px solid gray;">Количество обучающихся</th>
                    <th style="border: 1px solid gray;">Год поступления</th>
                    <th style="border: 1px solid gray;">Суммарная стипендия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr title="Нажмите для редактирования" style="cursor: pointer;" wire:click="openEditor({{$group->id}})">
                        <td style="text-align: center; border: 1px solid gray;">{{$group->id}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->faculty_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->specialization_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->course}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->group_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->count}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->group_year}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$group->sum}}</td>
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
                <h1 style="font-size: 20px;">Форма редактирования группы</h1>
                @if ($faculties)
                    <label>
                        <p style="margin-top: 10px;">Название:</p>
                        <input wire:model="name"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите название группы"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Факультет:</p>
                        <select wire:model="idFaculty" wire:change="updatePage" style="width: 100%;">
                            @foreach($faculties as $faculty)
                                <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                            @endforeach
                        </select>
                    </label>
                    @if($specializations->isNotEmpty())
                        <label>
                            <p style="margin-top: 10px;">Специальность:</p>
                            <select wire:model="idSpecialization" style="width: 100%;">
                                @foreach($specializations as $specialization)
                                    <option value="{{$specialization->id}}">
                                        {{$specialization->specialization_name}}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <p style="margin-top: 10px;">Год поступления:</p>
                            <input wire:model="year" style="width: 100%;" type="number" placeholder="Введите год"/>
                        </label>
                        <p></p>
                        <button style="margin-top: 15px;" wire:click="update({{$updateId}})">Сохранить</button>
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
                <h1 style="font-size: 20px;">Форма добавления группы</h1>
                @if ($faculties)
                    <label>
                        <p style="margin-top: 10px;">Название:</p>
                        <input wire:model="name"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите название группы"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Факультет:</p>
                        <select wire:model="idFaculty" wire:change="updatePage" style="width: 100%;">
                            @foreach($faculties as $faculty)
                                <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                            @endforeach
                        </select>
                    </label>
                    @if($specializations->isNotEmpty())
                        <label>
                            <p style="margin-top: 10px;">Специальность:</p>
                            <select wire:model="idSpecialization" style="width: 100%;">
                                @foreach($specializations as $specialization)
                                    <option value="{{$specialization->id}}">
                                        {{$specialization->specialization_name}}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <p style="margin-top: 10px;">Год поступления:</p>
                            <input wire:model="year" style="width: 100%;" type="number" placeholder="Введите год"/>
                        </label>
                        <p></p>
                        <button style="margin-top: 15px;">Добавить</button>
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
