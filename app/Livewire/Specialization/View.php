<?php

namespace App\Livewire\Specialization;

use App\Models\Faculty;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public string $status = 'view';
    public string $name = '';
    public int $idFaculty = 0;
    public int $filterFaculty = 0;
    public int $updateId = 0;

    public function render()
    {
        return view('livewire.specialization.view', [
            'faculties' => $this->getFaculties(),
            'specializations' => $this->getSpecializations(),
        ]);
    }

    //Specialization::create(['specialization_name' => $this->name, 'faculty_id' => $this->idFaculty]);
    public function save()
    {
        if ($this->name !== "")
        {
            DB::select("
            INSERT INTO public.specializations (specialization_name, faculty_id) VALUES ('$this->name', $this->idFaculty);
            ");
            $this->status = 'view';
            $this->name = '';
            $this->idFaculty = 0;
        }
        return view('livewire.specialization.view');
    }

    public function getFaculties()
    {
        $faculty = Faculty::orderBy('faculty_name')->get();
        $first = $faculty->first();
        if ($first && $this->status === 'new')
        {
            $this->idFaculty = $first->id;
        }
        return $faculty;
    }

    public function getSpecializations()
    {
        $specializations =  DB::select("
        SELECT specializations.*, faculties.faculty_name, count(students.id) FROM public.specializations
        LEFT JOIN public.groups ON groups.specialization_id = specializations.id
        LEFT JOIN public.students ON students.group_id = groups.id
        LEFT JOIN public.faculties ON specializations.faculty_id = faculties.id
        GROUP BY specializations.id, faculties.faculty_name ORDER BY faculties.faculty_name, specializations.specialization_name
        ");
        if ($this->filterFaculty)
        {
            $specializations = array_filter($specializations, function($value) {
                return $value->faculty_id === $this->filterFaculty;});
        }
        return $specializations;
    }

    public function openEditor($id)
    {
        $this->status = 'edit';
        $this->updateId = $id;
        $specialization = Specialization::where('id', $id)->get()->first();
        $this->name = $specialization->specialization_name;
        $this->idFaculty = $specialization->faculty_id;
    }

    public function update($id)
    {
        if ($this->name !== '') {
            DB::select("
            UPDATE public.specializations SET specialization_name = '$this->name', faculty_id = $this->idFaculty where id = $id;
            ");
            $this->status = 'view';
            return view('livewire.specialization.view');
        }
    }

    public function updateTable()
    {
    }
}
