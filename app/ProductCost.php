<?php
namespace App;
/**
 * :: Product Cost Model ::
 * To manage Tax CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCost extends Model
{/**
 * The database table used by the model.
 *
 * @var string
 */
    protected $table = 'product_cost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'company_id',
        'cost',
        'wef',
        'wet',
        'status'
    ];

    public $timestamps = false;

    /**
     * Scope a query to only include active users.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    /**
     * 
     * @param type $query
     * @return type
     */
    public function scopeCompany($query)
    {  
        return $query->where('product_cost.company_id', loggedInHospitalId());  
    }
    

    /**
     * @param $input
     * @param null $id
     * @return mixed
     */
    public function store($input, $id = null)
    {
        if ($id) {
            unset($input['cost']);
            unset($input['wef']);
            return $this->find($id)->update($input);
        } 
        else {
            return $this->create($input)->id;
        }
    }

    /**
     * @param bool $active
     * @param array $search
     * @return mixed
     */
    public function getEffectedCost($active = true, $search = [])
    {
        $filter = 1;
        if (is_array($search) && count($search) > 0)
        {
            $tax = (array_key_exists('product', $search)) ? " AND product_id = '" .
                addslashes(trim($search['product'])) . "'" : "";
            $filter .= $tax;

            $from = (array_key_exists('from', $search)) ? " AND wef = '" .
                addslashes(trim($search['from'])) . "' " : "";
            $filter .= $from;
        }

        if ($active)
        {
            $active = " AND status = 1";
            $filter .= $active;
        }
        return $this->whereRaw($filter)->company()->first();
    }


    /**
     * @param $id
     * @param $date
     * @return mixed
     */
    public function getEffectedCostRate($id, $date)
    {
        return $this->where('product_id', $id)->company()
            ->where(function($query) use ($date) {
                $query->where(function($inner) use ($date) {
                    $inner->where('wef', '<=', $date)
                        ->where('wet', '>=', $date);
                });
                $query->oRWhere(function($inner) use ($date) {
                    $inner->where('wef', '<=', $date)
                        ->whereNull('wet');
                });
            })->first();
    }

    /**
     * @param $inputs
     */
    public function uploadProductCost($inputs)
    {
        $costId = $inputs['cost_id'];
        $result = $this->company()->where('id', $costId)->first();

        if($result && (float)$result->cost != (float)$inputs['cost']) {
            // update product cost
            $update = [
                'wet' => convertToUtc(),
                'status' => 0
            ];
            $result->update($update);
            // create product cost
            $create = [
                'product_id' => $result->product_id,
                'company_id' => loggedInCompanyId(),
                'cost' => $inputs['cost'],
                'wef' => convertToUtc(),
                'wet' => null,
                'status' => 1,
            ];
            $this->create($create);
        }
    }
}

