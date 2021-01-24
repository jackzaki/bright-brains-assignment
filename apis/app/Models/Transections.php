<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class Transections extends Model {

	protected $table = 'transections';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
