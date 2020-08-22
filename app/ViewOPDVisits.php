<?php
namespace App;
/**
 * :: View OPD Visits Model ::
 * To manage View OPD Visits CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;

class ViewOPDVisits extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'view_opd_visits';

    public function getFilters($search = [])
    {
        $filter = 1; // default filter if no search

        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('doctor', $search) && $search['doctor'] != "") ? " AND (doctor_id = " .
                addslashes(trim($search['doctor'])) . ")" : "";

            $filter .= (array_key_exists('department', $search) && $search['department'] != "") ? " AND (department_id = " .
                addslashes(trim($search['department'])) . ")" : "";

            $filter .= (array_key_exists('patient_name', $search) && $search['patient_name'] != "") ? " AND (patient LIKE '%" .
                addslashes(trim($search['patient_name'])) . "%')" : "";

            $filter .= (array_key_exists('patient_code', $search) && $search['patient_code'] != "") ? " AND (patient_code LIKE '%" .
                addslashes(trim($search['patient_code'])) . "%')" : "";

            $filter .= (array_key_exists('opd_number', $search) && $search['opd_number'] != "") ?
                " AND (opd_number LIKE '%" . addslashes(trim($search['opd_number'])) . "%') " : "";


            if (array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                array_key_exists('to_date', $search) && $search['to_date'] == "")
            {
                $date = dateFormat("Y-m-d", $search['from_date']);
                $filter .=  " AND (visit_date >= '" . addslashes(trim($date)) . "')";
            }

            if (array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                array_key_exists('to_date', $search) && $search['to_date'] != "" && $search['report_type'] == '1'
            )
            {
                $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
                $to = dateFormat("Y-m-d H:i", $search['to_date'] . ' 23:59');
                $filter .= " AND (visit_date between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";
                
            }
        }

        return $filter;
    }

    /**
     * Method is used to search news detail.
     *
     * @param array $search
     * @return mixed
     */
    public function filterOPDVisits($search = [])
    {
        $fields = [
            '*',
        ];

        $filter = $this->getFilters($search);


        $orderEntity = 'visit_date';
        $orderAction = 'desc';

        if (isset($search['form-search']))
        {
            // dd($this->whereRaw($filter)
            //     ->orderBy($orderEntity, $orderAction)->toSql());
            return $this->whereRaw($filter)
                ->orderBy($orderEntity, $orderAction)
                ->get($fields);
        }
        return null;
    }

    public function filterGroupOPDVisits($search = [])
    {
        $fields = [
            'department','total'
        ];
        unset($search['department']);

        $filter = $this->getFilters($search);
        
        $orderEntity = 'visit_date';
        $orderAction = 'desc';

        if (isset($search['form-search']))
        {
            
                    
            
            // dd($this->select('department', \DB::raw('count(*) as total'))
            //             ->whereRaw($filter)
            //             ->groupBy('department')
            //             ->toSql());
            return $this->select('department', 'flag',\DB::raw("sum(replace(flag,'new',1)) as newp , sum(replace(flag,'old',1)) as oldp"))
                        ->whereRaw($filter)
                        ->groupBy('department')
                        //->groupBy('flag')
                        ->get();
        }
        return null;
    }


    /**
     * Method is used to get total results.
     * @param array $search
     * @return mixed
     */
    public function totalOPDVisits($search = [])
    {
        // when search
        $filter = $this->getFilters($search);

        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)
            ->first();
    }
}