<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class Payment_transfer extends Model {

	protected $table = 'payment_transfer';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
