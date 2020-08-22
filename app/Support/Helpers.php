<?php 
/**
 * :: Helper File :: 
 * USed for manage all kind of helper functions.
 *
 **/
use Illuminate\Support\Facades\Input;
/**
 * Method is used to debug statements.
 *
 * @param array $post
 * @param int $die
 * @return Response
 */
function debug($post, $die = 0)
{
    echo '<pre>'; print_r($post);
    ($die == 1) ? die : '';
}

/**
 * Trim whitespace from inputs 
 *
 * @return bool
 */
function trimInputs()
{
    $inputs = Input::all();
    array_walk_recursive($inputs, function (&$value) {
        $value = trim($value);
    });
    Input::merge($inputs);
    return true;
}

/**
 * conversion utc time to country specific time zone depending upon which country user is belong to
 *
 * @param $utcDate
 * @param string $format
 * @return bool|string
 */
function convertToLocal($utcDate, $format = null)
{
	$currentTimezone = 'Asia/Kolkata';
	$dateFormat = ($format != "") ? $format : 'Y-m-d H:i:s';
	if($currentTimezone !='') {
		$date = new \DateTime($utcDate, new DateTimeZone('UTC'));
		$date->setTimezone(new DateTimeZone($currentTimezone));
		return $date->format($dateFormat);
	} else {
		$date = new \DateTime($utcDate, new DateTimeZone('UTC'));
		return $date->format($dateFormat);
	}
}
/**
 * @param string $localDate
 * @param string $format
 * @return bool|string
 */
function convertToUtc($localDate = null, $format = null)
{
	$format = ($format == "") ? 'Y-m-d H:i:s' : $format;
	$localDate = ($localDate == "") ? date('Y-m-d H:i:s') : $localDate;
	$date = new \DateTime($localDate, new DateTimeZone('Asia/Kolkata'));
	$date->setTimezone(new DateTimeZone('UTC'));
	return $date->format($format);
}

function convertToTime($date = null, $intervalTime = null) {
    $val =  ($intervalTime != '')? strtotime("+".$intervalTime ."months", time($date)) : strtotime($date);
    return $val;
}

/**
 * @param bool $withTime
 * @return bool|string
 */
function currentDate($withTime = false)
{
	$date = date('Y-m-d H:i:s');
	if (!$withTime) {
		$date = date('Y-m-d');
	}
	return $date;
}

/**
 * Method is used to convert date to
 * specified format
 *
 * @param string $format
 * @param date $date
 *
 * @return Response|String
 */
function dateFormat($format, $date)
{
	if (trim($date) != '') {
		if (trim($date) == '0000-00-00' || trim($date) == '0000-00-00 00:00') {
			return null;
		} else {
			return date($format, strtotime($date));
		}
	}
	return $date;
}

/**
 * @param $fileName
 * @return string
 */
function getFileNumber($fileName) {
	$getNumber = substr($fileName, 0, 2);
	return $getNumber;
}

/**
 * @param $fileName
 * @return string
 */
function getFileName($fileName, $splitter = null, $arrayShift = false)
{
    $getName = null;
    if($fileName != '') {
        if($splitter) {
            $getArr = explode($splitter, $fileName);
        }else {
            $getArr = explode('__', $fileName);
        }
        //$getArr = array_filter($getArr);
        $getName = $getArr[1];
        if($arrayShift) {
           $shiftedArray =  array_shift($getArr);
           $getName = implode(' ', $getArr);
           $getName = ltrim($getName);
        }
    }
	return $getName;
}

/**
 * Method is used to get language phrases
 *
 * @param string $path
 * @param string $string
 * @return String
 **/
function lang($path = null, $string = null)
{
	$lang = $path;
	if (trim($path) != '' && trim($string) == '') {
		$lang = \Lang::get($path);
	} elseif (trim($path) != '' && trim($string) != '') {
		$lang = \Lang::get($path, ['attribute' => $string]);
	}
	return $lang;
}

/**
 * Method is used to return string in lower, upper or ucfirst.
 *
 * @param string $string
 * @param string $type L -> lower, U -> upper, UC -> upper character first
 * @return \Response
 */
function string_manip($string = null, $type = 'L')
{
    switch ($type) {
    	case 'U':
    		return strtoupper($string);
    		break;
    	case 'UC':
    		return ucfirst(strtolower($string));
    		break;
		case 'UCW':
			return ucwords($string);
			break;
    	default:
    		return strtolower($string);
    		break;
    }
}

