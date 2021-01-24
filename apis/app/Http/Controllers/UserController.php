<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use App\Models\Test;
use App\Models\Users;
use App\Models\User_wallet;
use App\Models\Transections;
use App\Models\SalesTeam;
use App\Helpers\Commons;

class UserController extends Controller
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

    public function create(Request $request) {
        $user       =   $request->auth;
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'country_code' => 'required',
            'country' => 'required',
            //'currency_code' => 'required',
            'mobile' => 'required',
            //'pin' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path()); 
        }else { 
                $phoneQuery = Users:: where([ ['mobile', $request->input('mobile')] ]);
                $phoneCount = $phoneQuery->count();
                if ($phoneCount) {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Mobile Number already registered.'
                    ], 400);
                }
                $emailQuery = Users:: where([ ['email', $request->input('email')] ]);
                $emailCount = $emailQuery->count();
                if ($emailCount) {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Email id already registered.'
                    ], 400);
                }
                // ceck sales code
                if($request->input('sales_code') !='' ){
                    $salesteam = SalesTeam::where('salescode', strtoupper($request->input('sales_code')))->count();
                    if(!$salesteam) {
                        return response()->json([
                            'status' => FALSE,
                            'message' => 'Sales code not found.'
                        ], 400); 
                    }
                }
                
                $code = md5(date('Ymdhis').$request->input('email').rand(1111111,9999999));
                $user = new Users;
                $user->uniquecode = md5(date('Ymdhis').$request->input('phone').rand(1111111,9999999));
                $user->full_name=   $request->input('name');
                $user->email    =   $request->input('email');
                $user->password =   app('hash')->make($request->input('password'));
                $user->gender    =   $request->input('gender');
                $user->mobile    =   $request->input('mobile');
                $user->verify_code    =  $code;
                $user->verify_time    =  date('Y-m-d H:i:s');
                $user->country  =   $request->input('country'); //in
                $user->country_code =   $request->input('country_code'); //91
                // $user->currency =   $request->input('currency_code'); //INR
                // $user->pin      =  base64_encode($request->input('pin'));
                // $user->sales_code =  strtoupper($request->input('sales_code'));
                $user->save();

                // create empty wallet
                $currencies = array('USD', 'EURO');
                foreach($currencies as $currency) {
                    $user_wallet = new User_wallet;
                    $user_wallet->uniquecode = md5(date('Ymdhis').$currency.rand(1111111,9999999));
                    $user_wallet->user_id =   $user->uniquecode;
                    $user_wallet->currency  =   $currency;
                    $user_wallet->amount = 0;
                    $user_wallet->save();
                }
                
                Commons::qrcode($user->uniquecode);

            $recovery_url = URL::to('user/email-verify').'?code='.$code;
            $data['name'] = $request->input('name');;
            $data['url'] = $recovery_url;
            $mail = Commons::sendMail('register',$data,$request->input('email'),'Register Email verification');

            return Commons::success('Email Verification mail sent. Please check your inbox.', $user, $request->path());
        }
    }
    public function registerCodeVerify(Request $request)
    {
        $user   =   $request->auth;;
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), $user, $request->path());
        }else {
            $code = $request->input('code');

            $userQuery = Users::where([
                ['verify_code', $code]
            ]);

            $count = $userQuery->count();
            if (!$count) {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Verification code not valid.'
                ], 400);
            }

            $userData = $userQuery->first();

            $new_time = strtotime(date("Y-m-d H:i:s", strtotime($userData['verify_time'] . "+24 hours")));
            $now_time = strtotime(date("Y-m-d H:i:s"));

            if ($now_time > $new_time) {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Verification code expired.'
                ], 400);
            }
            else{
                $userQuery->update(array('is_verify'   =>  '1', 'status' => 'Active'));
                $response['data'][]=[
                    'id' => $userData->uniquecode,
                ];

                Commons::success('Email verified successfully.');
                return redirect('https://moneyexpressmx.com/backend/');

//                return Commons::success('Email verified successfully.', $user, $request->path());
            }

        }
    }

