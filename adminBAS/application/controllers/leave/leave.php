<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('admin/mod_admin');
        $this->load->model('payroll/mod_payrolls');
        $this->load->model('leave/mod_leave');
        $this->load->model('messages/mod_messages');
        $this->load->model('common/mod_common');
        $this->load->model('projects/mod_projects');
        $this->load->model('site_preferences/mod_preferences');
        $this->load->library('BreadcrumbComponent');
    }

    public function index() {
//         $this->session->userdata('permissions_arr');
        //Login Check
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(216, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 0;
        $data['PLUGIN_datepicker'] = 1;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 1;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 0;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = DEFAULT_TITLE;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');
        $this->breadcrumbcomponent->add('Leave', base_url() . 'leave/leave');

        //Get Assign Task Notificaitons
        $assign_tasks_notifiations = $this->mod_common->get_assign_task_notifiations();
        $data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
        $data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];

        //Get Inbox Unread Messsaes Notifications
        $inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
        $data['messages_arr'] = $inbox_unread_messages['messages_result'];
        $data['messages_count'] = $inbox_unread_messages['messages_count'];

        //Get Inbox Notifications
        $inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
        $data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
        $data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
        ///////////////////// End Top Notifications///////////////////////


        $data['INC_autoload_messages'] = $this->load->view('common/autoload_messages', $data, true);

        $this->breadcrumbcomponent->add($payroll_type_text, base_url() . 'payroll/manage-payrolls/add-payroll-entry' . $type);

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', '', true);

        // Getting All users
        $get_all_users = $this->mod_payrolls->get_admin_user_data();
        $data['admin_user_arr'] = $get_all_users['admin_user_arr'];
        $data['admin_user_count'] = $get_all_users['admin_user_count'];

//		echo "<pre>";print_r($this->session->all_userdata());exit;

        $this->load->view('leave/add_leave', $data);
    }

