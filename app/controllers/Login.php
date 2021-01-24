<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    public function index() {
        if ($this->session->userdata('user_login') == 1){
            redirect(base_url() . 'admin/dashboard', 'refresh');
        }
        if ($this->session->userdata('superadmin_login') == 1){
            redirect(base_url() . 'superadmin/dashboard', 'refresh');
        }

        $this->load->view('backend/login');
    }

    public function ajax_login() {
        $response = array();

        $email = $_POST["email"];
        $password = $_POST["password"];
        $response['submitted_data'] = $_POST;

        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login() {
        $login = $this->guzzle->request(LOGIN,$this->input->post());
        if ($login['Code'] == 200) {
            $this->session->set_userdata('user_login', '1');
            $this->session->set_userdata('login_type', 'admin');
            $this->session->set_userdata('apt_token', $login['Body']['token']);
            $this->session->set_userdata('user_id', $login['Body']['user_id']);
            $this->session->set_userdata('user_name', $login['Body']['username']);
            $this->session->set_userdata('qr_code', $login['Body']['qr_code']);
            $this->session->set_userdata('profile_image', $login['Body']['profile']);
            $this->session->set_userdata('gender', $login['Body']['gender']);
            
            $this->session->set_flashdata('flash_message' , get_phrase('Logged in Successfully...'));
            redirect(site_url('admin/dashboard'), 'refresh');
        }

        $this->session->set_flashdata('error_message', $login['Body']['message']);
        redirect(site_url('login'), 'refresh');
      
    }

    function validate_superadmin_login() {
        $login = $this->guzzle->request(SUPERADMIN_LOGIN,$this->input->post());
        if ($login['Code'] == 200) {
            $this->session->set_userdata('superadmin_login', '1');
            $this->session->set_userdata('login_type', 'superadmin');
            $this->session->set_userdata('apt_token', $login['Body']['token']);
            $this->session->set_userdata('user_id', $login['Body']['user_id']);
            $this->session->set_userdata('user_name', $login['Body']['username']);
            $this->session->set_userdata('profile_image', $login['Body']['profile']);
            $this->session->set_userdata('gender', $login['Body']['gender']);
            $this->session->set_flashdata('flash_message',"Logged in Successfully...");
            redirect(site_url('superadmin/dashboard'),'refresh');
        }
        else {
            $this->session->set_flashdata('error_message',$login['Body']['message']);
            redirect(site_url('superadmin'),'refresh');      
        }
        // $this->session->set_flashdata('error_message',$login['Body']['message']);
        // redirect(site_url('superadmin'),'refresh');     
    }

    function update_new_password() {
        if($this->input->post('id')) {
            $login = $this->guzzle->request(NEW_PASSWORD,$this->input->post());
            
            if ($login['Code'] == 200) {
                $this->session->set_flashdata('flash_message' , get_phrase('Password updated Successfully...'));
                redirect(site_url(''), 'refresh');
            }
        }

        $this->session->set_flashdata('error_message', $login['Body']['message']);
        redirect(site_url('newpassword?id='.$this->input->post('id')), 'refresh');
      
    }

    function forget_password() {
            $login = $this->guzzle->request(FORGET_PASSWORD,$this->input->post());
            
            if ($login['Code'] == 200) {
                $this->session->set_flashdata('flash_message' ,$login['Body']['message']);
                redirect(site_url('login'), 'refresh');
            }
            else {
                $this->session->set_flashdata('error_message', $login['Body']['message']);
                redirect(site_url('login'), 'refresh');
            }
        
    }

    //Validating login from ajax request
    function validate_singup() {
        $login = $this->guzzle->request(SIGNUP,$this->input->post());
        if ($login['Code'] == 200) {
            
            $this->session->set_flashdata('flash_message' , get_phrase('Registered Successfully. Please login with your details...'));
            redirect(site_url('login'), 'refresh');
        }
        else {
            $this->session->set_flashdata('error_message', $login['Body']['message']);
            redirect(site_url('login'), 'refresh');
        }
        
      
    }

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        // $login = $this->guzzle->request(LOGIN_API,$this->input->post());
        
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}
