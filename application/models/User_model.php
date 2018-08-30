<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        // $this->load->library('ion_auth');
        
    }   
    
    /*    
    	returns all available users   
    */

    public function add_pigeon($additional_data = array())
    {
        $this->db->insert('pigeon_record',$additional_data);

        $id = $this->db->insert_id();

        return (isset($id)) ? $id : FALSE;


    }


    public function update_pigeon($array, $id)
    {

        $this->db->set($array);
        $this->db->where('pigeon_id', $id);
        $updated = $this->db->update('pigeon_record');

        return $updated;
    }

    public function user_order($additional_data = array())
    {
        $this->db->insert('user_order',$additional_data);

        $id = $this->db->insert_id();

        return (isset($id)) ? $id : FALSE;


    }

    public function pigeon_list()
    {
        $this->db->from('pigeon_record');
        $this->db->select('*');
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function get_pigeon($id)
    {
        $this->db->from('pigeon_record');
        $this->db->select('*');
        $this->db->where('pigeon_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function get_leave($id)
    {
        $this->db->from('pigeon_leave');
        $this->db->select('*');
        $this->db->where('leave_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }
    public function get_data($id)
    {
        $this->db->from('pigeon_record');
        $this->db->select('*');
        $this->db->where('pigeon_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();

        // print_r($data);[]
        return $data[0]; 

    }

    public function user_order_list($key)
    {
        $this->db->from('user_order');
        $this->db->select('*');
        if($key == 'pending' || $key== 'complete' || $key == 'accept' || $key == 'reject')
        {
            $this->db->where('order_status', $key);
        }
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function get_list($id, $key)
    {
        $this->db->from('user_order');
        $this->db->select('*');
        $this->db->where('o_user_id' , $id);
        if($key == 'pending' || $key== 'complete' || $key == 'accept' || $key == 'reject')
        {
            $this->db->where('order_status', $key);
        }
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }
    public function get_list2($id)
    {
        $this->db->from('user_order');
        $this->db->select('*');
        $this->db->where('o_user_id' , $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function find_order($id)
    {
        $this->db->from('user_order');
        $this->db->select('*');
        $this->db->where('order_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function find_user($id)
    {
        $this->db->from('user_order');
        $this->db->select('*');
        $this->db->where('o_user_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function find_leave($id)
    {
        $this->db->from('pigeon_leave');
        $this->db->select('*');
        $this->db->where('leave_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 

    }

    public function pigeon_inrange($distance,$orderDate)
    {
        $this->db->from('pigeon_record as t1');
        $this->db->select('t1.*');
        $this->db->join('pigeon_leave as t2', 't1.pigeon_id = t2.l_pigeon_id', 'left');
        $this->db->where("t2.l_start_date > ",$orderDate );
        $this->db->or_where("t2.l_end_date<",$orderDate);
        $this->db->or_where("t2.leave_id is null");
        $this->db->where('t1.pigeon_range >=', $distance);

        // $this->db->where('p_status', $status);
        $q = $this->db->get();
        $data = $q->result_array();
        // print_r($data);
        return $data; 

    }

    public function pigeon_inrange_valid($distance,$orderDate, $id)
    {
        $this->db->from('pigeon_record as t1');
        $this->db->select('t1.*');
        $this->db->join('pigeon_leave as t2', 't1.pigeon_id = t2.l_pigeon_id', 'left');
        $this->db->where("t2.l_start_date > ",$orderDate );
        $this->db->or_where("t2.l_end_date<",$orderDate);
        $this->db->or_where("t2.leave_id is null");
        $this->db->where('t1.pigeon_range >=', $distance);

        $this->db->where('t1.pigeon_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        // print_r($data);
        return $q; 

    }

        public function assign_order($data)
      {
        // print_r($data);
        $this->db->insert("order_assign_to", $data);
        $insert_id = $this->db->insert_id();
        // echo "string";
        return $insert_id;
      }

    public function update_order_status($id)
    {
        $this->db->set('order_status', 'accept');
        $this->db->where('order_id', $id);
        $updated = $this->db->update('user_order');

        return $updated;
    }

    public function update_ordered_status($id, $status)
    {
        $this->db->set('order_status', $status);
        $this->db->where('order_id', $id);
        $updated = $this->db->update('user_order');

        return $updated;
    }

    public function update_pigeon_status($id)
    {
        $this->db->set('p_status', 'unavailable');
        $this->db->where('pigeon_id', $id);
        $updated = $this->db->update('pigeon_record');

        return $updated;
    }

    public function check_avai($id, $order_id)
    {
        $this->db->from('order_assign_to');
        $this->db->select('*');
        $this->db->where('a_pigeon_id', $id);
        $this->db->where('a_user_id', $order_id);
        $q = $this->db->get();
        $data = $q->result_array();
        // print_r($data);
        return $data; 

    }

    public function pigeon_leave($additional_data = array())
    {
        $this->db->insert('pigeon_leave',$additional_data);

        $id = $this->db->insert_id();

        return (isset($id)) ? $id : FALSE;


    }

    public function more_check()
    {
        $this->db->from('pigeon_record');
        $this->db->select('pigeon_id');
        $q = $this->db->get();
        $data = $q->result_array();
        return $data;
    }

    public function new_check()
    {
        $this->db->from('order_assign_to');
        $this->db->select('a_pigeon_id');
        $this->db->where_not_in('a_pigeon_id', $id );
        $q = $this->db->get();
        $data = $q->result_array();
        return $data;
    }

    public function find_pigeon($id)
    {
        $this->db->from('pigeon_record');
        $this->db->select('*');
        $this->db->where('pigeon_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        // print_r($data);
        return $data; 

    }

    public function remove_leave($id)
    {
         $this->db-> where('leave_id', $id);
        $data =  $this->db-> delete('pigeon_leave');

        return $data;
    }

    public function get_status($id)
    {
        $this->db->from('user_order');
        $this->db->select('order_status');
        $this->db->where('order_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        return $data; 
    }

    public function pigeon_id($id)
    {
        $this->db->from('order_assign_to');
        $this->db->select('a_pigeon_id');
        $this->db->where('a_user_id', $id);
        $q = $this->db->get();
        $data = $q->result_array();
        // print_r($data);
        return $data[0]['a_pigeon_id']; 

    }
}