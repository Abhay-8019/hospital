<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    /**
     * Method is used to validate roles
     *
     * @param int $id
     * @return Response
     **/
    public function validateAge($inputs, $id = null)
    {
        // validation rule
        if ($id) {
            $rules['birthDate'] =  'date';
        } else {
            $rules['birthDate'] =  'date';
        }
        return \Validator::make($inputs, $rules);
    }
}
