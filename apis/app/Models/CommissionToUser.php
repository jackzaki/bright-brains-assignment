<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class CommissionToUser extends Model {

	protected $table = 'commission_to_user';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
?>