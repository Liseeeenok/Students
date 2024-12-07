<?php

namespace App\Livewire\Faculty;

use App\Models\Faculty;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public string $status = 'view';
    public string $name = '';
    public int $count = 0;
    public int $updateId = 0;

    public function render()
    {
        return view('livewire.faculty.view', ['faculties' => $this->getFaculties()]);
    }

    //Faculty::create(['faculty_name' => $this->name, 'faculty_count' => $this->count]);
    public function save()
    {
        if ($this->name !== "" && $this->count !== 0)
        {
            DB::select("
            INSERT INTO public.faculties (faculty_name, faculty_count) VALUES ('$this->name', $this->count)
            ");
            $this->status = 'view';
            $this->name = '';
            $this->count = 0;
        }
        return view('livewire.faculty.view');
    }

    public function getFaculties()
    {
        return DB::select("
        SELECT faculties.*, count(students.id) FROM public.faculties
        LEFT JOIN public.specializations ON specializations.faculty_id = faculties.id
        LEFT JOIN public.groups ON groups.specialization_id = specializations.id
        LEFT JOIN public.students ON students.group_id = groups.id
        GROUP BY faculties.id ORDER BY faculties.faculty_name
        ");
    }

    public function openEditor($id)
    {
        $this->status = 'edit';
        $this->updateId = $id;
        $faculty = Faculty::where('id', $id)->get()->first();
        $this->name = $faculty->faculty_name;
        $this->count = $faculty->faculty_count;
    }

    public function update($id)
    {
        if ($this->name !== "" && $this->count !== 0)
        {
            DB::select("
            UPDATE public.faculties SET faculty_name = '$this->name', faculty_count = $this->count where id = $id;
            ");
            $this->status = 'view';
            return view('livewire.faculty.view');
        }
    }
}
