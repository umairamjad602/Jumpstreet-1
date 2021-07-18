<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{   
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = 'Reports';
        $this->load->model('model_reports');
        $this->load->model('model_stores');
        $this->file_path = realpath(APPPATH . '../assets/csv');
    }

    /* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
    public function index()
    {
        if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $start_from = date('Y-m-d');
        $end_to = (DateTime::createFromFormat('Y-m-d', date('Y-m-d')))->modify('+1 day')->format('Y-m-d');

        if($this->input->post('start_from')) {
            $start_from = $this->input->post('start_from');
        }
        if($this->input->post('end_to')) {
            $end_to = DateTime::createFromFormat('Y-m-d',  $this->input->post('end_to'))->modify('+1 day')->format('Y-m-d');
        }

        $period = new DatePeriod(new DateTime($start_from), new DateInterval('P1D'), new DateTime($end_to));
        $daysArray = array();

        foreach ($period as $key => $value)
            $daysArray [] = $value->format('Y-m-d');

        $order_data = $this->model_reports->getOrderDataByStartToEnd($start_from,$end_to);

        $final_order_data = array();
        foreach ($daysArray as $dk => $dv) {
            $sum = 0;
            foreach ($order_data as $k => $v) {
                if($dv == $v['date_time']){
                    $sum += $v['net_amount'];
                }
            }
            $final_order_data[$dv] = $sum;
        }

        $this->data['company_currency'] = $this->company_currency();
        $this->data['start_from'] = $start_from;
        $this->data['end_to'] = $end_to;
        $this->data['days'] = $daysArray;
        $this->data['results'] = $final_order_data;

        $this->render_template('reports/index', $this->data);

    }
    public function discount(){
        if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['page_title'] = 'Discount';
        $this->render_template('reports/discount', $this->data);        
    }
    public function show_discount(){
        if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $post = $this->input->post();
        $from_date = strtotime($this->input->post('start_from'));
        $end_to = strtotime($this->input->post('end_to'));

        $get_discount = $this->db->query("SELECT * from orders where date_time >= '$from_date' and date_time <= '$end_to'")->result_array(); 
        // echo $this->db->last_query();
        // echo "<pre>"; print_r($get_discount); 

        $tot_discount = 0;
        $tot_am = 0;
        foreach ($get_discount as $dis) {
            if ($dis['discount'] > 0) {
                $tot_discount += ($dis['discount']/100) * $dis['gross_amount'];
            }
            $tot_am += $dis['net_amount'];
        }
        // echo $tot_discount; die();


        $this->data['page_title'] = 'Discount';
        $this->data['discount'] = $get_discount;
        $this->data['total_discount'] = $tot_discount;
        $this->data['tot_am'] = $tot_am;
        $this->data['start_from'] = $this->input->post('start_from');
        $this->data['end_to'] = $this->input->post('end_to');
        $this->render_template('reports/show_discount', $this->data);        
    }
    public function storewiseByStartToEnd()
    {

        if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $start_from = date('Y-m-d');
        $end_to = (DateTime::createFromFormat('Y-m-d', date('Y-m-d')))->modify('+1 day')->format('Y-m-d');

        if($this->input->post('start_from')) {
            $start_from = $this->input->post('start_from');
        }
        if($this->input->post('end_to')) {
            $end_to = DateTime::createFromFormat('Y-m-d',  $this->input->post('end_to'))->modify('+1 day')->format('Y-m-d');
        }

        $period = new DatePeriod(new DateTime($start_from), new DateInterval('P1D'), new DateTime($end_to));
        $daysArray = array();

        foreach ($period as $key => $value)
            $daysArray [] = $value->format('Y-m-d');



        $store_data = $this->model_stores->getStoresData();

        if($store_data) {
            $store_id = $store_data[0]['id'];

            if ($this->input->post('select_store')) {
                $store_id = $this->input->post('select_store');
            }

            $order_data = $this->model_reports->getStoreWiseOrderDataByStartToEnd($start_from,$end_to,$store_id);

            $this->data['days'] = $daysArray;

            $final_parking_data = array();
            foreach ($daysArray as $dk => $dv) {
                $sum = 0;
                foreach ($order_data as $k => $v) {
                    if($dv == $v['date_time'] && $store_id == $v['store_id']){
                        $sum += $v['net_amount'];
                    }
                }
                $final_parking_data[$dv] = $sum;
            }

            $this->data['selected_store'] = $store_id;
            $this->data['store_data'] = $store_data;
            $this->data['company_currency'] = $this->company_currency();
            $this->data['results'] = $final_parking_data;
            $this->data['start_from'] = $start_from;
            $this->data['end_to'] = $end_to;

            $this->render_template('reports/storewise', $this->data);
        }else{
            $this->data['selected_store'] = array();
            $this->data['store_data'] = array();
            $this->data['company_currency'] = array();
            $this->data['results'] = array();
            $this->data['start_from'] = $start_from;
            $this->data['end_to'] = $end_to;
            $this->render_template('reports/storewise', $this->data);
        }
    }

    public function storewise()
    {

        if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $today_year = date('Y');

        $store_data = $this->model_stores->getStoresData();

        if($store_data) {
            $store_id = $store_data[0]['id'];


            if ($this->input->post('select_store')) {
                $store_id = $this->input->post('select_store');
            }

            if ($this->input->post('select_year')) {
                $today_year = $this->input->post('select_year');
            }

            $order_data = $this->model_reports->getStoreWiseOrderData($today_year, $store_id);
            $this->data['report_years'] = $this->model_reports->getOrderYear();


            $final_parking_data = array();
            foreach ($order_data as $k => $v) {

                if (count($v) > 1) {
                    $total_amount_earned = array();
                    foreach ($v as $k2 => $v2) {
                        if ($v2) {
                            $total_amount_earned[] = $v2['net_amount'];
                        }
                    }
                    $final_parking_data[$k] = array_sum($total_amount_earned);
                } else {
                    $final_parking_data[$k] = 0;
                }


            }

            $this->data['selected_store'] = $store_id;
            $this->data['store_data'] = $store_data;
            $this->data['selected_year'] = $today_year;
            $this->data['company_currency'] = $this->company_currency();
            $this->data['results'] = $final_parking_data;

            $this->render_template('reports/storewise', $this->data);
        }else{
            $this->data['selected_store'] = array();
            $this->data['store_data'] = array();
            $this->data['selected_year'] = array();
            $this->data['company_currency'] = array();
            $this->data['results'] = array();
            $this->render_template('reports/storewise', $this->data);
        }
    }
}   