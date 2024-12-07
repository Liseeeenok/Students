<?php

namespace App\Livewire\Student;

use App\Models\Faculty;
use App\Models\Group;
use App\Models\Scholarship;
use App\Models\Specialization;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class View extends Component
{
    public string $status = 'view';
    public string $name = '';
    public string $surname = '';
    public string $patronymic = '';
    public int $gender = 1;
    public int $idFaculty = 0;
    public int $idSpecialization = 0;
    public int $idGroup = 0;
    public string $birth = '';
    public int $marital = 0;
    public string $family = '';
    public int $idScholarship = 0;
    public int $filterFaculty = 0;
    public int $filterSpecialization = 0;
    public int $filterGroup = 0;
    public int $filterCourse = 0;
    public int $filterAge = 0;
    public int $updateId = 0;
    public function render()
    {
        return view('livewire.student.view', [
            'faculties' => $this->getFaculties(),
            'specializations' => $this->getSpecializations(),
            'groups' => $this->getGroups(),
            'scholarships' => $this->getScholarships(),
            'students' => $this->getStudents(),
        ]);
    }

    /*
     * Student::create([
                'student_surname' => $this->surname,
                'student_name' => $this->name,
                'student_patronymic' => $this->patronymic,
                'student_gender' => $this->gender,
                'group_id' => $this->idGroup,
                'student_birth' => $this->birth,
                'student_marital' => $this->marital,
                'student_family' => $this->family,
                'student_scholarship' => $this->scholarship,
            ]);
     */

    public function save()
    {
        if ($this->name && $this->surname && $this->idGroup && $this->birth)
        {
            DB::select("
            INSERT INTO public.students (student_surname, student_name,
            student_patronymic, student_gender, group_id, student_birth,
            student_marital, student_family, scholarship_id) VALUES
            ('$this->surname', '$this->name', '$this->patronymic',
            $this->gender::boolean, $this->idGroup, '$this->birth',
            $this->marital::boolean, '$this->family', $this->idScholarship)
            ");
            $this->status = 'view';
            $this->surname = '';
            $this->name = '';
            $this->patronymic = '';
            $this->gender = 1;
            $this->idFaculty = 0;
            $this->idSpecialization = 0;
            $this->idGroup = 0;
            $this->birth = '';
            $this->marital = 0;
            $this->family = '';
            $this->scholarship = 0;
        }
        return view('livewire.student.view');
    }

    public function getFaculties()
    {
        $faculty = Faculty::orderBy('faculty_name')->get();
        $first = $faculty->first();
        if ($first && $this->idFaculty === 0)
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
        if ($first && $this->idSpecialization === 0 && $this->status === 'new')
        {
            $this->idSpecialization = $first->id;
        }
        return $specialization;
    }

    public function getGroups()
    {
        $grQuery = Group::orderBy('group_name');
        if ($this->status === 'view')
        {
            if ($this->filterSpecialization)
            {
                $grQuery->where('specialization_id', $this->filterSpecialization);
            }
        }
        else
        {
            $grQuery->where('specialization_id', $this->idSpecialization);
        }
        $group = $grQuery->get();
        $first = $group->first();
        if ($first && $this->idGroup === 0 && $this->status !== 'view')
        {
            $this->idGroup = $first->id;
        }
        return $group;
    }

    public function getScholarships()
    {
        $grQuery = Scholarship::orderBy('scholarship_name');
        $scholarship = $grQuery->get();
        $first = $scholarship->first();
        if ($first && $this->idScholarship === 0)
        {
            $this->idScholarship = $first->id;
        }
        return $scholarship;
    }

    public function getStudents()
    {
        $students = DB::select('
SELECT students.*, groups.group_name, specializations.specialization_name, faculties.faculty_name,
groups.specialization_id, specializations.faculty_id, groups.group_year, scholarships.scholarship_count
FROM public.students
LEFT JOIN public.groups ON groups.id = students.group_id
LEFT JOIN public.specializations ON specializations.id = groups.specialization_id
LEFT JOIN public.faculties ON faculties.id = specializations.faculty_id
LEFT JOIN public.scholarships ON scholarships.id = students.scholarship_id
ORDER BY faculties.faculty_name, specializations.specialization_name, groups.group_name, students.student_surname
');
        if ($this->filterFaculty)
        {
            $students = array_filter($students, function($value)
            {
                return $value->faculty_id === $this->filterFaculty;
            });
        }
        if ($this->filterSpecialization)
        {
            $students = array_filter($students, function($value)
            {
                return $value->specialization_id === $this->filterSpecialization;
            });
        }
        if ($this->filterGroup)
        {
            $students = array_filter($students, function($value)
            {
                return $value->group_id === $this->filterGroup;
            });
        }
        $date2 = new \DateTime();
        foreach ($students as $student)
        {
            $date1 = new \DateTime($student->group_year . "-09-01");
            $date3 = new \DateTime($student->student_birth);
            $student->course = $date1->diff($date2)->y + 1;
            $student->fio = $student->student_surname . ' ' . $student->student_name . ' ' . $student->student_patronymic;
            $student->age = $date3->diff($date1)->y;
        }
        if ($this->filterCourse) {
            $students = array_filter($students, function($value)
            {
                return $value->course === $this->filterCourse;
            });
        }
        if ($this->filterAge) {
            $students = array_filter($students, function($value)
            {
                if ($this->filterAge === 1)
                    return $value->age < 18;
                else
                    return $value->age >= 18;
            });
        }
        return $students;
    }

    public function changeFaculty()
    {
        $this->idSpecialization = 0;
        $this->filterSpecialization = 0;
        $this->changeSpecialization();
    }

    public function changeSpecialization()
    {
        $this->filterGroup = 0;
        $this->filterCourse = 0;
        $this->filterAge = 0;
        $this->idGroup = 0;
    }

    public function openEditor($id)
    {
        $this->status = 'edit';
        $this->updateId = $id;
        $student = Student::find($id);
        $this->surname = $student->student_surname;
        $this->name = $student->student_name;
        $this->patronymic = $student->student_patronymic;
        $this->gender = $student->student_gender;
        $this->idFaculty = $student->group->specialization->faculty_id;
        $this->idSpecialization = $student->group->specialization_id;
        $this->idGroup = $student->group_id;
        $this->birth = $student->student_birth;
        $this->marital = $student->student_marital;
        $this->family = $student->student_family;
        $this->idScholarship = $student->scholarship_id;
    }

    public function update($id)
    {
        if ($this->name && $this->surname && $this->idGroup && $this->birth)
        {
            DB::select("
            UPDATE public.students SET
            student_surname = '$this->surname',
            student_name = '$this->name',
            student_patronymic = '$this->patronymic',
            student_gender = $this->gender::boolean,
            group_id = $this->idGroup,
            student_birth = '$this->birth',
            student_marital = $this->marital::boolean,
            student_family = '$this->family',
            scholarship_id = $this->idScholarship
            WHERE id = $id;
            ");
            $this->status = 'view';
            return view('livewire.student.view');
        }
    }

    public function updatePage()
    {
    }
}
