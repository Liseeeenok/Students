<div>
    @if($status === "view")
        <button wire:click="$set('status', 'new')">Добавить специальность</button>
        <div style="width: 100%; padding: 10px; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <div style="text-align: center;"><h1 style="font-size: 20px;">Таблица «Специальности»</h1></div>
            <div style="margin: 10px 0">
                <label>
                    Название факультета:
                    <select wire:model="filterFaculty" wire:change="updateTable">
                        <option value="0">Все факультеты</option>
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <table style="width: 100%;">
                <thead>
                <tr>
                    <th style="border: 1px solid gray;">id</th>
                    <th style="border: 1px solid gray;">Факультет</th>
                    <th style="border: 1px solid gray;">Название</th>
                    <th style="border: 1px solid gray;">Количество обучающихся</th>
                </tr>
                </thead>
                <tbody>
                @foreach($specializations as $specialization)
                    <tr title="Нажмите для редактирования" style="cursor: pointer;" wire:click="openEditor({{$specialization->id}})">
                        <td style="text-align: center; border: 1px solid gray;">{{$specialization->id}}</td>
                        <td style="border: 1px solid gray;">{{$specialization->faculty_name}}</td>
                        <td style="border: 1px solid gray;">{{$specialization->specialization_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$specialization->count}}</td>
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
                <h1 style="font-size: 20px;">Форма для редактирования специальности</h1>
                @if ($faculties->isNotEmpty())
                    <label>
                        <p style="margin-top: 10px;">Название:</p>
                        <input wire:model="name"
                               style="width: 100%;"
                               type="text"
                               placeholder="Введите название специальности"/>
                    </label>
                    <label>
                        <p style="margin-top: 10px;">Факультет:</p>
                        <select wire:model="idFaculty" style="width: 100%;">
                            @foreach($faculties as $faculty)
                                <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                            @endforeach
                        </select>
                    </label>
                    <p></p>
                    <button style="margin-top: 15px;" wire:click="update({{$updateId}})">Сохранить</button>
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
                <h1 style="font-size: 20px;">Форма добавления специальности</h1>
                @if ($faculties->isNotEmpty())
                <label>
                    <p style="margin-top: 10px;">Название:</p>
                    <input wire:model="name"
                           style="width: 100%;"
                           type="text"
                           placeholder="Введите название специальности"/>
                </label>
                <label>
                    <p style="margin-top: 10px;">Факультет:</p>
                    <select wire:model="idFaculty" style="width: 100%;">
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                        @endforeach
                    </select>
                </label>
                <p></p>
                <button style="margin-top: 15px;">Добавить</button>
                @else
                    <h1 style="font-size: 20px;">Отсутствуют факультеты!</h1>
                @endif
            </form>
        </div>
    @endif
</div>
