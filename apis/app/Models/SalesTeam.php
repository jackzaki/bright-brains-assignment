<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class SalesTeam extends Model {

	protected $table = 'sales_team';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
