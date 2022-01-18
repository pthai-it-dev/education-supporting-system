<?php

namespace App\Http\Resources;

use App\Helpers\GData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function __construct ($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @param array   $a
     *
     * @return array
     */
    public function toArray ($request, array $a = []) : array
    {
        $arr         = explode('-', $this->id_module_class);
        $id_module   = $arr[0];
        $module_name = str_replace('-' . $arr[1] . '-' . $arr[2] . '-' . $arr[3],
                                   '', $this->moduleClass->name);

        if ($this->moduleClass->teacher != 'self')
        {
            if (!isset(GData::$current[$id_module]))
            {
                GData::$current[$id_module] = array_shift(GData::$colors);
            }
            $color          = GData::$current[$id_module];
            $teacher        = is_null($this->moduleClass->teacher) ? null : $this->moduleClass->teacher->name;
            $fixedSchedules = [];
        }
        else
        {
            if (!isset(GData::$current[$this->id_module_class]))
            {
                GData::$current[$this->id_module_class] = array_shift(GData::$colors);
            }
            $color          = GData::$current[$this->id_module_class];
            $teacher        = $this->moduleClass->teacher;
            $fixedSchedules = $this->fixedSchedules;
        }

        return [
            'id'            => $this->id,
            'idModuleClass' => $this->id_module_class,
            'name'          => $this->moduleClass->name,
            'idRoom'        => $this->id_room,
            'shift'         => $this->shift,
            'date'          => $this->date,
            'idModule'      => $id_module,
            'note'          => $this->note,
            'moduleName'    => $module_name,
            'teacher'       => $teacher,
            'color'         => $color,
            'fixedSchedule' => $fixedSchedules,
        ];
    }
}
