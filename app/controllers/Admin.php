<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
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
        if ($this->session->userdata('user_login') != 1)
            redirect(base_url() . 'login', 'refresh');

        if ($this->session->userdata('user_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('user_login') != 1) redirect(base_url(), 'refresh');
        
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('dashboard');
        $this->load->view('backend/index', $page_data);
    }
   

    // ======== Products ==============//
    function products($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1) redirect('login', 'refresh');
        
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

           redirect(site_url('admin/products/'), 'refresh');
       }

       $post = array('user_id' => $this->session->userdata('user_id'));
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

    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
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
            redirect(base_url() . 'admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'admin/system_settings/', 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected')); 
            redirect(base_url() . 'admin/system_settings/', 'refresh'); 
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    
    
    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
			redirect(base_url() . 'login', 'refresh');
		
		if ($param1 == 'edit_phrase') {
			$page_data['edit_profile'] 	= $param2;	
		}
		if ($param1 == 'update_phrase') {
			$language	=	$param2;
			$total_phrase	=	$this->input->post('total_phrase');
			for($i = 1 ; $i < $total_phrase ; $i++)
			{
				//$data[$language]	=	$this->input->post('phrase').$i;
				$this->db->where('phrase_id' , $i);
				$this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
			}
			redirect(base_url() . 'admin/manage_language/edit_phrase/'.$language, 'refresh');
		}
		if ($param1 == 'do_update') {
			$language        = $this->input->post('language');
			$data[$language] = $this->input->post('phrase');
			$this->db->where('phrase_id', $param2);
			$this->db->update('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		if ($param1 == 'add_phrase') {
			$data['phrase'] = $this->input->post('phrase');
			$this->db->insert('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		if ($param1 == 'add_language') {
			$language = $this->input->post('language');
			$this->load->dbforge();
			$fields = array(
				$language => array(
					'type' => 'LONGTEXT'
				)
			);
			$this->dbforge->add_column('language', $fields);
			
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		if ($param1 == 'delete_language') {
			$language = $param2;
			$this->load->dbforge();
			$this->dbforge->drop_column('language', $language);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		$page_data['page_name']        = 'manage_language';
		$page_data['page_title']       = get_phrase('manage_language');
		//$page_data['language_phrases'] = $this->db->get('language')->result_array();
		$this->load->view('backend/index', $page_data);	
    }
    
    
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1) redirect('login', 'refresh');

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
            
            $update = $this->guzzle->request(USER_UPDATE, $post);
            if($update['Code'] == 200){
                $this->session->set_userdata('user_name', $this->input->post('name'));
                $this->session->set_flashdata('flash_message' , get_phrase('account_updated'));
            }
                
            else
                $this->session->set_flashdata('error_message' ,$update['Body']['message']);

            redirect(base_url() . 'admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            if ($this->input->post('new_password') == $this->input->post('confirm_new_password') ) {
                $post = array_merge(array('id' => $this->session->userdata('user_id')), $this->input->post());
                $update = $this->guzzle->request(CHANGE_PASSWORD, $post);
                if($update['Code'] == 200){
                    $this->session->sess_destroy();
                    $this->session->set_flashdata('error_message', 'password_changed_successfully');
                    redirect(base_url(), 'refresh');
                }
                else{
                    $this->session->set_flashdata('error_message' ,$update['Body']['message']);
                    redirect(base_url() . 'admin/manage_profile/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_and_confirm_password_mismatch'));
                redirect(base_url() . 'admin/manage_profile/', 'refresh');
            }
            
        }

        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']    = $this->guzzle->request(USER_LIST, array('id' => $this->session->userdata('user_id')));
       
        $this->load->view('backend/index', $page_data);
    }
    
   

}