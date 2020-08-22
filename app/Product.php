<?php

namespace App;
/**
 * :: Products Model ::
 * To manage products CRUD operations
 *
 **/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'product_name',
        'item_code',
        'product_code',
        'product_type_id',
        'product_group_id',
        'hsn_id',
        'unit_id',
        'tax_id',
        'company_id',
        'pn_number',
        'minimum_level',
        'reorder_level',
        'maximum_level',
        'alternate_quantity',
        'description',
        'size',
        'status',
        'opening_balance',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validateProducts($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        // if ($id) {
        //     $rules['product_code'] = 'required|unique:product,product_code,' . $id . ',id,deleted_at,NULL,company_id,' . loggedInHospitalId();
        // } else {
        //     $rules['product_code'] = 'required|unique:product,product_code,NULL,id,deleted_at,NULL,company_id,' . loggedInHospitalId();
        // }
        $rules['product_name'] = 'required';
        $rules['hsn_code'] = 'required|numeric';
        $rules['unit'] = 'required|numeric';
        $rules['cost'] = 'numeric';
        $rules['discount'] = 'numeric';
        $rules['tax_group'] = 'required|numeric';
        $rules['minimum_level'] = 'numeric';
        $rules['reorder_level'] = 'numeric';
        $rules['maximum_level'] = 'numeric';
        $rules['opening_balance'] = 'numeric';
        //$rules['alternate_quantity'] = 'numeric';

        return \Validator::make($inputs, $rules);
    }

    /**
     * @param $inputs
     * @return \Illuminate\Validation\Validator
     */
    public function validateProductExcel($inputs) 
    {
        $rules = [
            'file' => 'required',
        ];
        return \Validator::make($inputs, $rules);
    }

    /**
     * Scope a query to only include active users.
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('product.status', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCompany($query)
    {
        return $query->where('product.company_id', loggedInHospitalId());
    }

    /**
     * @param array $inputs
     * @param int $id
     * @return mixed
     */
    public function store($inputs, $id = null)
    {
        if ($id)
        {
            $this->find($id)->update($inputs);
            //Product Cost
            $costRates = (new ProductCost)->getEffectedCost(true, ['product' => $id]);
            if ($costRates)
            {
                $cost = $costRates->cost;
                if ($cost != $inputs['cost'])
                {
                    //update older rate
                    $inputs['status'] = 0;
                    $inputs['wet'] = convertToUtc();
                    $inputs['company_id'] = loggedInHospitalId();

                    (new ProductCost)->store($inputs, $costRates->id);
                    unset($inputs['wet']);

                    //add new rate
                    $inputs['status'] = 1;
                    $inputs['product_id'] = $id;
                    $inputs['wef'] = convertToUtc();
                    $inputs['company_id'] = loggedInHospitalId();
                    (new ProductCost)->store($inputs);

                }

            } else {
                //add new rate
                $inputs['status'] = 1;
                $inputs['product_id'] = $id;
                $inputs['wef'] = convertToUtc();
                $inputs['company_id'] = loggedInHospitalId();
                (new ProductCost)->store($inputs);
            }

            //Product Discount
            /*$discountRates = (new ProductDiscount)->getEffectedDiscount(true, ['product' => $id]);
            if ($discountRates)
            {
                $discount = $discountRates->discount;
                if (($discount != "" && $discount != $inputs['discount'])) {
                    //update older rate
                    $inputs['status'] = 0;
                    $inputs['wet'] = convertToUtc();
                    $inputs['company_id'] = loggedInHospitalId();

                    (new ProductDiscount)->store($inputs, $discountRates->id);
                    unset($inputs['wet']);

                    //add new rate
                    $inputs['status'] = 1;
                    $inputs['product_id'] = $id;
                    $inputs['wef'] = convertToUtc();
                    $inputs['company_id'] = loggedInHospitalId();
                    (new ProductDiscount)->store($inputs);
                }
            } else {
                //add new rate
                $inputs['status'] = 1;
                $inputs['product_id'] = $id;
                $inputs['wef'] = convertToUtc();
                $inputs['company_id'] = loggedInHospitalId();
                (new ProductDiscount)->store($inputs);
            }*/

        } else {
            //dd($inputs);
            $id = $this->create($inputs)->id;
            //Product Cost
            $inputs['product_id'] = $id;
            $inputs['company_id'] = loggedInHospitalId();
            $inputs['status'] = 1;
            $inputs['wef'] = convertToUtc();
            if(!empty($inputs['cost']) && $inputs['cost'] > 0) {
                (new ProductCost)->store($inputs);
            }
            //Product Discount
            /*if(!empty($inputs['discount'])){
                (new ProductDiscount)->store($inputs);
            }*/
            return $id;
        }
    }

    /**
     * @param $id
     */
    public function findByID($id)
    {
        return $this->where('id', $id)->company()->first();
    }

    /**
     * @param null $search
     * @param $skip
     * @param $perPage
     * @param null $id
     * @return mixed
     */
    public function getProducts($search = null, $skip, $perPage, $id = null)
    {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'product.id',
            'product_name',
            'product_code',
            'hsn_master.id as hsn_id',
            'hsn_master.hsn_code',
            'unit.id as unit_id',
            'unit.name as unit_name',
            'unit.code as unit',
            'tax.name as tax_group',
            'tax.id as tax_id',
            'product.status',
            'product.description',
        ];

        $orderEntity = 'product.product_name';
        $orderAction = 'asc';


        if (is_array($search) && count($search) > 0)
        {
            $filter .= (array_key_exists('keyword', $search) && $search['keyword'] != "") ? " AND (product_name LIKE '%" .
                addslashes($search['keyword']) . "%' OR product_code LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' OR item_code LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' OR hsn_code LIKE '%" .
                addslashes(trim($search['keyword'])) . "%')" : "";

            $filter .= (array_key_exists('product_group', $search) && $search['product_group'] != "") ? " AND (product_group_id = '" .
                addslashes($search['product_group']) . "')" : "";

        }

        if($id)
        {

            $fields = [
                'product.*',
                'hsn_master.id as hsn_id',
                'hsn_master.hsn_code',
                'unit.id as unit_id',
                'unit.name as unit_name',
                'unit.code as unit',
                'tax.name as tax_group',
                'tax.id as tax_id',
                'product_cost.cost',
                //'product_discount.discount',
                'product.status',
            ];

            return $this->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
                ->leftJoin('unit', 'unit.id', '=', 'product.unit_id')
                ->leftJoin('tax', 'tax.id', '=', 'product.tax_id')
                ->leftJoin('tax_rates', 'tax.id', '=', \DB::raw('tax_rates.tax_id and tax_rates.is_active = 1'))
                ->leftJoin('product_cost', function($join){
                    $join->on('product_cost.product_id', '=', 'product.id');
                    $join->on('product_cost.status', '=', \DB::raw("1"));
                })
                /*->leftJoin('product_discount', function($join){
                    $join->on('product_discount.product_id', '=', 'product.id');
                    $join->on('product_discount.status', '=', \DB::raw("1"));
                })*/
                ->company()
                //->active()
                ->where('product.id', $id)
                ->first($fields);
        } else {
             return $this->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
                ->leftJoin('unit', 'unit.id', '=', 'product.unit_id')
                ->leftJoin('tax', 'tax.id', '=', 'product.tax_id')
                ->whereRaw($filter)
                ->company()
                //->active()
                ->orderBy($orderEntity, $orderAction)
                ->skip($skip)->take($take)->get($fields);
        }
    }

    /**
     * Method is used to get total products.
     * @param array $search
     * @return mixed
     */
    public function totalProducts($search = null)
    {
        $filter = 1; // if no search add where

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('keyword', $search) && $search['keyword'] != "") ? " AND (product_name LIKE '%" .
                addslashes($search['keyword']) . "%' OR product_code LIKE '%" .
                addslashes(trim($search['keyword'])) . "%' OR hsn_code LIKE '%" .
                addslashes(trim($search['keyword'])) . "%')" : "";

            $f3 = (array_key_exists('product_group', $search) && $search['product_group'] != "") ? " AND (product_group_id = '" .
                addslashes($search['product_group']) . "')" : "";

            $filter .= $f1 . $f3;
        }
        return $this->select(\DB::raw('count(*) as total'))
            ->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
            ->whereRaw($filter)
            ->company()
            ->active()
            ->first();
    }

    /**
     * @param array $search
     * @return mixed
     */
    public function getProductsService($search = [])
    {
        $filter = 1;
        if (is_array($search) && count($search) > 0)
        {
            $f1 = (array_key_exists('type_id', $search)) ? " AND (product_type_id IN (" .
                implode(',', $search['type_id']) . "))" : "";

            $f2 = (array_key_exists('t', $search) && $search['t'] != "") ? " AND (product_name LIKE '%" .
                addslashes(trim($search['t'])) . "%' OR product_code LIKE '%" .
                addslashes(trim($search['t'])) . "%' OR hsn_code LIKE '%" .
                addslashes(trim($search['t'])) . "%')" : "";
            $filter .= $f1 . $f2;
        }

        $fields = [
            'product.id',
            'product.product_name',
            'unit.code as unit',
            'hsn_master.hsn_code as hsn_code',
            'product_group.name as product_group_name',
        ];
        $data = $this->active()->company()
                ->leftJoin('product_group', 'product_group.id', '=', 'product.product_group_id')
                ->leftJoin('unit', 'unit.id', '=', 'product.unit_id')
                ->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
                ->whereRaw($filter)
                ->orderBy('product_name', 'ASC');

        if (isset($search['h']) && $search['h'] == 1) {
            $data->groupBy('product.hsn_id');
        }
        $data = $data->get($fields);
        $result = [];
        if (isset($search['h']) && $search['h'] == 1) {
            foreach ($data as $detail) {
                $result[$detail->id] = $detail->hsn_code;
            }
        } else {
            foreach ($data as $detail) {
                //$result[$detail->id] = $detail->product_group_name . ' --> ' . $detail->product_name . ' (' . $detail->unit . ')';
                $result[$detail->id] = $detail->product_name . '(' . $detail->product_group_name . ',' . $detail->unit . ')';
            }
        }
        return ['' => '-Select Medicine-'] + $result;
    }

    /**
     * @param $id
     * @return bool
     */
    public function productGroupExists($id)
    {
        $result  = $this->where('product_group_id', $id)->company()->first();
        if(count($result) > 0) {
            return true;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function productInUse($id)
    {
        $productExistsInSaleOrderItem = (new SaleOrderItem)
            ->leftJoin('product', 'product.id', '=','sale_order_items.product_id')
            ->leftJoin('sale_order', 'sale_order.id', '=','sale_order_items.sale_order_id')
            ->where('sale_order_items.product_id',$id)
            ->where('product.company_id', loggedInHospitalId())
            ->whereNull('sale_order.deleted_at')
            ->first();
        $productExistsInPurchaseOrderItem =(new SupplierOrderItems)
            ->leftJoin('product', 'product.id', '=', 'supplier_order_items.product_id')
            ->leftJoin('supplier_order', 'supplier_order.id', '=', 'supplier_order_items.supplier_order_id')
            ->where('supplier_order_items.product_id',$id)
            ->where('product.company_id', loggedInHospitalId())
            ->whereNull('supplier_order.deleted_at')
            ->first();
        if(count($productExistsInSaleOrderItem) > 0 || count($productExistsInPurchaseOrderItem) > 0)
        {
            return true;
        }
    }

    /**
     * @param $id
     */
    public function drop($id)
    {
        $this->find($id)->update(['deleted_by' => authUserId(), 'deleted_at' => convertToUtc()]);
    }

    /**
     * @return null
     */
    public function getProductDetail()
    {
        $fields = [
            'product.id',
            'product.product_name',
            'product.product_code',
            'hsn_master.hsn_code',
            'unit.name as unit_name',
            'tax.name as tax',
            'product_cost.cost',
            //'product_discount.discount',
            'product.minimum_level',
            'product.reorder_level',
            'product.maximum_level',
            'product.description',
            'tax_rates.cgst_rate',
            'tax_rates.sgst_rate',
            'tax_rates.igst_rate'
        ];
        $filter = 1;
        return $this->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
            ->leftJoin('unit', 'unit.id', '=', 'product.unit_id')
            ->leftJoin('product_cost', 'product_cost.product_id', '=', 'product.id')
            //->leftJoin('product_discount', 'product_discount.product_id', '=', 'product.id')
            ->leftJoin('tax', 'tax.id', '=', 'product.tax_id')
            ->leftJoin('tax_rates', 'tax_rates.tax_id', '=', \DB::raw('product.tax_id and tax_rates.is_active = 1'))
            ->whereRaw($filter)
            ->company()
            ->active()
            ->get($fields);
    }

    /**
     * Method is used to find Product Code.
     * @param string $search
     * @return id
     */
    public function findProductCode($search = '')
    {
        $filter = '';
        if ($search != '') {
            $filter = "product_code LIKE '" . $search . "' ";
            return $this->whereRaw($filter)
                ->company()
                ->first();
        }
        return false;
    }

    /**
     * @param $id
     * @param $date
     * @return mixed
     */
    public function getProductEffectedTax($id, $date)
    {
        return $this->leftJoin('tax', 'tax.id', '=', 'product.tax_id')
            ->leftJoin('tax_rates', 'tax.id', '=', \DB::raw('tax_rates.tax_id'))
            ->where('product.id', $id)
            ->where(function($query) use ($date) {
                $query->where(function($inner) use ($date) {
                    $inner->where('wef', '<=', $date)
                        ->where('wet', '>=', $date);
                });
                $query->oRWhere(function($inner) use ($date) {
                    $inner->where('wef', '<=', $date)
                        ->whereNull('wet');
                });
            })->first(['tax_rates.*']);
    }

    /**
     * @param array $search
     * @return bool
     */
    public function getFilteredProduct($search = [])
    {
        $filter = '';
        if ($search != '') {
            $filter = 1;
            if (is_array($search) && count($search) > 0) {
                $filter .=  (array_key_exists('tax', $search) && $search['tax'] != "") ?
                    " AND tax_id = '" . $search['tax'] . "'" : "";
            }
            return $this->active()->company()->whereRaw($filter)
                ->first(['id','product_name', 'product_code']);
        }
        return false;
    }

    /**
     * @param array $inputs
     * @return mixed
     */
    public function productCreate($inputs = [])
    {
        $inputs['company_id'] = loggedInHospitalId();
        $inputs['created_by'] = authUserId();
        $inputs['status'] = 1;
        $hsnId = (new HsnCode)->createHsnCode($inputs);

        $result = $this->where('product_name', $inputs['product_name'])
            ->where('unit_id', $inputs['unit_id'])
            ->first();

        if ($result) {
            $rs['hsn_id'] = ($hsnId != "") ? $hsnId : 0;
            $rs['product_id'] = $result->id;
            return $rs;
        }

        $inputs['hsn_id'] = $hsnId;
        $inputs['product_group_id'] = 178;

            $id = $this->create($inputs)->id;
            $rs['hsn_id'] = $hsnId;
            $rs['product_id'] = $id;
            return $rs;
    }

    /**
     * @param array $search
     * @return array
     */
    public function ajaxProduct($search = [])
    {
        $fields = [
            'product.id',
            'product.product_name',
            'unit.code as unit',
            'hsn_master.hsn_code as hsn_code',
            'product_group.name as product_group_name',
        ];
        $filter = 1;
        $json = [];

        if (is_array($search) && count($search) > 0 && isset($search['keyword']) && $search['keyword'] != '')
        {
            $filter .= " and (product.product_name like '%" . addslashes($search['keyword']) .
                "%' or product_group.name like '%" . addslashes($search['keyword']) . "%' 
                or hsn_master.hsn_code like '%" . addslashes($search['keyword']) . "%')";

            $result = $this->active()
                ->leftJoin('product_group', 'product_group.id', '=', 'product.product_group_id')
                ->leftJoin('unit', 'unit.id', '=', 'product.unit_id')
                ->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
                ->where('product.company_id', loggedInHospitalId())
                ->whereRaw($filter);

                if (isset($search['h']) && $search['h'] == 1) {
                    $result->groupBy('product.hsn_id');
                }
                $result = $result->get($fields);

                if (isset($result) && count($result) > 0)
                {
                    if (isset($search['h']) && $search['h'] == 1) {
                        foreach ($result as $key => $value) {
                            $json[] = [
                                'id' => $value->id,
                                'text' => $value->hsn_code,
                            ];
                        }
                    } else {
                        foreach ($result as $key => $value) {
                            $json[] = [
                                'id' => $value->id,
                                'text' => $value->product_group_name . ' --> ' . $value->product_name . ' (' . $value->unit . ')',
                            ];
                        }
                    }
                }
        }
        return $json;
    }

    /**
     * @param array $productIds
     * @return \Illuminate\Support\Collection
     */
    public function getProductsByIds($productIds = [])
    {
        $fields = [
            'product.id',
            'product.product_name',
            'unit.code as unit',
            'hsn_master.hsn_code as hsn_code',
            'product_group.name as product_group_name',
        ];

        return $this->leftJoin('product_group', 'product_group.id', '=', 'product.product_group_id')
            ->leftJoin('unit', 'unit.id', '=', 'product.unit_id')
            ->leftJoin('hsn_master', 'hsn_master.id', '=', 'product.hsn_id')
            ->where('product.company_id', loggedInHospitalId())
            ->whereIn('product.id', $productIds)
            ->get($fields);
    }
}