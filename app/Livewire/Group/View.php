<?php

namespace App\Livewire\Group;

use App\Models\Faculty;
use App\Models\Group;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public string $status = 'view';
    public string $name = '';
    public int $idFaculty = 0;
    public int $idSpecialization = 0;
    public int $year = 0;
    public int $filterFaculty = 0;
    public int $filterSpecialization = 0;
    public int $updateId = 0;
    public int $filterCourse = 0;

    public function render()
    {
        return view('livewire.group.view', [
            'faculties' => $this->getFaculties(),
            'specializations' => $this->getSpecializations(),
            'groups' => $this->getGroups(),
        ]);
    }

    /*
     * Group::create([
                'group_name' => $this->name,
                'specialization_id' => $this->idSpecialization,
                'group_year' => $this->year,
            ]);
     */
    public function save()
    {
        if ($this->name !== "" && $this->year !== 0)
        {

            DB::select("
            INSERT INTO public.groups (group_name, specialization_id, group_year) VALUES ('$this->name', $this->idSpecialization, $this->year);
            ");
            $this->status = 'view';
            $this->name = '';
            $this->idFaculty = 0;
            $this->idSpecialization = 0;
            $this->year = 0;
        }
        return view('livewire.group.view');
    }

    public function getFaculties()
    {
        $faculty = Faculty::orderBy('faculty_name')->get();
        $first = $faculty->first();
        if ($first && $this->idFaculty === 0 && $this->status === 'new')
        {
            $this->idFaculty = $first->id;
        }
        return $faculty;
    }

    public function getSpecializations()
    {
        $spQuery = Specialization::orderBy('specialization_name');
        if ($this->status === 'view')
        {
            if ($this->filterFaculty)
            {
                $spQuery->where('faculty_id', $this->filterFaculty);
            }
        }
        else
        {
            $spQuery->where('faculty_id', $this->idFaculty);
        }
        $specialization = $spQuery->get();
        $first = $specialization->first();
        if ($first && $this->status === 'new')
        {
            $this->idSpecialization = $first->id;
        }
        return $specialization;
    }

    public function getGroups()
    {
        $groups = DB::select("
        SELECT groups.*, specializations.specialization_name, faculties.faculty_name, specializations.faculty_id,
        count(students.id), sum(scholarships.scholarship_count) FROM public.groups
        LEFT JOIN public.students ON students.group_id = groups.id
        LEFT JOIN public.specializations ON specializations.id = groups.specialization_id
        LEFT JOIN public.faculties ON specializations.faculty_id = faculties.id
        LEFT JOIN public.scholarships ON students.scholarship_id = scholarships.id
        GROUP BY groups.id, specializations.specialization_name, faculties.faculty_name, specializations.faculty_id
        ORDER BY faculties.faculty_name, specializations.specialization_name, groups.group_name
        ");
        if ($this->filterFaculty)
        {
            $groups = array_filter($groups, function($value)
            {
                return $value->faculty_id === $this->filterFaculty;
            });
        }
        if ($this->filterSpecialization)
        {
            $groups = array_filter($groups, function($value)
            {
                return $value->specialization_id === $this->filterSpecialization;
            });
        }
        $date2 = new \DateTime();
        foreach ($groups as $group)
        {
            $date1 = new \DateTime($group->group_year . "-09-01");
            $interval = $date1->diff($date2);
            $group->course = $interval->y + 1;
        }
        if ($this->filterCourse) {
            $groups = array_filter($groups, function($value)
            {
                return $value->course === $this->filterCourse;
            });
        }
        return $groups;
    }

    public function changeFaculty()
    {
        $this->filterSpecialization = 0;
    }

    public function openEditor($id)
    {
        $this->status = 'edit';
        $this->updateId = $id;
        $group = Group::find($id);
        $this->name = $group->group_name;
        $this->idSpecialization = $group->specialization_id;
        $this->year = $group->group_year;
        $this->idFaculty = $group->specialization->faculty_id;
    }

    public function update($id)
    {
        if ($this->name && $this->year)
        {
            DB::select("
            UPDATE public.groups SET group_name = '$this->name', group_year = $this->year WHERE id = $id;
            ");
            $this->status = 'view';
            return view('livewire.group.view');
        }
    }

    public function updatePage()
    {
    }
}
