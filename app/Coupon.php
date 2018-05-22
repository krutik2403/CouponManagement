<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Config;

class Coupon extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coupon_name', 'description', 'vaild_from_datetime', 'vaild_until_datetime', 'coupon_amount', 'max_redeem', 'max_redeem_per_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Insert and Update Coupon
     */
    public function insertUpdate($data)
    {
        if (isset($data['id']) && $data['id'] != '' && $data['id'] > 0)
        {
            $coupon = Coupon::find($data['id']);
            $coupon->update($data);
            return Coupon::find($data['id']);
        }
        else
        {
            return Coupon::create($data);
        }
    }

    public function getAll($filters = array(), $paginate = false)
    {
        $getData = Coupon::whereNull('deleted_at')->orderBy('id', 'DESC');

        if(isset($filters) && !empty($filters))
        {
        }
        if(isset($paginate) && $paginate == true)
        {
            return $response = $getData->paginate(Config::get('constant.ADMIN_RECORD_PER_PAGE'));
        }
        else
        {
            return $response = $getData->get();
        }
    }

}
