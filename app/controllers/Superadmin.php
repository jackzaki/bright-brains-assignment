<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
    
    function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
	    /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    public function index()
    {
        if ($this->session->userdata('superadmin_login') == 1)
            redirect(base_url() . 'superadmin/dashboard', 'refresh');

        $this->load->view('backend/superadmin_login');
    }
    
    /***superadmin DASHBOARD***/
    function dashboard()
    {
       
        if ($this->session->userdata('superadmin_login') != 1)
            redirect(base_url().'superadmin', 'refresh');

            // echo "dashboard";
            // exit;
        //$page_data['wallet'] =  $this->guzzle->request(WALLET,array('user_id' => $this->session->userdata('user_id')));
        
        
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('dashboard');
        $page_data['reportData']    = $this->guzzle->request(SUPERADMIN_REPORT);
        $this->load->view('backend/index', $page_data);
    }
    
     // ======== Users ==============//
     function users($param1 = '', $param2 = '', $param3 = '')
     {
         if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
         
         if ($param1 == 'active_inactive')
        {
            $post['status'] = $this->input->get('status');
            $post['id'] = explode(",",$this->input->get('ids'));
            $status = $this->guzzle->request(USER_STATUS_UPDATE, $post);
            if($status['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            else
                $this->session->set_flashdata('error_message' ,$status['Body']['message']);

            redirect(base_url() . 'superadmin/users/', 'refresh');
        }
 
        //  if ($param1 == 'delete') {
        //      $post['id'] = $param2;
        //      $delete = $this->guzzle->request(USER_DELETE, $post);
        //      if($delete['Code'] == 200)
        //          $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
        //      else
        //          $this->session->set_flashdata('error_message' ,$delete['Body']['message']);
 
        //      redirect(base_url() . 'superadmin/users/', 'refresh');
        //  }
        
        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
         $page_data['fromtodates']  = $dates;
         $page_data['page_name']  = 'users';
         $page_data['page_title'] = get_phrase('manage_users');
         $page_data['userData']    = $this->guzzle->request(USER_LIST,$post);
         
         $this->load->view('backend/index', $page_data);
     }
     // ======== user End==============//

     // ======== Products ==============//
     function products($param1 = '', $param2 = '', $param3 = '')
     {
         if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
         
         if ($param1 == 'active_inactive')
        {
            $post['status'] = $this->input->get('status');
            $post['id'] = explode(",",$this->input->get('ids'));
            $status = $this->guzzle->request(PRODUCT_STATUS_UPDATE, $post);
            if($status['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            else
                $this->session->set_flashdata('error_message' ,$status['Body']['message']);

            redirect(base_url() . 'superadmin/products/', 'refresh');
        }
        
        if ($param1 == 'create') {
            $ext = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
            if($ext =='png' || $ext =='jpg'|| $ext =='jpeg')
            {
                $filename   =  md5(rand(11111,99999).date('Ymdhis')).".".$ext;
                $te = move_uploaded_file($_FILES['file']['tmp_name'], UPLOADPATH.$filename);
                $post = array_merge(array('user_id' => $this->session->userdata('user_id'), 'image' => $filename), $this->input->post());
                
                $create = $this->guzzle->request(PRODUCT_CREATE, $post);
                if($create['Code'] == 200)
                    $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                else
                    $this->session->set_flashdata('error_message' ,$create['Body']['message']);
            }
            else
                $this->session->set_flashdata('error_message' , get_phrase('upload_only_image_file'));

            redirect(site_url('admin/product/'), 'refresh');
        }

        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
         $page_data['fromtodates']  = $dates;
         $page_data['page_name']  = 'products';
         $page_data['page_title'] = get_phrase('manage_products');
         $page_data['productData']    = $this->guzzle->request(PRODUCT_LIST,$post);
         
         $this->load->view('backend/index', $page_data);
     }
     // ======== product End==============//
     
    // ======== bank ==============//
    function bank($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'create') {
            $ext = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
            if($ext =='png' || $ext =='jpg'|| $ext =='jpeg')
            {
                $filename   =  md5(rand(11111,99999).date('Ymdhis')).".".$ext;
                $te = move_uploaded_file($_FILES['file']['tmp_name'], UPLOADPATH.$filename);
                $post = array_merge(array('picture' => $filename), $this->input->post());

                $create = $this->guzzle->request(BANK_CREATE, $post);
                if($create['Code'] == 200)
                    $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                else
                    $this->session->set_flashdata('error_message' ,$create['Body']['message']);
            }
            else
                $this->session->set_flashdata('error_message' , get_phrase('upload_only_image_file'));

            redirect(site_url('superadmin/bank/'), 'refresh');
        }

        // if ($param1 == 'do_update') {
        //     $post = array_merge(array('id' => $param2), $this->input->post());
        //     if($_FILES['file']['error'] == 0)
        //     {
        //         $ext = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
        //         $uploadpath = 'apis/public/files/';
        //         $filename   =  md5(rand(11111,99999).date('Ymdhis')).".".$ext;
        //         $te = move_uploaded_file($_FILES['file']['tmp_name'], $uploadpath.$filename);
        //         $post['picture'] = $filename;
        //     }
        //     $update = $this->guzzle->request(BANK_UPDATE, $post);
        //     if($update['Code'] == 200)
        //         $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
        //     else
        //         $this->session->set_flashdata('error_message' ,$update['Body']['error']);

        //     redirect(base_url() . 'superadmin/bank/', 'refresh');
        // }

        if ($param1 == 'delete') {
            $post['id'] = $param2;
            $delete = $this->guzzle->request(BANK_DELETE, $post);
            if($delete['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            else
                $this->session->set_flashdata('error_message' ,$delete['Body']['message']);

            redirect(base_url() . 'superadmin/bank/', 'refresh');
        }

        $page_data['page_name']  = 'bank';
        $page_data['page_title'] = get_phrase('manage_banks');
        $page_data['bankData']    = $this->guzzle->request(BANK_LIST);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== bank End==============//

    // ======== coupon ==============//
    function coupon($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'create') {
                $create = $this->guzzle->request(COUPON_CREATE, $this->input->post());
                if($create['Code'] == 200)
                    $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                else
                    $this->session->set_flashdata('error_message' ,$create['Body']['message']);
            
            redirect(site_url('superadmin/coupon/'), 'refresh');
        }

        if ($param1 == 'delete') {
            $post['id'] = $param2;
            $delete = $this->guzzle->request(COUPON_DELETE, $post);
            if($delete['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            else
                $this->session->set_flashdata('error_message' ,$delete['Body']['message']);

            redirect(base_url() . 'superadmin/coupon/', 'refresh');
        }

        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
        $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'coupon';
        $page_data['page_title'] = get_phrase('manage_coupon');
        $page_data['couponData']    = $this->guzzle->request(COUPON_LIST, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== coupon End==============//

    // ======== sales team ==============//
    function sales_team($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'create') {
                $create = $this->guzzle->request(SALES_TEAM_CREATE, $this->input->post());
                if($create['Code'] == 200)
                    $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                else
                    $this->session->set_flashdata('error_message' ,$create['Body']['message']);
            
            redirect(site_url('superadmin/sales_team/'), 'refresh');
        }

        if ($param1 == 'do_update') {
            $post = array_merge(array('id' => $param2), $this->input->post());
            $update = $this->guzzle->request(SALES_TEAM_UPDATE, $post);
            if($update['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            else
                $this->session->set_flashdata('error_message' ,$update['Body']['message']);
            
                redirect(site_url('superadmin/sales_team/'), 'refresh');
        } 

        if ($param1 == 'delete') {
            $post['id'] = $param2;
            $delete = $this->guzzle->request(SALES_TEAM_DELETE, $post);
            if($delete['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            else
                $this->session->set_flashdata('error_message' ,$delete['Body']['message']);

            redirect(base_url() . 'superadmin/sales_team/', 'refresh');
        }

        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
        $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'sales_team';
        $page_data['page_title'] = get_phrase('manage_sales_team');
        $page_data['salesTeamData']    = $this->guzzle->request(SALES_TEAM_LIST, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== sales team End==============//

    // ======== Sales team reports ==============//
    function sales_team_report($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
       
        //$post = array('todate' => date('2020-09-31'), 'fromdate' => date('2020-09-01'));
        $post = array('todate' => date('Y-m-t'), 'fromdate' => date('Y-m-01'));
        $dates = array('date1' => date('Y-m-01'), 'date2' => date('Y-m-t'));
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post1 = array();
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post1);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
        $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'sales_team_report';
        $page_data['page_title'] = get_phrase('sales_team_report');
        $page_data['reportData']    = $this->guzzle->request(SALES_TEAM_REPORT, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== Sales team reports end==============//

    // ======== transection ==============//
    function transection($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
         $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'transection';
        $page_data['page_title'] = get_phrase('manage_transection');
        $page_data['transectionData']    = $this->guzzle->request(TRANSECTION_LIST, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== coupon End==============//

    // ======== Deposit ==============//
    function deposit($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'do_update') {
            $post = array_merge(array('id' => $param2), $this->input->post());
            $update = $this->guzzle->request(DEPOSIT_UPDATE, $post);
            if($update['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            else
                $this->session->set_flashdata('error_message' ,$update['Body']['message']);
            
                redirect(site_url('superadmin/deposit/'), 'refresh');
        } 

        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
         $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'deposit';
        $page_data['page_title'] = get_phrase('manage_deposit');
        $page_data['depositData']    = $this->guzzle->request(DEPOSIT_LIST, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== Deposit End==============//
    
    // ======== Wallet_transfer ==============//
    function wallet_transfer($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'create') {
           
            $create = $this->guzzle->request(WALLET_TRANSFER_CREATE, $this->input->post());
            if($create['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            else
                $this->session->set_flashdata('error_message' ,$create['Body']['message']);
            
            redirect(site_url('superadmin/wallet_transfer/'), 'refresh');
        }

        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
         $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'wallet_transfer';
        $page_data['page_title'] = get_phrase('manage_wallet_transfer');
        $page_data['walletTransferData']    = $this->guzzle->request(WALLET_TRANSFER_LIST, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== wallet transfer End==============//

    // ======== Payment ==============//
    function payment($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'do_update') {
            $post = array_merge(array('id' => $param2), $this->input->post());
            $update = $this->guzzle->request(PAYMENT_UPDATE, $post);
            if($update['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            else
                $this->session->set_flashdata('error_message' ,$update['Body']['message']);
            
                redirect(site_url('superadmin/payment/'), 'refresh');
        }

        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
         $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'payment';
        $page_data['page_title'] = get_phrase('manage_payment');
        $page_data['paymentData']    = $this->guzzle->request(PAYMENT_LIST, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== Deposit End==============//

    // ======== Commission ==============//
    function commission($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
       
       $post = array();
       $dates = array('date1' => '', 'date2' => '');
       if($this->input->post()) {
           if($this->input->post('todate') && $this->input->post('fromdate')){
               $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
               $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
           }
       }
      
        $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'commission';
        $page_data['page_title'] = get_phrase('manage_commission');
        $page_data['commissionData']    = $this->guzzle->request(COMMISSION_LIST,$post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== commission End==============//

    // ======== Commission To User ==============//
    function commissionToUser($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
        
        if ($param1 == 'create') {
            $post = array_merge(array('user_id' => $this->session->userdata('user_id')), $this->input->post());
            $create = $this->guzzle->request(COMMISSION_TO_USER_CREATE, $post);
            if($create['Code'] == 200)
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            else
                $this->session->set_flashdata('error_message' ,$create['Body']['message']);
            
            redirect(site_url('superadmin/commissionToUser/'), 'refresh');
        }

       $post = array();
       $dates = array('date1' => '', 'date2' => '');
       if($this->input->post()) {
           if($this->input->post('todate') && $this->input->post('fromdate')){
               $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
               $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
           }
       }
      
        $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'bonus';
        $page_data['page_title'] = get_phrase('manage_bonus');
        $page_data['bonusData']    = $this->guzzle->request(COMMISSION_TO_USER_LIST,$post);
        
        $this->load->view('backend/index', $page_data);
    }
    // ======== commission To User End==============//

    // ======== reports ==============//
    function reports($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');
       
        $post = array();
        $dates = array('date1' => '', 'date2' => '');
        if($this->input->post()) {
            if($this->input->post('todate') && $this->input->post('fromdate')){
                $post = array_merge( array('todate' => $this->input->post('todate'), 'fromdate' => $this->input->post('fromdate')), $post);
                $dates = array('date1' => $this->input->post('fromdate'), 'date2' => $this->input->post('todate'));
            }
        }
       
        $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = 'reports';
        $page_data['page_title'] = get_phrase('reports');
        $page_data['reportData']    = $this->guzzle->request(SUPERADMIN_REPORT, $post);
        
        $this->load->view('backend/index', $page_data);
    }
    
    
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        
        if ($param1 == 'do_update') {
			 
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type' , 'text_align');
            $this->db->update('settings' , $data);
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated')); 
            redirect(base_url() . 'superadmin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'superadmin/system_settings/', 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected')); 
            redirect(base_url() . 'superadmin/system_settings/', 'refresh'); 
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    
    
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('superadmin_login') != 1) redirect('login', 'refresh');

        if ($param1 == 'update_profile_info') {
            
            $post = array_merge(array('id' => $this->session->userdata('user_id')), $this->input->post());
            if($_FILES['file']['error'] == 0)
            {
                $ext = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
                $filename   =  md5(rand(11111,99999).date('Ymdhis')).".".$ext;
                $te = move_uploaded_file($_FILES['file']['tmp_name'], UPLOADPATH.$filename);
                $post['profile_pic'] = $filename;
                $this->session->set_userdata('profile_image', $filename);
            }
            
            $update = $this->guzzle->request(SUPERADMIN_UPDATE, $post);
            if($update['Code'] == 200){
                $this->session->set_userdata('user_name', $this->input->post('name'));
                $this->session->set_flashdata('flash_message' , get_phrase('account_updated'));
            }
                
            else
                $this->session->set_flashdata('error_message' ,$update['Body']['message']);

            redirect(base_url() . 'superadmin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            if ($this->input->post('new_password') == $this->input->post('confirm_new_password') ) {
                $post = array_merge(array('id' => $this->session->userdata('user_id')), $this->input->post());
                $update = $this->guzzle->request(SUPERADMIN_CHANGE_PASSWORD, $post);
                if($update['Code'] == 200){
                    $this->session->sess_destroy();
                    $this->session->set_flashdata('error_message', 'password_changed_successfully');
                    redirect(base_url().'superadmin', 'refresh');
                }
                else{
                    $this->session->set_flashdata('error_message' ,$update['Body']['message']);
                    redirect(base_url(). 'superadmin/manage_profile/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_and_confirm_password_mismatch'));
                redirect(base_url() . 'superadmin/manage_profile/', 'refresh');
            }
            
        }

        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']    = $this->guzzle->request(SUPERADMIN_LIST, array('id' => $this->session->userdata('user_id')));
       
        $this->load->view('backend/index', $page_data);
    }
    
    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url().'superadmin', 'refresh');
    }

}