<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Users;
use App\Models\Banks;
use App\Models\User_wallet;
use App\Models\Deposit;
use App\Models\Transections;
use App\Models\Settings;
use App\Models\Commission;
use App\Models\Product;
use App\Helpers\Commons;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => [
            'create',
            'list',
            'update',
            'delete'
        ]]);   
    }

    public function create(Request $request) {
        $user       =   $request->auth;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'color' => 'required',
            'user_id' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()) { return Commons::failed($validator->errors(), [], $request->path()); 
        }else { 
            // if($request->input('via_admin') == 1){
            //     $file = $request->input('image');
            // } else {
            //     $file = Commons::fileUpload($request->file('image'));
            // }
            
                
            //if($file != 'error') {

                $deposit = new Product;
                $deposit->uniquecode = md5(date('Ymdhis').$request->input('price').rand(1111111,9999999));
                $deposit->user_id   =   $request->input('user_id');
                $deposit->name  =   $request->input('name');
                $deposit->color    = $request->input('color');
                $deposit->price    =   $request->input('price');
                $deposit->picture  =   $request->input('image');
                $deposit->status =   $request->input('status'); 
                $deposit->save();
                
                return Commons::success('', $user, $request->path());
            // }
            // else { 
            //     return Commons::failed('Image not upload. Pleae try after sometime.', $user, $request->path());
            // }
        }

    }

    public function list(Request $request) {   
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

        $query  =   DB::table('products');
        
        if($request->input('id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($request->input('user_id')){
            $query->where('user_id',"LIKE",$request->input('user_id'));
        }

        if($request->input('name')){
            $query->where('name',"LIKE",$request->input('name'));
        }

        if($request->input('status')){
            $query->where('status',"LIKE",$request->input('status'));
        }
        
        if($request->input('todate') && $request->input('fromdate')) {
            $query->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $query->where('creationdate', '<=', $request->input('todate')." 23:59:59");
        }

        if($global){
            $query->where(function ($query) use ($global) { 
            $query->ORwhere('name','LIKE','%'.$global.'%');
            });
        }else{      
            Commons::filtering($request->input('filter'), $query, 'list');
        }       
        
        Commons::sorting($sort_column, $sort_order, $request->input('sort'), $query);
        $response['records'] =  $query->count();

        $data  =  $query->skip($skip)->take($take)->get();  
        foreach($data as $rec){ 
            $user = Users::where('uniquecode', $rec->user_id)->first();
            
            $response['data'][]=[           
                'id'            =>   $rec->uniquecode,
                'creationdate'  =>   Commons::datetimeformat($rec->creationdate),
                'user_id'       =>   $rec->user_id,
                'user_name'       =>   $user->full_name,
                'user_email'       =>   $user->email,
                'name'       =>   $rec->name,
                'price'       =>   $rec->price,
                'color'       =>   $rec->color,
                'status'       =>   $rec->status,
                'picture'       =>   $rec->picture
            ];
        }
        return Commons::response(@$response);  
    }

    public function list2(Request $request) {   
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

        $query  =   DB::table('products');
        
        if($request->input('id')){
            $query->where('uniquecode',"LIKE",$request->input('id'));
        }

        if($request->input('user_id')){
            $query->where('user_id',"LIKE",$request->input('user_id'));
        }

        if($request->input('name')){
            $query->where('name',"LIKE",$request->input('name'));
        }

        if($request->input('status')){
            $query->where('status',"LIKE",$request->input('status'));
        }
        
        if($request->input('todate') && $request->input('fromdate')) {
            $query->where('creationdate', '>=', $request->input('fromdate')." 00:00:00");
            $query->where('creationdate', '<=', $request->input('todate')." 23:59:59");
        }

        if($global){
            $query->where(function ($query) use ($global) { 
            $query->ORwhere('name','LIKE','%'.$global.'%');
            });
        }else{      
            Commons::filtering($request->input('filter'), $query, 'list');
        }       
        
        Commons::sorting($sort_column, $sort_order, $request->input('sort'), $query);
        $response['records'] =  $query->count();

        $data  =  $query->skip($skip)->take($take)->get();  
        foreach($data as $rec){ 
            $user = Users::where('uniquecode', $rec->user_id)->first();
            
            $response['data'][]=[           
                'id'            =>   $rec->uniquecode,
                'creationdate'  =>   Commons::datetimeformat($rec->creationdate),
                'user_id'       =>   $rec->user_id,
                'user_name'       =>   $user->full_name,
                'user_email'       =>   $user->email,
                'name'       =>   $rec->name,
                'price'       =>   $rec->price,
                'color'       =>   $rec->color,
                'status'       =>   $rec->status,
                'picture'       =>   $rec->picture
            ];
        }
        return Commons::response(@$response);  
    }

    public function productStatusUpdate(Request $request){
        $user   =   $request->auth;
        $idsArr =   $request->input('id');
        $status =   $request->input('status');

        foreach($idsArr as $id){
            DB::table('products')
            ->where('uniquecode', $id)
            ->update(['status' => $status]);
        }

        return Commons::success('', $user, $request->path());
    }

    public function update(Request $request){
        $user   =   $request->auth;;
        
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'color' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);
        
        if($validator->fails()) { return Commons::failed($validator->errors(), $user, $request->path()); 
        }else { 
            
            try {
                DB::beginTransaction();
                $depositQuery = Product::where('uniquecode', $request->input('id'));
                
                $update =   [
                    'name'    =>   $request->input('name'),
                    'price'    =>   $request->input('price'),
                    'color'    =>   $request->input('color'),
                    'image'    =>   $request->input('image'),
                    'status'    =>   $request->input('status')
                ];
                
                $depositQuery->update($update);
                
               DB::commit();
                return Commons::success('', $user, $request->path());
                
            } catch (\Throwable $th) {
                DB::rollBack();
                return Commons::failed('', $user, $request->path());
            }
                
        }
    }

    public function delete(Request $request){
        $user   =   $request->auth;;
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        
        if($validator->fails()) { return Commons::failed($validator->errors(), $user, $request->path()); 
        }else {    
            Product::where('uniquecode', $request->input('id'))->delete();
            return Commons::success('', $user, $request->path());
        }
    }

   
}
