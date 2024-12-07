<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Главная') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div style="text-align: center;">
                        <h1 style="font-size: 24px;">Это база личных данных студентов.<h1>
                    </div>
                    <h2 style="font-size: 18px;">Функции для взаимодействия:</h2>
                    1) Для добавления новых записей в таблицу есть кнопка над таблицей. <br>
                    2) Для редактирования записи нужно нажать на неё.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
