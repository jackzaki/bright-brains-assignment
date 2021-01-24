<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Helpers\Commons;

class SuperadminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => [
            'list',
            'update',
            'delete',
            'wallet',
            'transection',
            'profile_image',
            'changePassword',
            
        ]]);   
    }

    public function list(Request $request) {
        $user       =   $request->auth;
        
        $global     =   Commons::global_filter($request->input('filter'));
        $type       =   $request->input('type');
        $route      =   $request->input('route');
        $skip       =   "0";
        $take       =   "500";
        $sort_column=   "username";
        $sort_order =   "Asc";
        
        if(!empty($request->input('skip'))) { $skip = $request->input('skip'); }
        if(!empty($request->input('take'))) { $take = $request->input('take'); }
        if(!empty($request->input('sort_column'))) { $sort_column = $request->input('sort_column'); }
        if(!empty($request->input('sort_order'))) { $sort_order = $request->input('sort_order'); }

        $query  =   DB::table('admin');
        
        if($request->input('id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($request->input('user_id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($global){
            $query->where(function ($query) use ($global) { 
            $query->ORwhere('username','LIKE','%'.$global.'%');
            });
        }else{      
            Commons::filtering($request->input('filter'), $query, 'list');
        }       
        
        Commons::sorting($sort_column, $sort_order, $request->input('sort'), $query);
        $response['records'] =  $query->count();

        $data  =  $query->skip($skip)->take($take)->get();  
        foreach($data as $rec){ 
            $response['data'][]=[           
                'id'            =>   $rec->uniquecode,
                'creationdate'  =>   Commons::datetimeformat($rec->creationdate),
                'name'       =>   $rec->username,
                'email'       =>   $rec->email,
                'profile_pic' =>   $rec->profile_pic,
                'gender'       =>   $rec->gender
            ];

        }
        return Commons::response(@$response);  
    }

    public function update(Request $request){
        $user   =   $request->auth;;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'required'
        ]);
        
        if($validator->fails()) { return Commons::failed($validator->errors(), $user, $request->path()); 
        }else {    
                $update = [ 
                    'username'    =>   $request->input('name'),
                    'profile_pic'    =>   $request->input('profile_pic')
                ];
                Admin::where('uniquecode', $request->input('id'))->update($update);
                return Commons::success('', $user, $request->path());
        }
    }

    // // Change password // 
    public function changePassword(Request $request) {
        $user       =   $request->auth;
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required',
            'id' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path()); 
        }else { 
            
            if( $request->input('new_password') !=  $request->input('confirm_new_password') ){
                return response()->json([
                    'status' => False,
                    'message' => 'New password and Confirm password mismatched.'
                ], 400);
            }

            $user = Admin::where('uniquecode', $request->input('id'))->first();
            if (!$user) {
                return response()->json([
                    'status' => False,
                    'message' => 'Admin does not exist.'
                ], 400);
            }
            
            if (Hash::check($request->input('password'), $user->password)) {
                if($user->status == "Inactive") {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Your account is Inactive.'
                    ], 400);
                }
                else
                {
                    $update = ['password'    =>   app('hash')->make($request->input('new_password')) ];
                    Admin::where('uniquecode', $request->input('id'))->update($update);
                    return Commons::success('', $user, $request->path());
                }
            }
            else 
            {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Password not matched.'
                ], 400);
            }
               
        }

    }
   
    //====Authenticate====//
    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        $user = Admin::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'status' => False,
                'message' => 'Email does not exist.'
            ], 400);
        }
        
        if (Hash::check($request->input('password'), $user->password)) {
                return response()->json([
                    'status' => TRUE,
                    'token' => $this->jwt($user),
                    'user_id' => $user->uniquecode,
                    'username' => $user->username,
                    'profile' => $user->profile_pic,
                    'gender' => $user->gender
                ], 200);
                
            
        }
        // Bad Request response
        return response()->json([
            'status' => FALSE,
            'message' => 'Email or password is wrong.'
        ], 400);
    }

    //====jwt token====//
    protected function jwt(Admin $user) {

        $payload = [
            'iss'   =>  "lumen-jwt", // Issuer of the token
            'sub'   =>  $user->id, // Subject of the token
            'iat'   =>  time(), // Time when JWT was issued.
            'exp'   =>  time() + 86400, // Expiration time second 24hours
            'type'  =>  "Superadmin" // User type
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function report(Request $request) {
        $user       =   $request->auth;
        
        $global     =   Commons::global_filter($request->input('filter'));
        $type       =   $request->input('type');
        $route      =   $request->input('route');
        $skip       =   "0";
        $take       =   "500";
        $sort_column=   "creationdate";
        $sort_order =   "Asc";
        DB::enableQueryLog();
        if(!empty($request->input('skip'))) { $skip = $request->input('skip'); }
        if(!empty($request->input('take'))) { $take = $request->input('take'); }
        if(!empty($request->input('sort_column'))) { $sort_column = $request->input('sort_column'); }
        if(!empty($request->input('sort_order'))) { $sort_order = $request->input('sort_order'); }

        $depositQuery  =   DB::table('deposit');
        $paymentQuery  =   DB::table('payment_transfer');
        $userQuery  =   DB::table('users');
        $commissionQuery  =   DB::table('commission');
        $commissionToUserQuery  =   DB::table('commission_to_user');
        $userWalletQuery  =   DB::table('user_wallet');
        $chargeQuery  =   DB::table('deposit');

        $depositQuery->select('currency',DB::raw('SUM(deposit_amount) AS total'));
        $paymentQuery->select('currency',DB::raw('SUM(amount) AS total'));
        $userQuery->select('status',DB::raw('COUNT(id) AS total'));
        $commissionQuery->select('currency','description',DB::raw('SUM(commission_amt) AS total'));
        $commissionToUserQuery->select('currency',DB::raw('SUM(amount) AS total'));
        $userWalletQuery->select('currency',DB::raw('SUM(amount) AS total'));
        $chargeQuery->select('currency',DB::raw('SUM(charge) AS total'));

        if($request->input('todate') && $request->input('fromdate')) {
            // deposit query
            $depositQuery->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $depositQuery->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            $depositQuery->where('status',"LIKE",'Approved');

            // payment query
            $paymentQuery->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $paymentQuery->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            $paymentQuery->where('status',"LIKE",'Approved');

            // user
            $userQuery->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $userQuery->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            //$userQuery->where('status',"LIKE",'Active');

            $commissionQuery->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $commissionQuery->where('creationdate', '<=', $request->input('todate')." 23:59:59");

            $commissionToUserQuery->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $commissionToUserQuery->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            //$paymentQuery->where('status',"LIKE",'Approved');
            
            $chargeQuery->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $chargeQuery->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            $chargeQuery->where('status',"LIKE",'Approved');
        }
        
        if($request->input('user_id')){
            $depositQuery->where('user_id',"LIKE",$request->input('user_id'));
            $paymentQuery->where('user_id',"LIKE",$request->input('user_id'));
            $commissionQuery->where('user_id',"LIKE",$request->input('user_id'));
            $commissionToUserQuery->where('user_id',"LIKE",$request->input('user_id'));
            $userWalletQuery->where('user_id',"LIKE",$request->input('user_id'));
            $chargeQuery->where('user_id',"LIKE",$request->input('user_id'));
        }

            
        $depositData  = $depositQuery->groupBy('currency')->get();
        $paymentData  = $paymentQuery->groupBy('currency')->get();
        $userData  = $userQuery->groupBy('status')->get();
        $commissionData  = $commissionQuery->groupBy('currency', 'description')->get();
        $commissionToUserData  = $commissionToUserQuery->groupBy('currency')->get();
        $userWalletData  = $userWalletQuery->groupBy('currency')->get();
        $chargeData  = $chargeQuery->groupBy('currency')->get();
    // dd(DB::getQueryLog());
        // dd($commissionToUserData);
       // print_r($commissionData);
         //exit;
            $response['data']=[           
                'deposit' => $depositData,
                'payment' => $paymentData,
                'user' => $userData,
                'commission' => $commissionData,
                'commission_to_user' => $commissionToUserData,
                'user_wallet' => $userWalletData,
                'charge' => $chargeData,
            ];

        return Commons::response(@$response);  
    }


}