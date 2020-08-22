<?php
namespace App;
/**
 * :: View IPD Patient Model ::
 * To manage View OPD Patient CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;

class ViewIPDPatients extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'view_ipd_patients';

    public function getFilters($search = [])
    {
        $filter = 1; // default filter if no search
        $fromTo = "";
        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('doctor', $search) && $search['doctor'] != "") ? " AND (doctor_id = " .
                addslashes(trim($search['doctor'])) . ")" : "";


            $filter .= (array_key_exists('department', $search) && $search['department'] != "") ? " AND (department_id = " .
                addslashes(trim($search['department'])) . ")" : "";

            $filter .= (array_key_exists('patient_name', $search) && $search['patient_name'] != "") ? " AND (first_name LIKE '%" .
                addslashes(trim($search['patient_name'])) . "%')" : "";

            $filter .= (array_key_exists('patient_code', $search) && $search['patient_code'] != "") ? " AND (patient_id LIKE '%" .
                addslashes(trim($search['patient_code'])) . "%')" : "";

            $filter .= (array_key_exists('ipd_number', $search) && $search['ipd_number'] != "") ?
                " AND (ipd_number LIKE '%" . addslashes(trim($search['ipd_number'])) . "%') " : "";

            


            if(!array_key_exists('is_discharged', $search)) // is_discharged=0 //Admissions
            {
                if (array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                    array_key_exists('to_date', $search) && $search['to_date'] != "" && $search['report_type'] == '1'
                        )
                {
                    $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
                    $to = dateFormat("Y-m-d", $search['to_date'] . ' 23:59');
                    $filter .= " AND (admission_dt between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";
                }
            }
            elseif(array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                    array_key_exists('to_date', $search) && $search['to_date'] != "" && $search['report_type'] == '1'
                    ) // Discharge OR On ROlls
            {
                if($search['is_discharged'] ==1) // Discharged
                {
                    $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
                    $to = dateFormat("Y-m-d", $search['to_date'] . ' 23:59');
                    $filter .=  " AND (is_discharged = " . addslashes(trim($search['is_discharged'])) . ")";
                    $filter .= " AND (discharge_dt between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";
                }
                elseif($search['is_discharged']==2) // On Rolls 
                {
                    $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
                    $to = dateFormat("Y-m-d", $search['to_date'] . ' 23:59');
                    $filter .= " AND admission_dt < '$to' ";
                    $filter .= " AND ( discharge_dt = '0000-00-00' or discharge_dt >= '$to')";

                }
            }



/*
            if (array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                array_key_exists('to_date', $search) && $search['to_date'] == "") // Only From Date Given
            {
                $date = dateFormat("Y-m-d", $search['from_date']);
                $filter .=  " AND (admission_dt >= '" . addslashes(trim($date)) . "')";
            }
            if(array_key_exists('is_discharged', $search) && $search['is_discharged'] != "") // Other than Admissions
            {
                if($search['is_discharged'] ==2) // On Rolls
                {
                    $filter .= " AND discharge_dt = '0000-00-00'";
                }
                else // Discharged
                    $filter .=  " AND (is_discharged = " . addslashes(trim($search['is_discharged'])) . ")";

                if (array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                    array_key_exists('to_date', $search) && $search['to_date'] != "" && $search['report_type'] == '1'
                    )
                {
                    $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
                    $to = dateFormat("Y-m-d", $search['to_date'] . ' 23:59');
                    $filter .= " AND (discharge_dt between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";
                }
            }
            else if (array_key_exists('from_date', $search) && $search['from_date'] != "" &&
                array_key_exists('to_date', $search) && $search['to_date'] != "" && $search['report_type'] == '1'
                    )
            {
                $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
                $to = dateFormat("Y-m-d", $search['to_date'] . ' 23:59');
                $filter .= " AND (admission_dt between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";
            }

*/





        }
        //dd($filter);
        return $filter;
    }

    /**
     * Method is used to search news detail.
     *
     * @param array $search
     * @return mixed
     */
    public function filterIPDPatients($search = [])
    {
        $fields = [
            '*',
        ];

        $filter = $this->getFilters($search);

        $orderEntity = 'admission_dt';
        $orderAction = 'asc';

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

    public function filterGroupIPDPatients($search = [])
    {
        $fields = [
            '*',
        ];

        $filter = $this->getFilters($search);

        $orderEntity = 'admission_dt';
        $orderAction = 'desc';

        if (isset($search['form-search']))
        {
            


            // dd($this->select('department', \DB::raw('count(*) as total'))
            //             ->whereRaw($filter)
            //             ->groupBy('department')
            //             ->toSql());

            return $this->select('department', \DB::raw('count(*) as total'))
                        ->whereRaw($filter)
                        ->groupBy('department')
                        ->get();



        }
        return null;
    }




    /**
     * Method is used to get total results.
     * @param array $search
     * @return mixed
     */
    public function totalIPDPatients($search = [])
    {
        // when search
        $filter = $this->getFilters($search);

        return $this->select(\DB::raw('count(*) as total'))
            ->whereRaw($filter)
            ->first();
    }

    /**
     * @param array $search
     * @return \Illuminate\Support\Collection|null
     */
    public function bedOccupancySummary($search = [])
    {
        $fields = [
            'department',
            'department_id',
            \DB::raw("SUM(IF(is_discharged = 0, 1, 0)) AS occupied"),
            \DB::raw("SUM(IF(is_discharged = 1, 1, 0)) AS discharged"),
        ];

        $filter = $this->getFilters($search);
    
        if (isset($search['form-search']))
        {
            $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
            $to = dateFormat("Y-m-d H:i", $search['to_date'] . ' 23:59');
            $dfilter = "1 AND (discharge_dt between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";

            $afields = [
                            //'department_id',
                            'department',
                            \DB::raw("count(*) as admissions")
            ];

            $dfields = [
                            //'department_id',
                            'department',
                            \DB::raw("count(*) as discharges")
            ];

            $adm = $this->whereRaw($filter)
                        ->groupBy('department_id')                        
                        ->get($afields)
                        ->toArray();
            
            $dis = $this->whereRaw($dfilter)
                        ->groupBy('department_id')                        
                        ->get($dfields)
                        ->toArray();

            $boFields = [
                        'department',
                        \DB::raw("sum(datediff(
                            if(discharge_dt = '0000-00-00' or discharge_dt > '$to','$to',discharge_dt),
                            if(admission_dt < '$from','$from',admission_dt))
                            +
                            if(discharge_dt = '0000-00-00' or discharge_dt > '$to',1,0)) as beds")
            ];

            // $boDetailFields = [
            //             'first_name','department','is_discharged','admission_dt','discharge_dt',
            //             \DB::raw("datediff(
            //                 if(discharge_dt = '0000-00-00' or discharge_dt > '$to','$to',discharge_dt),
            //                 if(admission_dt < '$from','$from',admission_dt) + 1) as bedsinMonth")
            // ];




            // dd($this->whereRaw("(admission_dt < '$from' and discharge_dt >= '$from')
            //                         or (admission_dt < '$from' and is_discharged=0)
            //                         or (admission_dt between '$from' and '$to')")
            //             ->groupBy('department_id')
            //             ->toSql());



            $bo = $this->whereRaw("(admission_dt < '$from' and discharge_dt >= '$from')
                                    or (admission_dt < '$from' and is_discharged=0)
                                    or (admission_dt between '$from' and '$to')")
                        ->groupBy('department_id')
                        ->get($boFields)
                        ->toArray();    
            
            // $boDetails = $this->whereRaw("(admission_dt between '$from' and '$to') 
            //                         or (admission_dt < '$from' and is_discharged=0)")
            //             ->groupBy('department_id')
            //             ->get($boDetailFields)
            //             ->toArray();    


            
            $arr = array();

            foreach ($adm as $key => $detail) {
                if(empty($detail['admissions']))
                    $detail['admissions'] = 0;

                $arr[$detail['department']]['occupied'] = $detail['admissions'];
                $arr[$detail['department']]['discharged'] = 0;
            }
            foreach ($dis as $key => $detail) {
                if(empty($detail['discharges']))
                    $detail['discharges'] = 0;

                $arr[$detail['department']]['discharged'] = $detail['discharges'];
                if(!isset($arr[$detail['department']]['occupied'])) 
                    $arr[$detail['department']]['occupied'] =0;
                $arr[$detail['department']]['total'] = $detail['discharges'] + $arr[$detail['department']]['occupied'];
            }

            foreach ($bo as $key => $detail) {
                $arr[$detail['department']]['bo'] = $detail['beds'];
            }
            // dd($arr);
            return json_decode(json_encode($arr),false);                        

        }
        return null;
    }

    /**
     * @param array $search
     * @return \Illuminate\Support\Collection|null
     */
    public function bedOccupancyDetail($search = [])
    {

        $filter = $this->getFilters($search);
    
        if (isset($search['form-search']))
        {
            $from = dateFormat("Y-m-d", $search['from_date'] . ' 00:00');
            $to = dateFormat("Y-m-d H:i", $search['to_date'] . ' 23:59');
            $dfilter = "1 AND (discharge_dt between '" . addslashes(trim($from)) . "' and '" . addslashes(trim($to)) . "') ";

            $boDetailFields = [
                        'first_name','department','is_discharged','admission_dt','discharge_dt',
                        \DB::raw("datediff(if(discharge_dt = '0000-00-00' or discharge_dt > '$to','$to',discharge_dt), if(admission_dt < '$from','$from',admission_dt)) 
                            + 
                            if(discharge_dt = '0000-00-00' or discharge_dt > '$to',1,0) as bedsinMonth")
            ];
            
            $boDetails = $this->whereRaw("(admission_dt < '$from' and discharge_dt >= '$from')
                                    or (admission_dt < '$from' and is_discharged=0)
                                    or (admission_dt between '$from' and '$to')")
                                ->select($boDetailFields)
                                ->orderBy('department')
                                ->get();    

            //dd($boDetails);

            return $boDetails;                        

        }
        return null;
    }    
}