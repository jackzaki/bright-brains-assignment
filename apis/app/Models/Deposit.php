<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class Deposit extends Model {

	protected $table = 'deposit';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
