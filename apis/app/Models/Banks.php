<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class Banks extends Model {

	protected $table = 'banks';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
