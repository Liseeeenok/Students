<?php

use App\Models\Group;
use App\Models\Scholarship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); //ID

            $table->string('student_surname'); //Фамилия
            $table->string('student_name'); //Имя
            $table->string('student_patronymic')->nullable(); //Отчество
            $table->boolean('student_gender'); //Пол
            $table->foreignIdFor(Group::class)->constrained()->cascadeOnDelete(); //ID группы
            $table->date('student_birth'); //Дата рождения
            $table->boolean('student_marital'); //Семейное положение
            $table->text('student_family')->nullable(); //Семья
            $table->foreignIdFor(Scholarship::class)->constrained()->cascadeOnDelete(); //Стипендия

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
