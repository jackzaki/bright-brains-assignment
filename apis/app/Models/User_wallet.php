<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class User_wallet extends Model {

	protected $table = 'user_wallet';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
