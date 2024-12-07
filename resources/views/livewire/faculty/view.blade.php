<div>
    @if($status === "view")
        <button wire:click="$set('status', 'new')">Добавить факультет</button>
        <div style="width: 100%; padding: 10px; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <div style="text-align: center;"><h1 style="font-size: 20px;">Таблица «Факультеты»</h1></div>
            <table style="width: 100%;">
                <thead>
                <tr>
                    <th style="border: 1px solid gray;">id</th>
                    <th style="border: 1px solid gray;">Название</th>
                    <th style="border: 1px solid gray;">Количество обучающихся</th>
                    <th style="border: 1px solid gray;">Число мест</th>
                </tr>
                </thead>
                <tbody>
                @foreach($faculties as $faculty)
                    <tr title="Нажмите для редактирования" style="cursor: pointer;" wire:click="openEditor({{$faculty->id}})">
                        <td style="text-align: center; border: 1px solid gray;">{{$faculty->id}}</td>
                        <td style="border: 1px solid gray;">{{$faculty->faculty_name}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$faculty->count}}</td>
                        <td style="text-align: center; border: 1px solid gray;">{{$faculty->faculty_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @elseif ($status === "edit")
        <button wire:click="$set('status', 'view')">Отменить</button>
        <div style="width: 300px; margin: auto; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <div style="padding: 20px; text-align: center;">
                <h1 style="font-size: 20px;">Форма изменения факультета</h1>
                <label>
                    <p style="margin-top: 10px;">Название:</p>
                    <input wire:model="name"
                           style="width: 100%;"
                           type="text"
                           placeholder="Введите название факультета"/>
                </label>
                <label>
                    <p style="margin-top: 10px;">Количество мест:</p>
                    <input wire:model="count" style="width: 100%;" type="number" placeholder="Введите количество мест"/>
                </label>
                <p></p>
                <button style="margin-top: 15px;" wire:click="update({{$updateId}})">Сохранить</button>
            </div>
        </div>
    @elseif ($status === "new")
        <button wire:click="$set('status', 'view')">Отменить</button>
        <div style="width: 300px; margin: auto; background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;">
            <form wire:submit="save" style="padding: 20px; text-align: center;">
                <h1 style="font-size: 20px;">Форма добавления факультета</h1>
                <label>
                    <p style="margin-top: 10px;">Название:</p>
                    <input wire:model="name"
                           style="width: 100%;"
                           type="text"
                           placeholder="Введите название факультета"/>
                </label>
                <label>
                    <p style="margin-top: 10px;">Количество мест:</p>
                    <input wire:model="count" style="width: 100%;" type="number" placeholder="Введите количество мест"/>
                </label>
                <p></p>
                <button style="margin-top: 15px;">Добавить</button>
            </form>
        </div>
    @endif
</div>
