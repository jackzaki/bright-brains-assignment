<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // function clear_cache() {
    //     $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    //     $this->output->set_header('Pragma: no-cache');
    // }

    function get_image_url($id = '') {
        if($id == NULL)
            $image_url = base_url('uploads/user.jpg');
        else if (file_exists('apis/public/files/'.$id))
            $image_url = base_url('apis/public/files/'.$id);
        else
            $image_url = base_url('uploads/user.jpg');

        return $image_url;
    }

    function get_system_settings() {
        $query = $this->db->get('settings');
        return $query->result_array();
    }

}