/**
 * @param bool $status
 * @param int $statusCode
 * @param string $message
 * @param array $result
 *
 * @return \Illuminate\Http\JsonResponse
 */
function apiResponse($status, $statusCode, $message, $errors = [], $result = [])
{
	$response = ['success' => $status, 'status' => $statusCode];

	if ($message != "") {
		$response['message'] = $message;
	}

	if (count($errors) > 0) {
		$response['errors'] = $errors;
	}

	if (count($result) > 0) {
		$response['result'] = $result;
	}
	return response()->json($response, $statusCode);
}


/**
 * @param bool $status
 * @param int $statusCode
 * @param string $message
 * @param string $url
 * @param array $errors
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function validationResponse($status, $statusCode, $message = null, $url = null, $errors = [], $data = [])
{
	$response = ['success' => $status, 'status' => $statusCode];

	if ($message != "") {
		$response['message'] = $message;
	}

	if ($url != "") {
		$response['url'] = $url;
	}

	if (count($errors) > 0) {
		$response['errors'] = errorMessages($errors);
	}

	if (count($data) > 0) {
		$response['data'] = $data;
	}
	return response()->json($response, $statusCode);
}

/**
 * @param array $errors
 * @return array
 */
function errorMessages($errors = [])
{
    $error = [];
    foreach($errors->toArray() as $key => $value) {
        foreach($value as $messages) {
            $error[$key] = $messages;
        }
    }
    return $error;
}

/**
 * @param $path
 * @param $file
 * @param $id
 * @param null $oldImage
 * @return string
 */
function fileUploader($file, $id, $oldImage = null)
{
	$path = \Config::get('constants.UPLOADS');
	$folder = ROOT . $path;
	$fileName = $_FILES[$file]['name'];
	$newFile = str_replace(' ', '_', $fileName);
	$fileTempName = $_FILES[$file]['tmp_name'];

    if(!is_dir($folder)) {
        mkdir($folder, 0775);
    }
    if ($oldImage != "") {
        unlink($folder . $oldImage);
    }

	if(is_array($newFile)) {
		foreach($newFile as $key => $val)
		{
			if(move_uploaded_file($fileTempName[$key], $folder . $id  . '__'. $val)) {
				return $id  . '__'. $val;
			}
		}
	} else {
		if(move_uploaded_file($fileTempName, $folder . $id  . '__'. $newFile)) {
			return $id  . '__'. $newFile;
		}
	}
}

/**
 * Method is used to create pagination controls
 *
 * @param int $page
 * @param int $total
 * @param int $perPage
 *
 * @return string
 */
