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
     *
     * @return array
     */
    public function toArray ($request) : array
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
            $color = GData::$current[$id_module];
        }
        else
        {
            if (!isset(GData::$current[$this->id_module_class]))
            {
                GData::$current[$this->id_module_class] = array_shift(GData::$colors);
            }
            $color = GData::$current[$this->id_module_class];
        }

        $this->fixedSchedules = $this->fixedSchedules->map(function ($item, $key)
        {
            return [
                'id'          => $item->id,
                'idSchedule'  => $item->id_schedule,
                'timeRequest' => $item->time_request,
                'oldDate'     => $item->old_date,
                'oldShift'    => $item->old_shift,
                'oldIdRoom'   => $item->old_id_room,
                'newDate'     => $item->new_date,
                'newShift'    => $item->new_shift,
                'newIdRoom'   => $item->new_id_room,
                'status'      => $item->status,
            ];
        });

        return [
            'id'             => $this->id,
            'idModuleClass'  => $this->id_module_class,
            'name'           => $this->moduleClass->name,
            'idRoom'         => $this->id_room,
            'shift'          => $this->shift,
            'date'           => $this->date . ' 00:00:00.000',
            'idModule'       => $id_module,
            'note'           => $this->note,
            'moduleName'     => $module_name,
            'teacher'        => $this->moduleClass->teacher,
            'color'          => $color,
            'fixedSchedules' => $this->fixedSchedules,
        ];
    }
}
