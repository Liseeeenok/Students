<?php

namespace App\Livewire\Scholarship;

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
        return view('livewire.scholarship.view', ['scholarships' => $this->getScholarships()]);
    }

    public function save()
    {
        if ($this->name)
        {
            DB::select("
            INSERT INTO public.scholarships (scholarship_name, scholarship_count) VALUES ('$this->name', $this->count)
            ");
            $this->status = 'view';
            $this->name = '';
            $this->count = 0;
        }
        return view('livewire.scholarship.view');
    }

    public function getScholarships()
    {
        return DB::select("
        SELECT scholarships.* FROM public.scholarships ORDER BY scholarships.id
        ");
    }

    public function openEditor($id)
    {
        dd();
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
            return view('livewire.scholarship.view');
        }
    }
}