//     public function qrcode(Request $request) {
//        Commons::qrcode($request->input('code'));
//     }

     public function generatePDF(Request $request) {
        Commons::generatePDF($request->input('code'));
     }

    public function list(Request $request) {
        $user       =   $request->auth;
        
        $global     =   Commons::global_filter($request->input('filter'));
        $type       =   $request->input('type');
        $route      =   $request->input('route');
        $skip       =   "0";
        $take       =   "500";
        $sort_column=   "full_name";
        $sort_order =   "Asc";
        
        if(!empty($request->input('skip'))) { $skip = $request->input('skip'); }
        if(!empty($request->input('take'))) { $take = $request->input('take'); }
        if(!empty($request->input('sort_column'))) { $sort_column = $request->input('sort_column'); }
        if(!empty($request->input('sort_order'))) { $sort_order = $request->input('sort_order'); }

        $query  =   DB::table('users');
        
        if($request->input('id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($request->input('status')){
            $query->where('status',"LIKE",$request->input('status'));
        }
        
        if($request->input('todate') && $request->input('fromdate')) {
            $query->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $query->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            //$query->whereBetween('creationdate', [$request->input('fromdate'), $request->input('todate')]);
        }
        
        if($global){
            $query->where(function ($query) use ($global) { 
            $query->ORwhere('full_name','LIKE','%'.$global.'%');
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
                'name'       =>   $rec->full_name,
                'email'       =>   $rec->email,
                'mobile'       =>   $rec->mobile,
                'country'       =>   $rec->country,
                'country_code'       =>   $rec->country_code,
                'currency'       =>   $rec->currency,
                'profile_pic'       =>   $rec->profile_pic,
                'gender'       =>   $rec->gender,
                'sales_code'    => $rec->sales_code,
                //'pin'       =>   base64_decode($rec->pin),
                'status'       =>   $rec->status
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
                    'full_name'    =>   $request->input('name'),
                    'profile_pic'    =>   $request->input('profile_pic')
                ];
                Users::where('uniquecode', $request->input('id'))->update($update);
                return Commons::success('', $user, $request->path());
        }
    }

    // public function delete(Request $request){
    //     $user   =   $request->auth;;
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required'
    //     ]);
        
    //     if($validator->fails()) { return Commons::failed($validator->errors(), $user, $request->path()); 
    //     }else {    
    //         City::where('uniquecode', $request->input('id'))->delete();
    //         return Commons::success('', $user, $request->path());
    //     }
    // }
    
    public function userStatusUpdate(Request $request){
        $user   =   $request->auth;
        $idsArr =   $request->input('id');
        $status =   $request->input('status');

        foreach($idsArr as $id){
            DB::table('users')
            ->where('uniquecode', $id)
            ->update(['status' => $status]);
        }

        return Commons::success('', $user, $request->path());
    }

    // Change password // 
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

            $user = Users::where('uniquecode', $request->input('id'))->first();
            if (!$user) {
                return response()->json([
                    'status' => False,
                    'message' => 'User does not exist.'
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
                    Users::where('uniquecode', $request->input('id'))->update($update);
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

        $user = Users::where('email', $request->input('email'))->first();
        // print_r($user);
        // exit;
        if (!$user) {
            return response()->json([
                'status' => False,
                'message' => 'Email does not exist.'
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
                return response()->json([
                    'status' => TRUE,
                    'token' => $this->jwt($user),
                    'user_id' => $user->uniquecode,
                    'username' => $user->full_name,
                    'profile' => $user->profile_pic,
                    'gender' => $user->gender,
                    'qr_code' => $user->uniquecode.".png"
                ], 200);
            }


        }
        // Bad Request response
        return response()->json([
            'status' => FALSE,
            'message' => 'Email or password is wrong.'
        ], 400);
    }

    //====jwt token====//
    protected function jwt(Users $user) {

        $payload = [
            'iss'   =>  "lumen-jwt", // Issuer of the token
            'sub'   =>  $user->id, // Subject of the token
            'iat'   =>  time(), // Time when JWT was issued.
            'exp'   =>  time() + 86400, // Expiration time second 24hours
            'type'  =>  "User" // User type
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }



    public function wallet(Request $request) {   
        $user       =   $request->auth;
        
        $global     =   Commons::global_filter($request->input('filter'));
        $type       =   $request->input('type');
        $route      =   $request->input('route');
        $skip       =   "0";
        $take       =   "50";
        $sort_column=   "id";
        $sort_order =   "Asc";
        
        if(!empty($request->input('skip'))) { $skip = $request->input('skip'); }
        if(!empty($request->input('take'))) { $take = $request->input('take'); }
        if(!empty($request->input('sort_column'))) { $sort_column = $request->input('sort_column'); }
        if(!empty($request->input('sort_order'))) { $sort_order = $request->input('sort_order'); }

        $query  =   DB::table('user_wallet');
        
        if($request->input('id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($request->input('user_id')){
            $query->where('user_id',"LIKE",$request->input('user_id'));
        }
        
        if($request->input('currency')){
            $query->where('currency',"LIKE",$request->input('currency'));
        }

        if($global){
            $query->where(function ($query) use ($global) { 
            $query->ORwhere('currency','LIKE','%'.$global.'%');
            });
        }else{      
            Commons::filtering($request->input('filter'), $query, 'list');
        }       
        
        Commons::sorting($sort_column, $sort_order, $request->input('sort'), $query);
        $response['records'] =  $query->count();
        
        $transection = Transections::where('user_id', $request->input('user_id'))->orderBy('id', 'DESC')->take(1);
        if($transection->count() > 0) {
            $transectionData = $transection->get();
            $response['last_used_currency'] = $transectionData['0']['currency'];
        } else {
            $response['last_used_currency'] = 'USD';
        }
        

        $data  =  $query->skip($skip)->take($take)->get();  
        foreach($data as $rec){ 
            if($rec->currency == 'USD') {
                $symbol = 'usd.png';
                $symbol1 = 'usd1.png';
            } else {
                $symbol = 'euro.png';
                $symbol1 = 'euro1.png';
            } 
            $response['data'][]=[           
                'id'            =>   $rec->uniquecode,
                'creationdate'  =>   Commons::datetimeformat($rec->creationdate),
                'user_id'       =>   $rec->user_id,
                'currency'       =>   $rec->currency,
                'symbol'       =>   $symbol,
                'symbol1'       =>   $symbol1,
                'amount'       =>   $rec->amount
            ];
            
        }

        return Commons::response(@$response);  
    }

    public function transection(Request $request) {   
        $user       =   $request->auth;
        
        $global     =   Commons::global_filter($request->input('filter'));
        $type       =   $request->input('type');
        $route      =   $request->input('route');
        $skip       =   "0";
        $take       =   "500";
        $sort_column=   "creationdate";
        $sort_order =   "Desc";
        
        if(!empty($request->input('skip'))) { $skip = $request->input('skip'); }
        if(!empty($request->input('take'))) { $take = $request->input('take'); }
        if(!empty($request->input('sort_column'))) { $sort_column = $request->input('sort_column'); }
        if(!empty($request->input('sort_order'))) { $sort_order = $request->input('sort_order'); }

        $query  =   DB::table('transections');
        
        if($request->input('id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($request->input('user_id')){
            $query->where('user_id',"LIKE",$request->input('user_id'));
        }

        if($request->input('type')){
            $query->where('type',"LIKE",$request->input('type'));
        }
        
        if($request->input('todate') && $request->input('fromdate')) {
            $query->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $query->where('creationdate', '<=', $request->input('todate')." 23:59:59");
            //$query->whereBetween('creationdate', [$request->input('fromdate'), $request->input('todate')]);
        }

        if($global){
            $query->where(function ($query) use ($global) { 
            $query->ORwhere('type','LIKE','%'.$global.'%');
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
                'user_id'       =>   $rec->user_id,
                'description'       =>   $rec->description,
                'type'       =>   $rec->type,
                'currency'       =>   $rec->currency,
                'amount'       =>   $rec->amount
            ];
        }
        return Commons::response(@$response);  
    }

    public function fileupload(Request $request) {
        $user       =   $request->auth;
        
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path()); 
        }else { 
            $file = Commons::fileUpload($request->file('file'));
            
            if($file != 'error') {
                $response['data'][] = ["file"     => $file];
                return Commons::response($response, '', '');
            } else {   return Commons::failed('Please check file extension.', $user, $request->path()); }
            
        }

    }

    public function profile_image(Request $request) {
        $user       =   $request->auth;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path()); 
        }else { 
                $query = Users::where('uniquecode', $request->input('user_id'));
                $query->update(array('profile_pic' => $request->input('image')));
                $data  =  $query->get();
                foreach($data as $rec){ 
                    $response['data'][]=[           
                        'id'            =>   $rec->uniquecode,
                        'creationdate'  =>   Commons::datetimeformat($rec->creationdate),
                        'name'       =>   $rec->full_name,
                        'email'       =>   $rec->email,
                        'mobile'       =>   $rec->mobile,
                        'country'       =>   $rec->country,
                        'country_code'       =>   $rec->country_code,
                        'currency'       =>   $rec->currency,
                        'profile_pic'       =>   $rec->profile_pic,
                        'status'       =>   $rec->status
                    ];
                }
                return Commons::response(@$response);  
            
        }

    }


   public function forgetPassword(Request $request)
   {
        $user       =   $request->auth;
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path()); 
        }else { 
            $userQuery = Users::where('email', $request->input('email'));
            if($userQuery->count()){
                $code = md5(date('Ymdhis').$request->input('email').rand(1111111,9999999));
                $update = ['verify_code' => $code, 'verify_time' => date('Y-m-d H:i:s'), 'is_verify'=>'0']; //DB::raw('now()')
                $userQuery->update($update);
                $fullname = $userQuery->first()->full_name ;
               
                $recovery_url = URL::to('user/forget_password/code_verify').'?code='.$code;
                $data['name'] = $fullname;
                $data['url'] = $recovery_url;
                $mail = Commons::sendMail('forget-password',$data,$request->input('email'),'Forget password Email verification');
               
                return Commons::success('Verification mail sent.', $user, $request->path());
            }
            else {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Email Id not registered.'
                ], 400);
            }
        }

   }

   
   public function forgetPasswordCodeVerify(Request $request)
   {
        $user   =   $request->auth;;
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), $user, $request->path()); 
        }else { 
            $code = $request->input('code');
            
            $userQuery = Users::where([
                ['verify_code', $code]
            ]);

            $count = $userQuery->count();
            if (!$count) {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Verification code not valid.'
                ], 400);
            }

            $userData = $userQuery->first();
            
            $new_time = strtotime(date("Y-m-d H:i:s", strtotime($userData['verify_time'] . "+24 hours")));
            $now_time = strtotime(date("Y-m-d H:i:s"));
            
            if ($now_time > $new_time) {
                return response()->json([ 
                    'status' => FALSE,
                    'message' => 'Verification code expired.'
                ], 400);
            }
            else{
                $userQuery->update(array('is_verify'   =>  '1'));
                    $response['data'][]=[
                            'id' => $userData->uniquecode,
                        ];
                    
                    return redirect('https://moneyexpressmx.com/backend/newpassword?id='.$userData->uniquecode);
                    //return Commons::response(@$response);  

                //return Commons::success('Email verified successfully.', $user, $request->path());
            }
            
        }
   }

   public function NewPassword(Request $request)
    {
        $user       =   $request->auth;
        $validator = Validator::make($request->all(), [
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

            $user = Users::where('uniquecode', $request->input('id'))->first();
            if (!$user) {
                return response()->json([
                    'status' => False,
                    'message' => 'User does not exist.'
                ], 400);
            }
            
                if($user->status == "Inactive") {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Your account is Inactive.'
                    ], 400);
                }
                else
                {
                    $update = ['password'    =>   app('hash')->make($request->input('new_password')) ];
                    Users::where('uniquecode', $request->input('id'))->update($update);
                    return Commons::success('', $user, $request->path());
                }
            
            
        }
            
    }

    public function sendQRcode(Request $request)
    {
        $user       =   $request->auth;
        $validator = Validator::make($request->all(), [
          //'name' => 'required',
            'id' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path());
        }else {
                $mail = Commons::sendQRcodeMail('send-qrcode',$request->input('email'),'MoneyExpressMX QR Code', $request->input('id'));

                return Commons::success('Qrcode mail sent.', $user, $request->path());

        }

    }

   
}