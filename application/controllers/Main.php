<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// $this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library('pagination');
		// $this->load->library('database');

		$this->load->database();

		// $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		// $this->lang->load('auth');
		$this->load->model('user_model');
		$this->load->helper('language');
		$this->load->helper('text');

		// $this->data['pageTitle'] = $this->lang->line('login_page_title');
	}

	public function index(){

	}

	public function user_order()
	{
		$id =   $this->input->post('user_id');
		$dis =   $this->input->post('distance');
		$date =   $this->input->post('deadline_date');
		$time =  $this->input->post('deadline_time');

		if($id !="" && $dis!= "" && $date != "" && $time != "")
		{
			$data = array(
			"o_user_id" =>   $id,
			"order_distance" =>   $dis,
			"order_date" =>   $date,
			"order_time" =>  $time,
			"order_status" => "pending",
			);

			$new = $this->user_model->user_order($data);
			$setting_fields = array(
			            "success" => "1",
			            "message" => "Order Added successfully"
			        );
				// $set_data = array(

				// 	);
			        
			        $output_array["settings"] = $setting_fields;
			        // $output_array["data"] = $this->data;
			        echo json_encode($output_array);
		}
		else
		{
			$setting_fields = array(
			            "code" => "405",
			            "message" => "All fields are required",
			        );
			        
			        $output_array = $setting_fields;
			        echo json_encode($output_array);
		}
	}

	public function pigeon_list()
	{
		
		$list = $this->user_model->pigeon_list();
		$jsonList = json_encode($list);
		echo $jsonList;

	}

	public function user_order_list()
	{
		$key = $this->input->post('keyword');

		$list = $this->user_model->user_order_list($key);
		
		echo json_encode($list);

	}

	public function order_by_user()
	{

		$user_id = $this->input->post('user_id');
		$key = $this->input->post('keyword');
		$or_id = $this->user_model->find_user($user_id);


		if(!empty($or_id) )
		{
			$list = $this->user_model->get_list($user_id, $key);

			$setting_fields = array(
				            "code" => "200",
				            "message" => $list,
				        );
				        
				        $output_array = $setting_fields;
				        echo json_encode($output_array);
		
			
		}

		else
		{
			$setting_fields = array(
				            "code" => "404",
				            "message" => "User id not found!",
				        );
				        
				        $output_array = $setting_fields;
				        echo json_encode($output_array);
		}

	}

	public function check_available_pigeon_inrange()
	{
		$order_id = $this->input->post('order_id');
		$lists = $this->user_model->find_order($order_id);

		if(!empty($lists))
		{
			// print_r($lists);
			$orderDistance =$lists[0]['order_distance'];
			$orderDate =$lists[0]['order_date'];
			$range = $this->user_model->pigeon_inrange($orderDistance, $orderDate);
			foreach ($range as $key => $value) {
				// print_r($value['pigeon_speed']);
				$estTime = $value['pigeon_speed']>0 ? $orderDistance/$value['pigeon_speed'] : 0;
				$estCost = $orderDistance*$value['pigeon_cost'];
				
				$range[$key]['estimated_cost']=$estCost;
				$range[$key]['estimated_time']=$estTime;
			}
			$setting_fields = array(
					            "code" => "200",
					            "pigeons" => $range
					        );
			echo json_encode($setting_fields);
		}
		else
		{
			$setting_fields = array(
				            "code" => "404",
				            "message" => "No pigeon found!",
				        );
				        
				        $output_array = $setting_fields;
				        echo json_encode($output_array);
		}
	}

	public function more_pigeon()
	{
		$just = $this->user_model->more_check();
		// print_r($just);

		foreach ($just as $key) {
			$id = $key['pigeon_id'];

			// print_r($id);
			$st = $this->user_model->new_check($id);

			print_r($st);
			// if ($st == $id) {
			// 	print_r($st);
			// }
			// else
			// {
			// 	print_r("expression");
			// }
			
		}
		// print_r($st);
	}

	public function assign_orderto_pigeon()
	{
		$id = $this->input->post('pigeon_id');

		$order_id = $this->input->post('user_order_id');

		
		
		$or_id = $this->user_model->find_order($order_id);


		if(!empty($or_id))
		{
			$getid = $this->user_model->find_pigeon($id);
			if(!empty($getid))
			{

				$lists = $this->user_model->find_order($order_id);

				if(!empty($lists))
				{
					// print_r($lists);
					$orderDistance =$lists[0]['order_distance'];
					$orderDate =$lists[0]['order_date'];
					$range = $this->user_model->pigeon_inrange_valid($orderDistance, $orderDate, $id);
					if($range !== FALSE && $range->num_rows() > 0)
					{
						$data = array(
							'a_pigeon_id' => $id,
							'a_user_id' => $order_id
							);

						$check = $this->user_model->check_avai($id, $order_id);

						if(empty($check))
						{
								$assign = $this->user_model->assign_order($data);
								$order_status = $this->user_model->update_order_status($order_id);
								// $p_status = $this->user_model->update_pigeon_status($id);

								if($assign >0)
								{
									$setting_fields = array(
								            "code" => "200",
								            "message" => "Order Assign successfully"
								        );
								        
								        $output_array = $setting_fields;
								        // $output_array["data"] = $this->data;
								        echo json_encode($output_array);
								}
								else 
								{
									$setting_fields = array(
								            "code" => "402",
								            "message" => "Something Went Wrong"
								        );
								        
								        $output_array["settings"] = $setting_fields;
								        // $output_array["data"] = $this->data;
								        echo json_encode($output_array);
								}
						}

						else
						{
							$setting_fields = array(
								            "code" => "208",
								            "message" => "Order Already Assign"
								        );
									// $set_data = array(

									// 	);
								        
								        $output_array = $setting_fields;
								        // $output_array["data"] = $this->data;
								        echo json_encode($output_array);
						}

					}
					else
					{
						$setting_fields = array(
				            "code" => "404",
				            "message" => "No pigeon found!",
				        );
				        
				        $output_array = $setting_fields;
				        echo json_encode($output_array);
					}
				}
				else
				{
					$setting_fields = array(
						            "code" => "404",
						            "message" => "No pigeon found!",
						        );
						        
						        $output_array = $setting_fields;
						        echo json_encode($output_array);
				}

			}
			else{
				$setting_fields = array(
					            "code" => "405",
					            "message" => "Pigeon Id not exist"
					        );
					        
					        $output_array = $setting_fields;
					        // $output_array["data"] = $this->data;
					        echo json_encode($output_array);
			}	
		}
		else
		{
			$setting_fields = array(
					            "code" => "405",
					            "message" => "Order Id not exist"
					        );
					        
					        $output_array = $setting_fields;
					        // $output_array["data"] = $this->data;
					        echo json_encode($output_array);
		}
	}

	public function pigeon_leave()
	{

		$id = $this->input->post('pigeon_id');

		if($id != "")
		{
			$data = array(
				'l_pigeon_id'=> $id,
				'l_start_date' => $this->input->post('start_date'),
				'l_end_date' => $this->input->post('end_date'),
				'leave_type' => $this->input->post('leave_type'),
				);
			$new = $this->user_model->pigeon_leave($data);

			if($new > 0 && $new !='' )
			{

				$datas = $this->user_model->get_leave($new);
				// print_r($datas);

				$data = array(
						'leave_id' => $datas[0]['leave_id'],
						'pigeon_id' => $datas[0]['l_pigeon_id'],
						'start_date' => $datas[0]['l_start_date'],
						'end_date' => $datas[0]['l_end_date'],
						'leave_type' => $datas[0]['leave_type'],
						);

				// $p_status = $this->user_model->update_pigeon_status($id);
				$setting_fields = array(
					            "code" => "200",
					            "message" => "Leave added successfully"
					        );
					        
					        $output_array= $setting_fields;
					        $output_array['data'] = $data;
					        echo json_encode($output_array);
			}
			else
			{
				$setting_fields = array(
					            "code" => "402",
					            "message" => "Unable to add leave"
					        );
					        
					        $output_array["settings"] = $setting_fields;
					        // $output_array["data"] = $this->data;
					        echo json_encode($output_array);
			}
		}
		else
		{
			$setting_fields = array(
			            "code" => "405",
			            "message" => "Pigeon id is required!",
			        );
			        
			        $output_array = $setting_fields;
			        echo json_encode($output_array);
		}
	}

	public function remove_leave()
	{
		$id = $this->input->post('leave_id');
		$lists = $this->user_model->find_leave($id);

		if(!empty($lists))
		{
			$remove = $this->user_model->remove_leave($id);

			$setting_fields = array(
				            "code" => "200",
				            "message" => "Leave delete successfully!",
				        );
				        
				        $output_array = $setting_fields;
				        echo json_encode($output_array);
		}
		else
		{
			$setting_fields = array(
				            "code" => "404",
				            "message" => "No Leave found!",
				        );
				        
				        $output_array = $setting_fields;
				        echo json_encode($output_array);
		}

	}

	public function order_status()
	{
		

		$status = $this->input->post('status');
		$order_id = $this->input->post('order_id');
		$or_id = $this->user_model->find_order($order_id);


		if(!empty($or_id))
		{
			$get_status = $this->user_model->get_status($order_id);
			// print_r($get_status);

			if($get_status[0]['order_status'] == 'pending' && $status != 'complete')
			{
				$order_status = $this->user_model->update_ordered_status($order_id, $status);

				$setting_fields = array(
								            "code" => "200",
								            "message" => "Order status updated successfully"
								        );
								        
								        $output_array = $setting_fields;
								        echo json_encode($output_array);	
			}
			elseif($get_status[0]['order_status'] == 'accept' && $status != 'pending' && $status != 'accept' && $status != 'reject')
			{
				$order_status = $this->user_model->update_ordered_status($order_id, $status);

				$setting_fields = array(
								            "code" => "205",
								            "message" => "Order status updated successfully"
								        );
								        
								        $output_array = $setting_fields;
								        echo json_encode($output_array);	
			}
			elseif($get_status[0]['order_status'] == 'reject' && $status != 'pending' && $status != 'accept' && $status != 'complete')
			{
				$order_status = $this->user_model->update_ordered_status($order_id, $status);

				$setting_fields = array(
								            "code" => "205",
								            "message" => "Order status updated successfully"
								        );
								        
								        $output_array = $setting_fields;
								        echo json_encode($output_array);	
			}
			else
			{
				$setting_fields = array(
								            "code" => "402",
								            "message" => "Cannot update this order"
								        );
								        
								        $output_array = $setting_fields;
								        echo json_encode($output_array);	
			}
		}
		else
		{
			$setting_fields = array(
					            "code" => "405",
					            "message" => "Order Id not exist"
					        );
					        
					        $output_array = $setting_fields;
					        echo json_encode($output_array);
		}

	}


	public function get_invoice()
	{
		$order_id = $this->input->post('order_id');
		$or_id = $this->user_model->find_order($order_id);
		if(!empty($or_id))
		{
			$status =$or_id[0]['order_status'];	
			$orderDistance =$or_id[0]['order_distance'];
			$orderDate =$or_id[0]['order_date'];
			$user_id =$or_id[0]['o_user_id'];	
			$p_id = $this->user_model->pigeon_id($order_id);
			

			if($status == 'complete')
			{
				$new_data = $this->user_model->find_pigeon($p_id);
				$speed = $new_data[0]['pigeon_speed'];
				$range=  $new_data[0]['pigeon_range'];
				$cost= $new_data[0]['pigeon_cost'];

				$estTime = $speed>0 ? $orderDistance/$speed : 0;
				$estCost = $orderDistance*$cost;
				
				$data = array(
					'user_id' => $user_id,
					'order_id' => $order_id,
					'order_date' => $orderDate,
					'order_distance' => $orderDistance,
					'pigeon_speed' => $speed,
					'pigeon_cost' => $cost,
					'total_time' => $estTime,
					'total_cost' => $estCost
					);

				$setting_fields = array(
					            "code" => "200",
					            "message" => "Invoice generated"
					        );
					        
					        $output_array = $setting_fields;
					        $output_array['data'] = $data;
					        echo json_encode($output_array);


				// print_r($new_data);
			}
			else
			{
				print_r('error');
			}		

		}
		else
		{
			$setting_fields = array(
					            "code" => "405",
					            "message" => "Order Id not exist"
					        );
					        
					        $output_array = $setting_fields;
					        echo json_encode($output_array);
		}

	}
}