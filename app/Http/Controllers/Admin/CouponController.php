<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Helpers;
use Config;
use Image;
use File;
use DB;
use Input;
use Redirect;
use Crypt;
use Response;
use Validator;
use Carbon;
use Session;
use Cache;
use \stdClass;
use DateTime;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Coupon;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->objCoupon = new Coupon();

        $this->loggedInUser = Auth::guard();
        $this->controller = 'CouponController';
    }

    /**
     * get all coupon in this variable $coupons
     * @param $coupons
     * @return object
     */

    public function index()
    {
        $coupons = $this->objCoupon->getAll();
        return view('admin.ListCoupon', compact('coupons'));
    }

    /**
     * Here coupon add and edit
     * @param \Illuminate\Http\Request $request
     * @param $postData
     * @return add and edit coupon object
     */

    public function save(Request $request)
    {
        $requestData = [];
        $postData = $request->all();

        $rules = [
            'coupon_name' => 'required|min:2|max:100',
            'description' => 'required',
            'vaild_from_datetime' => 'required|date_format:"Y-m-d H:i:s"',
            'vaild_until_datetime' => 'required|date_format:"Y-m-d H:i:s"',
            'coupon_amount' => 'numeric|required',
            'max_redeem' => 'numeric|required',
            'max_redeem_per_user' => 'numeric|required',
        ];

        if(isset($request->id) && $request->id > 0)
        {
            $rules['id'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        if($request->max_redeem_per_user > $request->max_redeem)
        {
            $error['errors']= [];
            $error['errors']['max_redeem_per_user'] = trans('labels.max_redeem_per_user_not_valid');
            return Response::json($error);
        }
        
        $vaild_from_datetime = new DateTime($request->vaild_from_datetime);
        $vaild_until_datetime = new DateTime($request->vaild_until_datetime);
               
        if($vaild_from_datetime && $vaild_until_datetime)
        {
            if($vaild_from_datetime >= $vaild_until_datetime)
            {
                $error['errors']= [];
                $error['errors']['vaild_from_datetime'] = trans('labels.vaild_from_datetime_not_valid');
                return Response::json($error);
            }
            elseif($vaild_until_datetime <= $vaild_from_datetime)
            {
                $error['errors']= [];
                $error['errors']['vaild_until_datetime'] = trans('labels.vaild_until_datetime_not_valid');
                return Response::json($error);
            }
        }        
        $requestData['id'] = (isset($postData['id']) && !empty($postData['id']) && $postData['id'] != 0) ? $postData['id'] : 0;

        $requestData['coupon_name'] = e(input::get('coupon_name'));
        $requestData['description'] = e(input::get('description'));
        $requestData['vaild_from_datetime'] = e(input::get('vaild_from_datetime'));
        $requestData['vaild_until_datetime'] = e(input::get('vaild_until_datetime'));
        $requestData['coupon_amount'] = e(input::get('coupon_amount'));
        $requestData['max_redeem'] = e(input::get('max_redeem'));
        $requestData['max_redeem_per_user'] = e(input::get('max_redeem_per_user'));

        $response = $this->objCoupon->insertUpdate($requestData);
        return response()->json($response);
    }

    /**
     * Here coupon delete
     * @param \Illuminate\Http\Request $request
     * @return delete coupon object
     */
    public function delete(Request $request)
    {
        $couponData = Coupon::findOrFail($request->id);
        $couponData->delete();
        return response()->json($couponData);
    }

}
