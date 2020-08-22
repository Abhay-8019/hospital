<?php

/**
 * :: Db Functions File ::
 * USed for manage all kind database related helper functions.
 *
 **/
use App\AddTest;
use App\User;
use App\Menu;

/**
 * @return null
 */
function loggedIncompanyId()
{
    /*return 1;*/
    $user = authUser();
    return ($user->company_id != '' && $user->company_id != 0)? $user->company_id : null;
}
/**
 * @return bool
 */
function isSuperAdmin()
{
    return (\Auth::user()->role_id == 1 && 	\Auth::user()->is_super_admin == 1) ? true : false;
}

/**
 * @return bool
 */
function isAdmin()
{
    return (\Auth::user()->role_id == 2 && \Auth::user()->is_admin == 1) ? true : false;
}

/**
 * @return bool
 */
function isDoctor()
{
    return (\Auth::user()->role_id == 3) ? true : false;
}

/**
 * @return bool
 */
function isStaff()
{
    return (\Auth::user()->role_id == 4) ? true : false;
}

/**
 * @return bool
 */
function isLab()
{
    return (\Auth::user()->role_id == 6) ? true : false;
}

/**
 * @return bool
 */
function isSystemAdmin()
{

    return (\Auth::user()->id == 1) ? true : false;
}
/**
 * @return bool
 */
function isMember()
{
    return null;
    //return (\Auth::user()->id == 1) ? true : false;
}

/**
 * @return null
 */
function authUserId()
{
    $id = true; // null
    if (\Auth::check()) {
        $id = \Auth::user()->id;
    }
    return $id;
}

/**
 * @return null
 */
function authUser()
{
    $user = null;
    if (\Auth::check()) {
        $user = \Auth::user();
    }
    return $user;
}

/**
 * @return null
 */
function getcompanyInfo()
{
    $company = null;
    if(loggedIncompanyId() != '') {
       $companyId = loggedIncompanyId();
       $company = company::find($companyId);
    }
    return $company;
}

/**
 * @param array $search
 * @return \Illuminate\Database\Eloquent\Model|null|statics
 */
function getTestName($search = [])
{
    return (new AddTest)->getTestName($search);
}

/**
 * @return string
 */
function regexIsAlphaSpaces()
{
	$regex = '/(^[A-Za-z ]+$)+/';

	return $regex;
}
/**
 * @return string
 */
function regexIsDecimal()
{
	$regex = '/^([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)$/';

	return $regex;
}

/**
 * @return string
 */
function validWebSiteRegex()
{
    return '/^([a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+.*)$/';
}

/**
 * @param $menuRute
 * @return bool
 */
function hasMenuRoute($menuRute)
{
    /*return true;*/
    if (authUser() && (isSuperAdmin() || isAdmin())) { //authUser()->id == 1
        return true;
    } else {
        $permissionResult = getUserPermission();
        return (in_array($menuRute, $permissionResult)) ? true : false;
    }
}

/**
 * @return array
 */
function renderMenu()
{
    return (new Menu)->getMenuNavigation(true, true, false);
}