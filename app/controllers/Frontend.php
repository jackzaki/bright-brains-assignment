<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller
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
        // $page_data['fromtodates']  = $dates;
        $page_data['page_name']  = '1';
        $page_data['page_title'] = get_phrase('manage_products');
        $page_data['productData']    = $this->guzzle->request(PRODUCT_FRONTEND_LIST);
        
        $this->load->view('frontend/productlist', $page_data);
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

   

}