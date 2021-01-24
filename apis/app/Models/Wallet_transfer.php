<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  
class Wallet_transfer extends Model {

	protected $table = 'wallet_transfer';
	protected $primaryKey = 'id';

	protected $fillable = ['*'];
	public $timestamps = false;
}
