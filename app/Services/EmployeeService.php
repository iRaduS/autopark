<?php

namespace App\Services;

use Carbon\Carbon;

class EmployeeService
{
    private const ALL_EMPLOYEES_PROPERTIES = 6;

    private function fromSerialToDate($serial) {
        return Carbon::createFromTimestamp(($serial - 25569) * 86400);
    }

    /**
     * @param $data
     * @return array[]
     */
    public function returnEmployeeDataArr($data) {
        return array_map(function ($array) {
            return count($array) === self::ALL_EMPLOYEES_PROPERTIES ? [
                'last_name' => $array[0],
                'first_name' => $array[1],
                'personal_code' => $array[2],
                'title' => $array[3],
                'employment_date' => $this->fromSerialToDate($array[4]),
                'unemployment_date' => $this->fromSerialToDate($array[5]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ] : [
                'last_name' => $array[0],
                'first_name' => $array[1],
                'personal_code' => $array[2],
                'title' => $array[3],
                'employment_date' => $this->fromSerialToDate($array[4]),
                'unemployment_date' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }, $data);
    }
}