//end index()

    public function apply_leave_process() {
          //  echo "<pre>";print_r($this->input->post('ddays'));exit;
           // echo "<pre>";print_r($this->session->all_userdata());exit;
        $leave_type = $this->input->post('leave_type');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $created_by = $this->session->userdata('admin_id');

        $description = $this->input->post('description');
        $ini = array(
            'user_id' => $this->session->userdata('admin_id'),
            'leave_type' => $this->input->post('leave_type'),
            'from_date' => date("Y-m-d", strtotime($from_date)),
            'to_date' => date("Y-m-d", strtotime($to_date)),
            'description' => $description,
            'days' => $this->input->post('ddays'),
            'dated'=> date('Y-m-d'),
            'user_name' => $this->session->userdata('display_name'),
        );
//            echo "<pre>";
//        print_r($ini);exit;

        $this->mod_leave->apply_leave($ini);

        $leave_notification_arr = $this->mod_preferences->get_preferences_setting('leave-notifications-admin');
        $leave_from_txt = $leave_notification_arr['setting_value'];
        $leave_from_txt = explode(",", $leave_from_txt);
//            echo "<pre>";
//            print_r($leave_from_txt);            
//            exit;


        $roles = $this->mod_leave->where_in_db($leave_from_txt);
//            echo "<pre>";print_r($roles);exit;
        //Send Message to Assign Users
//		foreach($leave_from_txt as $leave => $val){
        foreach ($roles as $role => $val) {
//                    echo "<pre>";print_r($val);
            //Mesage id Generator
            $message_id = $this->mod_common->random_number_generator(7);
            $message_id = $this->mod_projects->message_id_generator($message_id);
//                    echo "<pre>";print_r($message_id);exit;
//            $subject = 'New Application Leave applied By: <b>' . $this->session->userdata('display_name') . '</b>';
//            SICK/CAUSAL LEAVE Application by APPLICANT NAME
            
//                    $message="Dear Admins, a new application is applied for leave. Please go to leave section to see more details. Thank  You!";
            if ($this->input->post('leave_type') == 'c') {
                $type = "Casual";
            } else if ($this->input->post('leave_type') == 's') {
                $type = "Sick";
            } else {
                $type = "Annual";
            }
            $subject = $type. ' LEAVE Application by ' . $this->session->userdata("display_name") ;
//                    echo $val['admin_role_id'];exit;
//                    echo "<pre>";print_r($val['admin_role_id']);
//                    $message="Dear ".$this->session->userdata('display_name')." you applied for the leave type ".$type." Your application notification is sent to the HR department for further processing Thank You!";

            if (strtolower($val['role_title']) == "hr manager" || strtolower($val['role_title']) == "hr & general services") {
               
                $message = "Hi, " . $this->session->userdata("display_name") . " has applied for the " . $type . " leave from ".$from_date." to ". $to_date. ". Take appropriate action accordingly.";
            } else {
//                $message = "Hi, " . $this->session->userdata("display_name") . ", " . $this->session->userdata('display_name') . " applied for " . $type . " leave for " . $this->input->post('ddays') . " days. HR department will further procecced on it.<br> Thank You!";
                $message = "Hi, " . $this->session->userdata("display_name") . " has applied for the " . $type . " leave from ".$from_date." to ". $to_date. ". Take appropriate action accordingly.";
            }

//                    echo "<pre>";print_r($message);exit;
//                    echo "<pre>";print_r($val['id']);exit;
            $to_user = $val['id'];

            $ins_msg_data = array(
                'to' => $this->db->escape_str(trim($to_user)),
                'from' => $this->db->escape_str(trim($created_by)),
                'subject' => $this->db->escape_str(trim($subject)),
                'message' => $this->db->escape_str(trim(nl2br($message))),
                'message_id' => $this->db->escape_str(trim($message_id)),
                'created_by' => $this->db->escape_str(trim($created_by)),
                'date' => $this->db->escape_str(trim(date("Y-m-d G:i:s"))),
                'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
                'notification' => $this->db->escape_str(trim(1)),
                'project_message_id' => 0,
                'attachment' => "",
                "last_modified_by" => ""
            );
//echo "<pre>"; print_r($ins_msg_data); exit;
            //Inserting the record into the database.
            $this->db->dbprefix('messages');
            $ins_into_db = $this->db->insert('messages', $ins_msg_data);
        }
//                exit;




        redirect(base_url() . 'leave/leave/view_leave');
    }

    //view leave
    public function view_leave() {
        //Login Check
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(217, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 0;
        $data['PLUGIN_datepicker'] = 1;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 1;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 0;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = DEFAULT_TITLE;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');
        $this->breadcrumbcomponent->add('Leave', base_url() . 'leave/leave');

        //Get Assign Task Notificaitons
        $assign_tasks_notifiations = $this->mod_common->get_assign_task_notifiations();
        $data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
        $data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];

        //Get Inbox Unread Messsaes Notifications
        $inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
        $data['messages_arr'] = $inbox_unread_messages['messages_result'];
        $data['messages_count'] = $inbox_unread_messages['messages_count'];

        //Get Inbox Notifications
        $inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
        $data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
        $data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
        ///////////////////// End Top Notifications///////////////////////


        $data['INC_autoload_messages'] = $this->load->view('common/autoload_messages', $data, true);

        $this->breadcrumbcomponent->add($payroll_type_text, base_url() . 'payroll/manage-payrolls/add-payroll-entry' . $type);

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', '', true);

        // Getting All users
        $get_all_users = $this->mod_payrolls->get_admin_user_data();
        $data['admin_user_arr'] = $get_all_users['admin_user_arr'];
        $data['admin_user_count'] = $get_all_users['admin_user_count'];

//                echo "<pre>";print_r( $this->session->all_userdata());exit;
        $user_id = $this->session->userdata("admin_id");
        if ($this->session->userdata("admin_role") == 'Super Admin' || $this->session->userdata("admin_role") == 'HR Admin') {
            $data['leaves'] = $this->mod_leave->get_all_leave_data();
//                    echo "<pre>";print_r($data['leaves']);exit;
        } else {
            $data['leaves'] = $this->mod_leave->get_leave_data($user_id);
        }



//                echo "<pre>";
//                print_r($data['leaves']);exit;

        $this->load->view('leave/view_leave', $data);
    }

    public function manage_leaves() {
        //Login Check
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(217, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 0;
        $data['PLUGIN_datepicker'] = 1;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 1;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 0;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = DEFAULT_TITLE;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');
        $this->breadcrumbcomponent->add('Leave', base_url() . 'leave/leave');

        //Get Assign Task Notificaitons
        $assign_tasks_notifiations = $this->mod_common->get_assign_task_notifiations();
        $data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
        $data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];

        //Get Inbox Unread Messsaes Notifications
        $inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
        $data['messages_arr'] = $inbox_unread_messages['messages_result'];
        $data['messages_count'] = $inbox_unread_messages['messages_count'];

        //Get Inbox Notifications
        $inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
        $data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
        $data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
        ///////////////////// End Top Notifications///////////////////////


        $data['INC_autoload_messages'] = $this->load->view('common/autoload_messages', $data, true);

        $this->breadcrumbcomponent->add($payroll_type_text, base_url() . 'payroll/manage-payrolls/add-payroll-entry' . $type);

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', '', true);

        // Getting All users
        $get_all_users = $this->mod_payrolls->get_admin_user_data();
        $data['admin_user_arr'] = $get_all_users['admin_user_arr'];
        $data['admin_user_count'] = $get_all_users['admin_user_count'];

//                echo "<pre>";print_r( $this->session->all_userdata());exit;
        $user_id = $this->session->userdata("admin_id");
        if ($this->session->userdata("admin_role") == 'Super Admin' || $this->session->userdata("admin_role") == 'HR Manager' || $this->session->userdata("admin_role") == 'HR & General Services' || $this->session->userdata("admin_role") == 'HR Admin') {
            $data['leaves'] = $this->mod_leave->get_all_leave_data();
//                    echo "<pre>";print_r($data['leaves']);exit;
        } else {
            $data['leaves'] = $this->mod_leave->get_leave_data($user_id);
        }

//                echo "<pre>";
//                print_r($data['leaves']);exit;

        $this->load->view('leave/manage_leaves', $data);
    }

    public function leave_approved_process() {
//            echo"<pre>";print_r($this->input->post());exit;
        $id = $this->input->post('id');
        $leave_pay_status = $this->input->post('checked');
        
        $created_by = $this->session->userdata('admin_id');
        
//            echo $leave_pay_status;exit;
//            echo"<pre>";print_r($leave_pay_status);exit;
        $this->mod_leave->leave_approved_process($id, $leave_pay_status);
        $data['leav'] = $this->mod_leave->getleavedata($id);
//        echo "<pre>";print_r($data['leav']);exit;
        $leave_notification_arr = $this->mod_preferences->get_preferences_setting('leave-notifications-admin');
        $leave_from_txt = $leave_notification_arr['setting_value'];
        $leave_from_txt = explode(",", $leave_from_txt);

//$message="Dear ". $data['leav']['0']['user_name'] ." your application is approved by HR  from date". $data['leav']['0']['from_date'] ." To date:" .$data['leav']['0']['to_date'].". Hope you will rejoin us in mentioned time. <br>Thank You!";



        $roles = $this->mod_leave->where_in_db($leave_from_txt);
//            echo "<pre>";print_r($roles);exit;
        //Send Message to Assign Users
        foreach ($roles as $role => $val) {
//             echo "<pre>";
//                  print_r($val);exit;
            //Mesage id Generator
            $message_id = $this->mod_common->random_number_generator(7);
            $message_id = $this->mod_projects->message_id_generator($message_id);
//            $subject = 'Application Status Updated By HR department.</b>';
//            $subject = 'Leave Application of APPLICANT NAME has been APPROVE/REJECT by HR Department';
            $subject = 'Leave Application of '.$data['leav']['0']['user_name'].' has been <b>APPROVE</b> by HR Department';
            if ($this->input->post('leave_type') == 'c') {
                $type = "Casual";
            } else if ($this->input->post('leave_type') == 's') {
                $type = "Sick";
            } else {
                $type = "Annual";
            }
//            $message = "Dear " . $val['first_name'] . " your application is approved by HR  from date" . $data['leav']['0']['from_date'] . " To date:" . $data['leav']['0']['to_date'] . ". Hope you will rejoin us in mentioned time. <br>Thank You!";
//Dear Shahid
//Amir Ali (HR Department) has approved/reject the leave application of APPLICANT NAME. He applied for the SICK/CAUSAL LEAVE from DATE to DATE.
            $message = "Dear " . $val['first_name'] . ", Amir Ali (HR Department) has approved the leave application of ". $data['leav']['0']['user_name'].". He applied for the ".$type." LEAVE from " . $data['leav']['0']['from_date'] . " To " . $data['leav']['0']['to_date'] .".";
//                  echo "<pre>";
//                  print_r($message);
            $to_user = $val['id'];
            $ins_msg_data = array(
                'to' => $this->db->escape_str(trim($to_user)),
                'from' => $this->db->escape_str(trim($created_by)),
                'subject' => $this->db->escape_str(trim($subject)),
                'message' => $this->db->escape_str(trim(nl2br($message))),
                'message_id' => $this->db->escape_str(trim($message_id)),
                'created_by' => $this->db->escape_str(trim($created_by)),
                'date' => $this->db->escape_str(trim(date("Y-m-d G:i:s"))),
                'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
                'notification' => $this->db->escape_str(trim(1))
            );
//                              echo "<pre>";
//                  print_r($ins_msg_data);exit;
            //Inserting the record into the database.
            $this->db->dbprefix('messages');
            $ins_into_db = $this->db->insert('messages', $ins_msg_data);
        }
        
    }

