<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class Coupon extends Model {

	protected $table = 'coupon';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