function paginationControls($page, $total, $perPage = 20)
{
	$paginates = '';
	$curPage = $page;
	$page -= 1;
	$previousButton = true;
	$next_btn = true;
	$first_btn = false;
	$last_btn = false;
	$noOfPaginations = ceil($total / $perPage);

	/* ---------------Calculating the starting and ending values for the loop----------------------------------- */
	if ($curPage >= 10) {
		$start_loop = $curPage - 5;
		if ($noOfPaginations > $curPage + 5) {
			$end_loop = $curPage + 5;
		} elseif ($curPage <= $noOfPaginations && $curPage > $noOfPaginations - 9) {
			$start_loop = $noOfPaginations - 9;
			$end_loop = $noOfPaginations;
		} else {
			$end_loop = $noOfPaginations;
		}
	} else {
		$start_loop = 1;
		if ($noOfPaginations > 10)
			$end_loop = 10;
		else
			$end_loop = $noOfPaginations;
	}

	$paginates .= '<div class="col-sm-5 padding0 pull-left">' .
					lang('common.jump_to') .
					'<input type="text" class="goto" size="1" />
					<button type="button" id="go_btn" class="go_button"> <span class="fa fa-arrow-right"> </span> </button> ' .
					lang('common.pages') . ' ' .  $curPage . ' of <span class="_total">' . $noOfPaginations . '</span> | ' . lang('common.total_records', $total) .
				    '</div> <ul class="pagination pagination-sm margin0 pull-right">';

	// FOR ENABLING THE FIRST BUTTON
	if ($first_btn && $curPage > 1) {
		$paginates .= '<li p="1" class="disabled">
	    					<a href="javascript:void(0);">' .
							lang('common.first')
							. '</a>
	    			   </li>';
	} elseif ($first_btn) {
		$paginates .= '<li p="1" class="disabled">
	    					<a href="javascript:void(0);">' .
								lang('common.first')
							. '</a>
	    			   </li>';
	}

	// FOR ENABLING THE PREVIOUS BUTTON
	if ($previousButton && $curPage > 1) {
		$pre = $curPage - 1;
		$paginates .= '<li p="' . $pre . '" class="_paginate">
	    					<a href="javascript:void(0);" aria-label="Previous">
					        	<span aria-hidden="true">&laquo;</span>
				      		</a>
	    			   </li>';
	} elseif ($previousButton) {
		$paginates .= '<li class="disabled">
	    					<a href="javascript:void(0);" aria-label="Previous">
					        	<span aria-hidden="true">&laquo;</span>
				      		</a>
	    			   </li>';
	}

	for ($i = $start_loop; $i <= $end_loop; $i++) {
		if ($curPage == $i)
			$paginates .= '<li p="' . $i . '" class="active"><a href="javascript:void(0);">' . $i . '</a></li>';
		else
			$paginates .= '<li p="' . $i . '" class="_paginate"><a href="javascript:void(0);">' . $i . '</a></li>';
	}

	// TO ENABLE THE NEXT BUTTON
	if ($next_btn && $curPage < $noOfPaginations) {
		$nex = $curPage + 1;
		$paginates .= '<li p="' . $nex . '" class="_paginate">
	    					<a href="javascript:void(0);" aria-label="Next">
					        	<span aria-hidden="true">&raquo;</span>
					      	</a>
	    			   </li>';
	} elseif ($next_btn) {
		$paginates .= '<li class="disabled">
	    					<a href="javascript:void(0);" aria-label="Next">
					        	<span aria-hidden="true">&raquo;</span>
					      	</a>
	    			   </li>';
	}

	// TO ENABLE THE END BUTTON
	if ($last_btn && $curPage < $noOfPaginations) {
		$paginates .= '<li p="' . $noOfPaginations . '" class="_paginate">
	    					<a href="javascript:void(0);">' .
								lang('common.last')
							. '</a>
	    			   </li>';
	} elseif ($last_btn) {
		$paginates .= '<li p="' . $noOfPaginations . '" class="disabled">
	    					<a href="javascript:void(0);">' .
								lang('common.last')
							. '</a>
			   		   </li>';
	}

	$paginates .= '</ul>';

	return $paginates;
}

/**
 * @param $value
 * @param bool|true $isRound
 * @return string
 */
function numberFormat($value, $isRound = true)
{
	$value = ($isRound == true)? round($value) : $value;
	return ($value > 0) ? number_format($value, 2, '.', ',') : '0.00';
}
/**
 * @param $index
 * @param $page
 * @param $perPage
 * @return mixed
 */
function pageIndex($index, $page, $perPage)
{
	return (($page - 1) * $perPage) + $index;
}

/**
 * @param $planNumber
 * @return mixed
 */
function number_inc($string)
{
	$number = substr($string, strrpos($string, '-') + 1);
	$incNumber = substr($string, strrpos($string, '-') + 1) + 1;
	$incNumber = paddingLeft($incNumber);
	return $text = str_replace($number, $incNumber, $string);
}
/**
 * PHP age Calculator
 *
 * Calculate and returns age based on the date provided by the user.
 * @param   date of birth('Format:yyyy-mm-dd').
 * @return  age based on date of birth
 */
function ageCalculator($dob)
{
	if(!empty($dob)){
		$birthDate = new DateTime($dob);
		$today   = new DateTime('today');
		$age = $birthDate->diff($today)->y;
		return $age;
	} else {
		return 0;
	}
}

/**
 * @param $number
 * @return bool|string
 */
function numberToWord($number) 
{
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . numberToWord(abs($number));
    }
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . numberToWord($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = numberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= numberToWord($remainder);
            }
            break;
    }
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return ucfirst($string);
}

/**
 * @param $array1
 * @param $array2
 * @return array
 */
function array_merge_keys($array1, $array2) {
    $keys = array_merge(array_keys($array1), array_keys($array2));
    $vals = array_merge($array1, $array2);
    return array_combine($keys, $vals);
}

