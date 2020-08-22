<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;
use App\User;

class CommonController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword()
    {
        $changeRoute = true;
        $user = authUser();
        return view('admin.settings.change_password', compact('changeRoute', 'user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $inputs = $request->all();
        $validator = (new User)->validatePassword($inputs);
        if ($validator->fails()) {
            return validationResponse(false, 206, "", "", $validator->messages());
        }
        try {
            \DB::beginTransaction();

            $password = \Auth::user()->password;
            if(!(\Hash::check($inputs['password'], $password))){
                return validationResponse(false, 207, lang('messages.invalid_password'));
            }

            $newPassword = \Hash::make($inputs['new_password']);
            (new User)->updatePassword($newPassword, 1);

            \DB::commit();

            $route = route('dashboard');
            return validationResponse(true, 201, lang('messages.created', lang('messages.password_updated')), $route);

        } catch (\Exception $exception) {
            \DB::rollBack();
            return validationResponse(false, 207, $exception->getMessage().' '.lang('messages.server_error'));
        }
    }

    public function calculateAge(Request $request)
    {
        $inputs = $request->all();
        $validator = (new Common)->validateAge($inputs);
        if ($validator->fails()) {
            return json_encode(['success' => false, 'status' => 206, 'errors' => $validator->messages(), 'age' => 0]);
        }

        $age = ageCalculator($inputs['birthDate']);

        return json_encode(['success' => true, 'status' => 201, 'errors' => null, 'age' => $age]);
    }

    public function getDownload($fileName = null)
    {
        $filePath = ROOT . \Config::get('constants.UPLOADS');

        $file= $filePath.$fileName;
        return \Response::download($file, $fileName);
    }
}