// end of leave_approved_process function

    public function leave_Reject_process() {

//            echo"<pre>";print_r($this->input->post());exit;

        $id = $this->input->post('id');
        $disapprove = $this->input->post('disapprove');
        $this->mod_leave->leave_disapproved_process($id, $disapprove);
        $data['leav'] = $this->mod_leave->getleavedata($id);

        $leave_notification_arr = $this->mod_preferences->get_preferences_setting('leave-notifications-admin');
        $leave_from_txt = $leave_notification_arr['setting_value'];
        $leave_from_txt = explode(",", $leave_from_txt);

        $roles = $this->mod_leave->where_in_db($leave_from_txt);
//            echo "<pre>";print_r($roles);exit;
        //Send Message to Assign Users
        foreach ($roles as $role => $val) {
            //Mesage id Generator
            $message_id = $this->mod_common->random_number_generator(7);
            $message_id = $this->mod_projects->message_id_generator($message_id);
            $subject = 'Leave Application of '.$data['leav']['0']['user_name'].' has been <b>APPROVE</b> by HR Department';
            if ($this->input->post('leave_type') == 'c') {
                $type = "Casual";
            } else if ($this->input->post('leave_type') == 's') {
                $type = "Sick";
            } else {
                $type = "Annual";
            }
//            $message = "Dear " . $val['first_name'] . " your application is disapproved by HR  that you applied from date" . $data['leav']['0']['from_date'] . " To date:" . $data['leav']['0']['to_date'] . ". Due to the following reason. <b>" . $data['leav']['0']['disapprove_reason'] . "</b> Hope you will respect our descion. <br>Thank You!";
$message = "Dear " . $val['first_name'] . ", Amir Ali (HR Department) has been rejected the leave application of ". $data['leav']['0']['user_name'].". He applied for the ".$type." LEAVE from " . $data['leav']['0']['from_date'] . " To " . $data['leav']['0']['to_date'] .".";
//                    echo "<pre>";
//                                        print_r($val);exit;
            $to_user = $val['id'];
            $ins_msg_data = array(
                'to' => $this->db->escape_str(trim($to_user)),
                'from' => $this->db->escape_str(trim($created_by)),
                'subject' => $this->db->escape_str(trim($subject)),
                'message' => $this->db->escape_str(trim(nl2br($message))),
                'message_id' => $this->db->escape_str(trim($message_id)),
                'created_by' => $this->db->escape_str(trim($created_by)),
                'date' => $this->db->escape_str(trim(date("Y-m-d G:i:s"))),
                'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),
                'notification' => $this->db->escape_str(trim(1))
            );
            //Inserting the record into the database.
            $this->db->dbprefix('messages');
            $ins_into_db = $this->db->insert('messages', $ins_msg_data);
        }
//                exit;

        redirect(base_url() . 'leave/leave/view_leave');
    }

    public function leave_history($id) {
        //Login Check
        $this->mod_admin->verify_is_admin_login();
        //Verify if Page is Accessable
        if (!in_array(217, $this->session->userdata('permissions_arr'))) {
            redirect(base_url() . 'errors/page-not-found-404');
            exit;
        }//end if
        //Plugin Files Permission
        $data['PLUGIN_datagrid'] = 0;
        $data['PLUGIN_datepicker'] = 1;
        $data['PLUGIN_gcal'] = 0;
        $data['PLUGIN_form_validation'] = 1;
        $data['PLUGIN_gallery'] = 0;
        $data['PLUGIN_ckeditor'] = 0;
        $data['PLUGIN_floatchart'] = 0;

        //Common Includes
        $data['meta_title'] = DEFAULT_TITLE;
        $data['meta_keywords'] = DEFAULT_META_KEYWORDS;
        $data['meta_description'] = DEFAULT_META_DESCRIPTION;

        $fetch_nav_panel = $this->mod_common->fetch_admin_nav_panel();
        $data['nav_panel_arr'] = $fetch_nav_panel;

        //Bread crum
        $this->breadcrumbcomponent->add('Dashboard', base_url() . 'dashboard/dashboard');
        $this->breadcrumbcomponent->add('Leave', base_url() . 'leave/leave');

        //Get Assign Task Notificaitons
        $assign_tasks_notifiations = $this->mod_common->get_assign_task_notifiations();
        $data['assign_task_notifiations_arr'] = $assign_tasks_notifiations['assign_task_filter'];
        $data['assign_task_notifiations_count'] = $assign_tasks_notifiations['assign_task_count'];

        //Get Inbox Unread Messsaes Notifications
        $inbox_unread_messages = $this->mod_common->get_inbox_unread_messages();
        $data['messages_arr'] = $inbox_unread_messages['messages_result'];
        $data['messages_count'] = $inbox_unread_messages['messages_count'];

        //Get Inbox Notifications
        $inbox_notifications_messages = $this->mod_common->get_inbox_notifications();
        $data['inbox_notifications_arr'] = $inbox_notifications_messages['inbox_notifications_result'];
        $data['inbox_notifications_count'] = $inbox_notifications_messages['inbox_notifications_count'];
        ///////////////////// End Top Notifications///////////////////////


        $data['INC_autoload_messages'] = $this->load->view('common/autoload_messages', $data, true);

        $this->breadcrumbcomponent->add($payroll_type_text, base_url() . 'payroll/manage-payrolls/add-payroll-entry' . $type);

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

        $data['INC_header_script_top'] = $this->load->view('common/script_header', $data, true);
        $data['INC_header_script_footer'] = $this->load->view('common/script_footer', $data, true);
        $data['INC_top_header'] = $this->load->view('common/top_header', '', true);
        $data['INC_left_nav_panel'] = $this->load->view('common/left_nav_panel', $data, true);
        $data['INC_footer'] = $this->load->view('common/footer', '', true);
        $data['INC_breadcrum'] = $this->load->view('common/breadcrum', '', true);

        // Getting All users
        $get_all_users = $this->mod_payrolls->get_admin_user_data();
        $data['admin_user_arr'] = $get_all_users['admin_user_arr'];
        $data['admin_user_count'] = $get_all_users['admin_user_count'];

//                echo "<pre>";print_r( $this->session->all_userdata());exit;
//                $data['leaves'] = $this->mod_leave->get_leave_data($id);
        $data['leaves'] = $this->mod_leave->view_leave_history($id);


//                echo "<pre>";
//                print_r($data['leaves']);exit;

        $this->load->view('leave/leaves_history', $data);
    }

}

//end leave