/**
 * @param $number
 * @return string
 */
function paddingLeft($number)
{
	return str_pad($number, 2, "0", STR_PAD_LEFT);
}

/**
 * @param null $type
 * @return array|mixed
 */
function approvalStatus($type = null) 
{
	$types = [
		0 => 'Pending',
		1 => 'Approved',
		2 => 'Rejected'
 	];
 	if ($type != "") {
 		return $types[$type];
 	}
 	return $types;
}

/**
 * @param $action
 *
 * @return int
 */
function sortAction($action)
{
	$sortAction = 0;
	if($action != "") {
		if ($action == 0) {
			$sortAction = 1;
		} elseif ($action == 1) {
			$sortAction = 2;
		} else {
			$sortAction = 1;
		}
		//$sortAction = ((int)$action === 0) ? 1 : ((int)$action === 1) ? 2 : 3;
	}
	return $sortAction;
}

/**
 * @param $icon
 * @return mixed
 */
function sortIcon($icon)
{
	$iconArray = [
		'0' => 'fa fa-sort',
		'2' => 'fa fa-sort-up',
		'1' => 'fa fa-sort-down',
	];

	$icon = sortAction($icon);
	return $iconArray[$icon];
}

/**
 * @param null $type
 * @return array|mixed
 */
function getMonthDefaultValue($type = null)
{
	$typeArray = [
		4	=>	'Apr',
		5	=>	'May',
		6	=>	'Jun',
		7	=>	'Jul',
		8	=>	'Aug',
		9	=>	'Sep',
		10	=>	'Oct',
		11	=>	'Nov',
		12	=>	'Dec',
		1	=>	'Jan',
		2	=>	'Feb',
		3	=>	'Mar',
	];
	if ($type != "") {
		return $typeArray[$type];
	}
	return $typeArray;
}

/**
 * @param null $month
 * @return array
 */
function getMonths($month = null)
{

	$months = [
		1	=>	'January',
		2	=>	'February',
		3	=>	'March',
		4	=>	'April',
		5	=>	'May',
		6	=>	'June',
		7	=>	'July',
		8	=>	'August',
		9	=>	'September',
		10	=>	'October',
		11	=>	'November',
		12	=>	'December'
	];
	if ($month != "") {
		return $months[$month];
	}
	return ['' => '-Select Month-'] + $months;
}

/**
 * @param $start
 * @param $end
 * @param $reverse
 * @return array
 */
function getYear($start, $end, $reverse = false)
{
	$years = [];
	if($reverse) {
        for($i = $end; $i >= $start; $i--) {
            $years[$i] = $i;
        }
    }
    else {
        for($i =$start; $i <=$end; $i++) {
            $years[$i] = $i;
        }
	}
	return ['' => '-Select Year-'] + $years;

}

/**
 * this function is used to generate salary's overtime amount
 * @return int
 */
function getWorkingHour()
{
    $workingHour = 8;
    return $workingHour;
}
/**
 * @return bool
 */
function isDashBoard()
{
    $route = \Route::currentRouteName();
    return ($route == 'dashboard') ? true : false;
}

/**
 * @param $array
 * @return object
 */
function arrayToObject($array)
{
    return (object) $array;
}

/**
 * @param null $type
 * @return array|mixed
 */
function taxType($type = null)
{
	$types = [0 => 'Taxable', 1 => 'Zero Rated', 2 => 'Nil Rated & Exempted'];
	if ($type != "") {
		return $types[$type];
	}
	return $types;
}



/**
 * @param null $type
 * @return array|mixed
 */
function dischargeType($type = null)
{
	$types = [
		'' => '-Select Discharge Type-',
		0 => 'Zero',
		1 => 'Discharge Against Medical Advice',
		2 => 'Discharge at Request',
		3 => 'Advised Discharge',
		4 => 'Not Selected'
	];
	if ($type != "") {
		return $types[$type];
	}
	return $types;
}

/**
 * @param $date1
 * @param $date2
 * @return int
 */
function daysDiff($date1, $date2)
{
	if(!empty($date1))
	{
		$birthDate = new DateTime($date1);
		$date2   = new DateTime($date2);
		$diff = $birthDate->diff($date2)->days;
		return $diff;
	} else {
		return 0;
	}
}