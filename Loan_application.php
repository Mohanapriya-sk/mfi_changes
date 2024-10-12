<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\admin\loan_application_model;
use App\Models\admin\location_model;
use App\Controllers\BaseController;

class Loan_application extends BaseController
{
    public $model;
    public function __construct()
    {
        helper(['form']);

        $this->model = new loan_application_model();

        $this->page_name = 'loan_application';

        $this->position_child = session()->get('position_child');

        $this->position_child_arr = explode(',', $this->position_child);

        $this->employee_child = session()->get('employee_child');

        $this->employee_child_arr = explode(',', $this->employee_child);

        $this->branch_child = session()->get('branch_child');

        $this->branch_dependents = session()->get('branch_dependents');

        $this->branch_child_arr = explode(',', $this->branch_child);

        $this->loan_application_documents_uploadPath = FCPATH . 'uploads/application_documents/';

    }

    public function index()
    {

        $data['breadcrumb1'] = ucfirst(str_replace("_", " ", $this->page_name));
        $data['breadcrumb2'] = 'Home';
        $data['breadcrumb3'] = 'list';
        $data['create_button'] = true;
        $data['back_button'] = false;
        $data['breadcrumb_url'] = base_url('/admin/add_loan_application');

        // $is_group_loan              = 'no';

        // $status_list                = [];

        // $from_date_filter           = $this->request->getVar('from_date_filter')??date('Y-m-d');

        // $to_date_filter             = $this->request->getVar('to_date_filter')??date('Y-m-d');

        // $date_filter                = $this->request->getVar('date_filter')??date('Y-m-d');

        // $branch_filter              = base64_decode($this->request->getVar('branch_filter'))??'';

        // $loan_type_filter           = ($this->request->getVar('loan_type_filter') != '')?base64_decode($this->request->getVar('loan_type_filter')):'';

        // $center_filter              = ($this->request->getVar('center_filter')!='')?base64_decode($this->request->getVar('center_filter')):'';

        // $employee_filter            = ($this->request->getVar('employee_filter') != '')?base64_decode($this->request->getVar('employee_filter')):'';

        // $customer_filter            = ($this->request->getVar('customer_filter') != '')?base64_decode($this->request->getVar('customer_filter')):'';

        // $status_filter              = ($this->request->getVar('status_filter') != '')?base64_decode($this->request->getVar('status_filter')):'';

        // $branch_where_in            = branch_where_in();

        // $data['filters']['status_filter']  =   [
        //                                             'show'     => false,
        //                                             'selected' => $status_filter,
        //                                             'list'     => []
        //                                         ];

        // if($loan_type_filter != '')
        // {   
        //     $is_group_loan          = $this->model->query("select group_loan from loan_type where loan_type_id = '$loan_type_filter'")->getResult('array')[0]; 

        //     $is_group_loan = $is_group_loan['group_loan'];

        //     $status_list            = $this->model->query("select loan_approval_stage_id as status_id,loan_approval_stage_name as status_name from loan_approval_stage  where loan_approval_stage_loan_type='$loan_type_filter' and loan_approval_stage_deleted='no'")->getResult('array'); 

        //     $data['filters']['status_filter']  =   [
        //                                                 'show'     => true,
        //                                                 'selected' => $status_filter,
        //                                                 'list'     => $status_list
        //                                             ];
        // }

        // $employee_where_in = " and employee_position_id in ($this->position_child)";

        // if($branch_filter != '')
        // {
        //     $center_where_in   = " and center_branch_id =".$branch_filter;
        //     $customer_where_in = " and customer_branch_id =".$branch_filter;
        //     $employee_where_in .= " and employee_position_branch_id =".$branch_filter;
        //     if($is_group_loan == 'yes')
        //     {
        //         $filter_center_list     = $this->model->query("select center_id,center_name,center_code,center_parent_id from center where center_status = 'active' and center_deleted = 'no' $center_where_in order by center_parent_id asc")->getResult('array');

        //         $data['filters']['center_filter']  = [
        //                                                 'show'     => true,
        //                                                 'selected' => $center_filter,
        //                                                 'list'     => $filter_center_list
        //                                               ];
        //         if($center_filter != '')
        //         {
        //             $customer_where_in = " and customer_center_id =".$center_filter;
        //         }

        //         $filter_customer_list     = $this->model->query("select customer_id,customer_name,customer_code,customer_aadhar_no from customer where  customer_deleted = 'no' $customer_where_in ")->getResult('array');

        //         $data['filters']['customer_filter']  =     [
        //                                                         'show'     => true,
        //                                                         'selected' => $customer_filter,
        //                                                         'list'     => $filter_customer_list
        //                                                     ];

        //     }else{

        //         $filter_center_list = [];

        //         $data['filters']['center_filter']  =   [
        //                                                     'show'     => false,
        //                                                     'selected' => $center_filter,
        //                                                     'list'     => $filter_center_list
        //                                                 ];

        //         $filter_customer_list     = $this->model->query("select customer_id,customer_name,customer_code,customer_aadhar_no from customer where  customer_deleted = 'no' $customer_where_in ")->getResult('array');

        //         $data['filters']['customer_filter']  =     [
        //                                                         'show'     => true,
        //                                                         'selected' => $customer_filter,
        //                                                         'list'     => $filter_customer_list
        //                                                     ];

        //     }
        // }else{
        //      $data['filters']['center_filter']  = [
        //                                                 'show'     => true,
        //                                                 'selected' => $center_filter,
        //                                                 'list'     => [],
        //                                            ];

        //      $data['filters']['customer_filter']  =     [
        //                                                     'show'     => true,
        //                                                     'selected' => $customer_filter,
        //                                                     'list'     => [],
        //                                                 ];
        // }




        // $filter_branch_list         = $this->model->query("select branch_id,branch_name,branch_parent_id,branch_code from branch where branch_status='active' and branch_deleted='no' $branch_where_in order by branch_parent_id,branch_name asc")->getResult('array');

        // $filter_loan_type_list      = $this->model->query("select group_loan,loan_type_id,loan_type from loan_type where loan_type_status='active' and loan_type_deleted='no'")->getResult('array');

        // $filter_employee_list       = $this->model->query("select position_id,concat(employee_position_name,' [',employee_name,'-',employee_code,']') as employee_name, employee_id,employee_position_primary_reporting_to from employee join employee_position on position_id =  employee_position_id where employee_deleted = 'no' $employee_where_in order by employee_position_primary_reporting_to asc")->getResult('array');




        // $data['filters']['from_date_filter']   =   [
        //                                                 'show'     => true,
        //                                                 'selected' => $from_date_filter,
        //                                             ];

        // $data['filters']['to_date_filter']     =   [
        //                                                 'show'     => true,
        //                                                 'selected' => $to_date_filter,
        //                                                 'min_range'=> $this->request->getVar('from_date_filter')
        //                                             ];

        // $data['filters']['date_filter']        =   [
        //                                                 'show'     => false,
        //                                                 'selected' => $date_filter,
        //                                             ];

        // $data['filters']['branch_filter']      =   [
        //                                                 'show'     => true,
        //                                                 'selected' => $branch_filter,
        //                                                 'list'     => $filter_branch_list
        //                                             ];


        // $data['filters']['loan_type_filter']   =   [
        //                                                 'show'     => true,
        //                                                 'selected' => $loan_type_filter,
        //                                                 'list'     => $filter_loan_type_list
        //                                             ];

        // $data['filters']['employee_filter']   =   [
        //                                             'show'     => true,
        //                                             'selected' => $employee_filter,
        //                                             'list'     => $filter_employee_list
        //                                         ];

        //  $data['filters']['loan_no_filter']   =   [
        //                                             'show'     => false,
        //                                             'selected' => '',
        //                                             'list'     => []
        //                                         ];

        // $data['filters']['filter_url']         = base_url('/admin/loan_application');


        $this->page_group = 'list';

        $this->arr_data = $data;

        return view('admin/loan_application/list', $this->format_data());

    }

    public function loan_application_list()
    {
        $requestData = $_REQUEST;

        $_REQUEST['start'];

        $columns = [
            0 => 'la_id',
            1 => 'loan_type',
            2 => 'la_no',
            3 => 'la_date',
            4 => 'branch_name',
            5 => 'center_name',
            6 => 'la_id',
            7 => 'applied_by',
            8 => 'status',
            9 => 'la_total_amount'
        ];



        $query = $this->model->select("la_approval_stage_level,la_final_stage,la_id,la_no,loan_type,branch_name,center_name,CONCAT(group_concat(DISTINCT(ep1.employee_position_name)),' (',group_concat(e1.employee_name),')') as loan_approver,CONCAT(ep2.employee_position_name,' (',e2.employee_name,')') as applied_by,la_date,la_total_members,la_total_amount,la_status as status,CASE
            WHEN la_status = 'sent_back' or la_status = 'forwarded' THEN loan_approval_stage_name
            ELSE la_status END as la_status")
            ->where(['la_deleted' => 'no'])
            ->where('la_status <>', 'approved')
            ->whereIn('la_branch_id', $this->branch_child_arr, false)
            ->join('branch', 'la_branch_id = branch_id', 'inner')
            ->join('center', 'la_center_id = center_id', 'left')
            ->join('loan_approval_stage', 'la_approval_stage = loan_approval_stage_id', 'left')
            ->join('loan_type', 'la_loan_type = loan_type_id', 'inner')
            ->join('employee_position ep1', 'FIND_IN_SET(ep1.employee_position_id,la_approval_stage_position_id) > 0 and la_branch_id = employee_position_branch_id', 'LEFT')
            ->join('employee e1', 'ep1.employee_position_id = e1.position_id', 'LEFT')
            ->join('employee_position ep2', 'la_applied_by_position_id = ep2.employee_position_id', 'inner')
            ->join('employee e2', 'la_applied_by_employee_id = e2.employee_id', 'inner')
            ->groupBy('la_id');
        $this->model->groupStart();
        foreach ($this->position_child_arr as $pos_key => $pos_val) {
            if ($pos_key == 0)
                $this->model->where("FIND_IN_SET(" . $pos_val . ",la_approval_stage_position_id) > 0");
            else
                $this->model->orWhere("FIND_IN_SET(" . $pos_val . ",la_approval_stage_position_id) > 0");
        }
        $this->model->groupEnd();

        $totalData = $this->model->countAllResults();

        $query = $this->model->getLastQuery()->getQuery();

        $query = "select `" . rtrim(ltrim($query, "SELECT COUNT(*) AS `numrows`\n\FROM ("), ') CI_count_all_results');

        $query .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $list_data = $this->model->query($query)->getResult('array');

        $totalFiltered = count($list_data);

        $i = $_REQUEST['start'];

        if ($totalData > 0) {
            foreach ($list_data as $list_key => $val) {
                $edit_btn = '';
                $delete_btn = '';
                $history_btn = '';
                $i += 1;

                if ($_SESSION['show_edit'] == 'yes' && $val['la_status'] !== 'approved' && $val['la_status'] !== 'rejected') {
                    $edit_btn = '<a  href=add_loan_application/' . base64_encode($val['la_id']) . '><i class="la la-edit" style="font-size: 20px;color: blue;"></i></a>';
                }

                if ($_SESSION['show_delete'] == 'yes' && $val['la_approval_stage_level'] == 1 && ($val['status'] == 'hold' || $val['status'] == 'forwarded') && $i == 1) {
                    $delete_btn = '<a href="#" onclick=delete_data("delete_loan_application/' . base64_encode($val['la_id']) . '")><i class="la la-trash" style="font-size: 20px;color: red;"></i></a>';
                }
                $history_btn = '<a data-remote="true"  href="' . base_url('admin/loan_application_history') . '/' . base64_encode($val['la_id']) . '" title="Loan Application History"  data-toggle="modal" data-target="#la_history_modal"><i class="la la-history" style="font-size: 20px;color: orange;"></i></a>';

                $nestedData = array();
                $nestedData[] = $i . '.&nbsp;&nbsp;&nbsp;' . $edit_btn . ' ' . $delete_btn . ' ' . $history_btn;
                $nestedData[] = $val['loan_type'];
                $nestedData[] = $val['la_no'];
                $nestedData[] = format_date($val['la_date']);
                $nestedData[] = $val['branch_name'];
                $nestedData[] = $val['center_name'];
                $nestedData[] = $val['loan_approver'];
                $nestedData[] = $val['applied_by'];
                $nestedData[] = ucfirst($val['la_status']);
                $nestedData[] = $val['la_total_amount'] . ' (' . $val['la_total_members'] . ' Nos)';
                $data[] = $nestedData;
            }
            $json_data = array(
                "draw" => intval($_REQUEST['draw']),
                "recordsTotal" => $totalFiltered,
                "recordsFiltered" => $totalData,
                "data" => $data
            );

        } else {
            $json_data = array(
                "draw" => "",
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => "",
            );
        }

        echo json_encode($json_data);
    }

    public function deleteFile()
    {
        $index = $this->request->getPost('index');
        $fileName = $this->request->getPost('file_name');
        $la_id = $this->request->getPost('la_id');
        log_message('info', 'Uploaded files: ' . $index . $fileName . $la_id);


        $filePath = $this->loan_application_documents_uploadPath . $fileName;

        log_message('info', 'Uploaded filePath: ' . $filePath);
        $existingDocumentsQuery = $this->model->query("SELECT la_loan_application_documents FROM `loan_application` WHERE la_deleted = 'no' AND la_id = ?", [$la_id]);
        $result = $existingDocumentsQuery->getResultArray();

        if (!empty($result)) {
            $existingDocuments = $result[0]['la_loan_application_documents'];
            log_message('info', 'Existing documents: ' . $existingDocuments);


            $fileNames = explode(',', $existingDocuments);


            foreach ($fileNames as $key => $value) {
                if ($value === $fileName) {
                    $fileNames[$key] = '';
                }
            }


            $updatedFileNamesString = implode(',', $fileNames);
            log_message('info', 'Updated file names: ' . $updatedFileNamesString);

            $this->model->query("UPDATE `loan_application` SET la_loan_application_documents = ? WHERE la_id = ?", [$updatedFileNamesString, $la_id]);

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    log_message('info', 'File deleted from server: ' . $fileName);
                } else {
                    log_message('error', 'Unable to delete the file from the server: ' . $fileName);
                    return $this->response->setJSON(['success' => false, 'message' => 'Unable to delete the file from the server.']);
                }
            } else {
                log_message('info', 'File not found on the server, but reference is removed from the database.');
            }

            return $this->response->setJSON(['success' => true, 'message' => 'File reference deleted successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Loan application not found.']);
        }

    }

    public function add_loan_application($id = '')
    {
        $id = ($id == '') ? '' : base64_decode($id);
        $data['breadcrumb1'] = ucfirst(str_replace("_", " ", $this->page_name));
        $data['breadcrumb2'] = 'Home';
        $data['breadcrumb3'] = 'Add';
        $data['create_button'] = false;
        $data['back_button'] = true;
        $data['breadcrumb_url'] = base_url('/admin/loan_application');
        $data['save_url'] = base_url('/admin/save_loan_application');
        $data['back_url'] = base_url('/admin/loan_application');

        $branch_where_in = branch_where_in();

        $data['branch'] = $this->model->query("select branch_id,branch_name,branch_parent_id,branch_code from branch where branch_status='active' and branch_deleted='no' $branch_where_in order by branch_id asc")->getResult('array');

        $data['loan_type'] = $this->model->query("select is_product_defined,group_loan,loan_type_id,loan_type from loan_type where loan_type_status='active' and loan_type_deleted='no'")->getResult('array');

        $data['loan_sub_detail'] = [];

        if ($id != '') {
            $data['save_url'] = base_url('/admin/save_loan_application/' . base64_encode($id));

            $data['edit_details'] = $this->model->join('loan_approval_stage', 'loan_approval_stage_loan_type = la_loan_type and la_approval_stage_level = loan_approval_stage_level')->join('loan_type', 'loan_type_id = la_loan_type')->where(['la_id' => $id, 'la_deleted' => 'no', 'loan_approval_stage_deleted' => 'no', 'loan_approval_stage_status' => 'active'])->first();

            //echo $this->model->getLastQuery()->getQuery();exit;

            $loan_type = $data['edit_details']['la_loan_type'];

            $branch_id = $data['edit_details']['la_branch_id'];

            $group_loan = $data['edit_details']['group_loan'];

            $stage_level = $data['edit_details']['la_approval_stage_level'];

            $customer_id = $data['edit_details']['la_customer_id'];

            $stage_level_query = $this->model->query("select * from loan_approval_stage where loan_approval_stage_loan_type = '$loan_type' and loan_approval_stage_level = '$stage_level' and loan_approval_stage_status = 'Active' and loan_approval_stage_deleted = 'no'")->getResult('array');

            $is_current_level_final = $stage_level_query[0]['is_final_stage'];

            $center_or_customer_id = ($group_loan == 'yes') ? $data['edit_details']['la_center_id'] : $data['edit_details']['la_customer_id'];

            if ($stage_level == 1) {
                $data['edit_details']['is_first_stage'] = 0;
            } else {
                $data['edit_details']['is_first_stage'] = 1;
            }

            $data['edit_details']['la_previous_approval_stage'] = $data['edit_details']['la_approval_stage'];

            $data['edit_details']['la_previous_approval_stage_level'] = $data['edit_details']['la_approval_stage_level'];

            $data['edit_details']['la_previous_approval_stage_position_id'] = $data['edit_details']['la_approval_stage_position_id'];

            $data['edit_details']['la_previous_approval_stage_employee_id'] = $data['edit_details']['la_approval_stage_employee_id'];

            $data['loan_sub_detail'] = $this->model->query("select * from loan_application_sub where las_la_id = '$id' and las_deleted = 'no'")->getResult('array');

            foreach ($data['loan_sub_detail'] ?? [] as $ls_key => $ls_val) {
                $data['details'][$ls_val['las_customer_id']] = $ls_val;
            }

            $data['house_type'] = $this->model->query("select house_type_id,house_type from house_type where house_type_status='active' and house_type_deleted = 'no'")->getResult('array');

            $data['occupation'] = $this->model->query("select occupation_id,occupation_name from occupation where occupation_status='active' and occupation_deleted = 'no'")->getResult('array');

            $data['product'] = $this->model->query("select product_id,product_name,product_amount from product where product_status='active' and product_deleted = 'no' and product_loan_type = '$loan_type'")->getResult('array');

            // $data['loan_application_history'] = $this->model->query("select lah_date,las1.loan_approval_stage_name,lah_la_id,lah_las_id,las2.loan_approval_stage_name as lah_moved_to,lah_approval_description,lah_status,employee_position_name,employee_name from loan_application_history join employee on employee_id = lah_action_by_employee_id join employee_position on employee_position_id = lah_action_by_position_id left join loan_approval_stage as las1 on las1.loan_approval_stage_id = lah_approval_stage left join loan_approval_stage as las2 on las2.loan_approval_stage_id  = lah_moved_to  where lah_la_id = '$id' group by lah_action_by_employee_id")->getResult('array');

            $data['loan_reject_reason'] = $this->model->query("select loan_reject_reason_id,loan_reject_reason from loan_reject_reason where loan_reject_reason_status = 'active' and loan_reject_reason_deleted='no'")->getResult('array');

            if ($data['edit_details']['la_center_id'] != '0') {
                $data['customer_details'] = $this->model->query("select las_id,customer_id,customer_name,customer_aadhar_no,customer_center_head from customer join loan_application_sub on las_customer_id = customer_id and las_la_id = '$id' and las_deleted= 'no' left join loan_disbursement_details on customer_id = ldd_customer_id and ldd_loan_type = '$loan_type' and ldd_ld_status = 'not_completed' and ldd_deleted = 'no' where  customer_branch_id = '$branch_id' and customer_center_id = '$center_or_customer_id'  and customer_status = 'active' and customer_deleted= 'no' and  ldd_id is null  order by customer_name asc")->getResult('array');
            } else {

                $data['customer_details'] = $this->model->query("select las_id,customer_id,customer_name,customer_aadhar_no from loan_application_sub join customer on las_customer_id = customer_id where las_customer_id = '$customer_id'  and las_la_id = '$id'  and las_deleted= 'no' order by customer_name asc")->getResult('array');


            }
            $data['group_loan'] = $group_loan;

            $is_product_defined = $this->model->query("select group_loan,is_product_defined from loan_type where loan_type_id = '$loan_type'")->getResult('array')[0];

            $data['is_product_defined'] = $is_product_defined['is_product_defined'];

            $data['gst_enabled'] = get_config_value('gst_enabled');

            $data['enable_extra_charge'] = get_config_value('enable_extra_charge');

            $data['extra_charge_label'] = get_config_value('extra_charge_label');

            $data['customer_details_view'] = view('admin/loan_application/customer_details', $data);

            $data['customer_or_center_field'] = $this->get_field_by_loan_type($branch_id, $group_loan, '', 'function_call', $center_or_customer_id);

            $stage_level = ($is_current_level_final == 'no') ? $stage_level += 1 : $stage_level;

            $data['loan_approval_stage'] = $this->model->query("select is_product_defined,group_loan,loan_type_approval_required,loan_approval_stage_id,loan_approval_stage_level,loan_approval_stage_name,is_final_stage,group_concat(distinct(employee_position_id)) as position_id from loan_approval_stage join employee_position on employee_position_role_id = loan_approval_stage_approver_id and employee_position_deleted = 'no' and employee_position_status = 'active' join loan_type on loan_type_id = loan_approval_stage_loan_type  where loan_approval_stage_level =  '$stage_level' and  loan_approval_stage_loan_type = '$loan_type'  and  loan_approval_stage_status = 'active' and loan_approval_stage_deleted='no' order by loan_approval_stage_level asc limit 1")->getResult('array')[0];

            //and employee_position_branch_id in ($this->branch_dependents)

            $data['loan_approval_stage']['group_loan'] = $group_loan;

            $data['staff_list'] = $this->model->query("select employee_id,employee_name,employee_code from employee_position join employee on FIND_IN_SET(employee_id,employee_position_employee_id) > 0 and employee_status != 'relieved' and employee_deleted = 'no' where employee_position_branch_id = '$branch_id' and employee_position_id in (" . session()->get('position_child') . ") and employee_id in (" . session()->get('employee_child') . ") and employee_status!='relieved' and employee_deleted = 'no' group by employee_id order by employee_name asc")->getResult('array');
        }
        $data['enable_collection_slot'] = get_config_value('enable_collection_slot');

        $uploaded_files = [];
        if (isset($data['edit_details']['la_loan_application_documents']) && !empty($data['edit_details']['la_document_names'])) {
            $document_file_names = explode(',', $data['edit_details']['la_loan_application_documents']);

            foreach ($document_file_names as $fileName) {
                $uploaded_files[] = $fileName;
            }
        }
        if (isset($data['edit_details']['la_document_names']) && !empty($data['edit_details']['la_document_names'])) {

            $document_names = $data['edit_details']['la_document_names'];
            $document_names_array = explode(',', $document_names);
            $no_of_documents = (int) $data['edit_details']['la_no_of_documents'];
        } else {

            $document_names = get_config_value('document_names');
            $document_names_array = explode(',', $document_names);
            $no_of_documents = 0;
        }
        if ($no_of_documents == 0) {
            $no_of_documents = (int) get_config_value('no_of_loan_application_documents');
        }

        $data['uploaded_files'] = $uploaded_files;

        $document_names = get_config_value('document_names');
        // $document_names_array = explode(',', $document_names);
        // $data['no_of_loan_application_documents'] = get_config_value('no_of_loan_application_documents');
        // $data['document_names'] = array_slice($document_names_array, 0, (int)$data['no_of_loan_application_documents']);

        $data['document_names'] = array_slice($document_names_array, 0, $no_of_documents);
        $data['no_of_loan_application_documents'] = $no_of_documents;


        $this->page_group = 'form';
        $this->arr_data = $data;
        return view('admin/loan_application/form', $this->format_data());
    }

    public function delete_loan_application($id = '')
    {
        $id = ($id == '') ? '' : base64_decode($id);
        $data['la_deleted'] = 'yes';
        $data['la_id'] = $id;
        $data['la_deleted_by'] = session()->get('user_id');
        $this->model->query("update loan_application_sub set las_deleted='yes' where las_la_id = '$id'");
        $this->model->save($data);
        return redirect()->to(base_url('/admin/loan_application'));

    }

    public function save_loan_application($id = '')
    {
        $id = ($id == '') ? '' : base64_decode($id);

        $data = [];

        foreach ($this->request->getVar() as $key => $val) {
            $data[$key] = $val;
        }

        //pr($data,'s');

        if ($data['la_status'] != 'rejected') {
            $data['la_reject_reason'] = '';
        }

        if (isset($data['product_amount'])) {
            $data['la_total_amount'] = array_sum($data['product_amount']);
        } else {
            $data['la_total_amount'] = $data['la_proposed_amount'];
        }


        $rules = [
            'la_date' => 'required',
        ];

        if ($this->validate($rules)) {

            $auto_approve = get_config_value('auto_approve_loan');

            $data['la_total_members'] = count($data['customer_id_check']);

            $data['la_approval_stage_employee_id'] = session()->get('user_id');


            if ($auto_approve == 'yes' || $data['loan_type_approval_required'] == 'no') {
                $last_stage = $this->model->query("select loan_approval_stage_level,loan_approval_stage_id from loan_approval_stage where is_final_stage='yes' and loan_approval_stage_loan_type =  '$data[la_loan_type]'")->getResult('array');

                $data['la_status'] = 'approved';
                $data['la_auto_approved'] = 'yes';
                $data['la_status_description'] = 'Auto Approved';
                $data['la_approval_stage'] = $last_stage[0]['loan_approval_stage_id'];
                $data['la_approval_stage_level'] = $last_stage[0]['loan_approval_stage_level'];
                $data['la_final_stage'] = 'yes';
                $data['la_sanctioned_amount'] = $data['la_proposed_amount'];
            }
            // else{
            //    if($data['loan_type_approval_required'] == 'no')
            //    {
            //        $last_stage = $this->model->query("select loan_approval_stage_id from loan_approval_stage where is_final_stage='yes' and loan_approval_stage_loan_type =  '$data[la_loan_type]'")->getResult('array');

            //         $data['la_status']              = 'approved';
            //         $data['la_auto_approved']       = 'yes';
            //         $data['la_status_description']  = 'Auto Approved';
            //         $data['la_approval_stage']      = $last_stage[0]['loan_approval_stage_id'];
            //    }
            // }

            if ($data['la_previous_approval_stage'] == 0)
                $data['la_created_by'] = session()->get('user_id');


            $action_emp_id = session()->get('user_employee_id');
            $action_pos_id = session()->get('user_position_id');
            $date = $data['la_date'];
            $data['la_action_taken_position_id'] = $action_pos_id;

            $moved_from = $data['la_previous_approval_stage'];

            if ($data['la_status'] == 'sent_back') {

                $data['la_final_stage'] = 'no';

                $approval_level = $data['la_previous_approval_stage_level'] - 1;

                $stage_details = $this->model->query("select loan_approval_stage_id,loan_approval_stage_level,group_concat(employee_position_id) as position_id from loan_approval_stage  join employee_position on employee_position_role_id = loan_approval_stage_approver_id and employee_position_deleted = 'no' and employee_position_status = 'active'  where loan_approval_stage_level = '$approval_level' and loan_approval_stage_loan_type = '$data[la_loan_type]' and employee_position_branch_id = '$data[la_branch_id]' and  loan_approval_stage_status = 'active' and loan_approval_stage_deleted='no' ")->getResult('array');
                //echo $this->model->getLastQuery()->getQuery().'<br>';
                //pr($stage_details,'s');
                $data['la_approval_stage'] = $stage_details[0]['loan_approval_stage_id'] ?? 0;

                $data['la_approval_stage_level'] = $stage_details[0]['loan_approval_stage_level'] ?? 0;

                $data['la_approval_stage_position_id'] = $stage_details[0]['position_id'] ?? 0;
            }

            if ($data['la_is_group_loan'] == 'yes') {
                $staff_det_center_id = $data['la_center_id'];
                $staff_details = $this->model->query("select center_sales_staff_id,center_collection_staff_id from center where center_id = '$staff_det_center_id'")->getResult('array')[0];
                $data['la_collection_staff'] = $staff_details['center_sales_staff_id'];
                $data['la_applied_by_employee_id'] = $staff_details['center_collection_staff_id'];
            }

            //pr($data,'s');
            if ($id == '') {
                $data['la_applied_by_position_id'] = $this->model->query("select position_id from employee where employee_id = '$data[la_applied_by_employee_id]'")->getResult('array')[0]['position_id'];
                //loan number generate
                $loan_no = $this->model->query("SELECT la_no FROM `loan_application` where la_deleted = 'no' order by la_id desc LIMIT 1")->getResult('array');

                $la_no = $loan_no[0]['la_no'] ?? "";

                $data['la_no'] = ((int) $la_no == 0 || $la_no == "") ? '1001' : (int) $la_no + 1;



                // $document_uploads = $this->request->getFileMultiple('document_uploads');
                $uploaded_files = [];

                $document_uploads = $this->request->getFiles();
                $document_names = '';
                // log_message('info', 'Request document_uploads: ' . print_r($document_uploads, true));
                if (!empty($document_uploads))
                // log_message('info', 'Uploaded files: ' . print_r($_FILES, true));
                {
                    $document_names = get_config_value('document_names');

                    foreach ($document_uploads['document_uploads'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {

                            $fileName = $data['la_no'] . $file->getRandomName();
                            if (in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                                $image = \Config\Services::image()
                                    ->withFile($file)
                                    ->save($this->loan_application_documents_uploadPath . $fileName);
                            } else {
                                $file->move($this->loan_application_documents_uploadPath, $fileName);
                            }



                            $uploaded_files[] = $fileName;
                        }

                    }
                }
                // Prepare data for saving to DB
                $data['la_loan_application_documents'] = implode(',', $uploaded_files);
                $data['la_document_names'] = $document_names;
                $data['la_no_of_documents'] = count($uploaded_files);

                $this->model->insert($data);

                $ins_id = $this->model->insertID();

                foreach ($data['customer_id_check'] as $c_key => $c_val) {

                    $product_name = $data['product_name'][$c_key] ?? 0;
                    $product_amount = $data['product_amount'][$c_key] ?? $data['la_total_amount'];
                    $loan_purpose = $data['loan_purpose'][$c_key];
                    $las_cutomer_occupation = $data['las_cutomer_occupation'][$c_key];
                    $customer_house_type = $data['customer_house_type'][$c_key];
                    $total_earning_member = $data['total_earning_member'][$c_key];
                    $total_income = $data['total_income'][$c_key];
                    $customer_ownership_status = $data['customer_ownership_status'][$c_key];
                    $customer_id = $data['customer_id'][$c_key];
                    $stage_level = $data['la_approval_stage_level'];
                    $las_tenure = isset($data['la_tenure']) ? $data['la_tenure'] : 0;
                    $las_interest = isset($data['la_interest']) ? $data['la_interest'] : 0;
                    $las_amount = isset($data['product_amount'][$c_key]) ? $data['product_amount'][$c_key] : $data['la_total_amount'];
                    $las_sanctioned_amount = isset($data['la_sanctioned_amount']) ? $data['la_sanctioned_amount'] : 0;
                    $las_processing_fee = isset($data['la_processing_fee']) ? $data['la_processing_fee'] : 0;
                    $las_insurance = isset($data['la_insurance']) ? $data['la_insurance'] : 0;
                    $las_gst = isset($data['la_gst']) ? $data['la_gst'] : 0;
                    $las_ec = isset($data['la_ec']) ? $data['la_ec'] : 0;

                    $las_is_group_loan = $data['la_is_group_loan'];
                    $las_center_id = $data['la_center_id'] ?? 0;
                    $las_collection_staff = $data['la_collection_staff'] ?? '';

                    $this->model->query("INSERT INTO `loan_application_sub` ( `las_la_id`, `las_customer_id`, `las_date`, `las_loan_type`, `las_branch_id`, `las_center_id`, `las_product_id`, `las_amount`, `las_loan_purpose`, `las_cutomer_occupation`, `las_house_type`, `las_total_earning_member`, `las_total_income`, `las_ownership_status`, `las_la_status`, `las_la_reject_reason`, `las_approval_stage`, `las_final_stage`, `las_approval_stage_position_id`, `las_employee_id`, `las_employee_position_id`,`las_previous_approval_stage`,`las_previous_approval_stage_position_id`,`las_approval_stage_employee_id`,`las_previous_approval_stage_employee_id`,`las_sanctioned_amount`,`las_tenure`,`las_interest`,`las_is_group_loan`,`las_created_by`,`las_approval_stage_level`,`las_processing_fee`,`las_insurance`,`las_collection_staff`,`las_gst`,`las_ec`) VALUES ('$ins_id','$customer_id','$data[la_date]','$data[la_loan_type]','$data[la_branch_id]','$las_center_id','$product_name','$las_amount','$loan_purpose','$las_cutomer_occupation','$customer_house_type','$total_earning_member','$total_income','$customer_ownership_status','$data[la_status]','$data[la_reject_reason]','$data[la_approval_stage]','$data[la_final_stage]','$action_pos_id','$data[la_applied_by_employee_id]','$data[la_applied_by_position_id]','$data[la_previous_approval_stage]','$data[la_previous_approval_stage_position_id]','$action_emp_id','$data[la_previous_approval_stage_employee_id]','$las_sanctioned_amount','$las_tenure','$las_interest','$las_is_group_loan','$data[la_created_by]','$data[la_approval_stage_level]','$las_processing_fee','$las_insurance','$las_collection_staff','$las_gst','$las_ec')");

                    $sub_ins_id = $this->model->insertID();

                    $this->model->query("INSERT INTO `loan_application_history` (`lah_customer_id`, `lah_la_id`, `lah_las_id`, `lah_approval_stage`,`lah_moved_to`,`lah_approval_description`, `lah_action_by_employee_id`,`lah_action_by_position_id`,`lah_status`,`lah_date`,`lah_proposed_amount`,`lah_sanctioned_amount`,`lah_tenure`,`lah_interest`,`lah_created_by`,`lah_approval_stage_level`,`lah_processing_fee`,`lah_insurance`) VALUES ('$customer_id','$ins_id','$sub_ins_id','$moved_from','$data[la_approval_stage]','$data[la_status_description]','$action_emp_id','$action_pos_id','$data[la_status]','$date','$las_amount','$las_sanctioned_amount','$las_tenure','$las_interest','$data[la_created_by]','$data[la_approval_stage_level]','$las_processing_fee','$las_insurance')");

                    if ($data['la_status'] == 'approved') {
                        $this->model->query("UPDATE `customer` SET `customer_loan_status`='applied' WHERE customer_id=" . $customer_id);
                    }

                }
            } else {

                // $document_uploads = $this->request->getFileMultiple('document_uploads');
                $uploaded_files = [];

                $document_uploads = $this->request->getFiles();
                $document_names = '';
                $existing_documents = [];
                $document_names = '';
                $existingDocumentsQuery = $this->model->query("SELECT la_loan_application_documents, la_document_names FROM `loan_application` WHERE la_id = ?", [$id]);
                $result = $existingDocumentsQuery->getRowArray();
                if (!empty($result['la_loan_application_documents'])) {
                    // Convert existing document files into an array
                    $existing_documents = explode(',', $result['la_loan_application_documents']);
                    $uploaded_files = $existing_documents; // Initialize uploaded files with existing documents
                }
                $document_names = $result['la_document_names'] ?? get_config_value('document_names');
                // log_message('info', 'Request document_uploads: ' . print_r($document_uploads, true));
                if (!empty($document_uploads))
                // log_message('info', 'Uploaded files: ' . print_r($_FILES, true));
                {
                    // $document_names = get_config_value('document_names');

                    foreach ($document_uploads['document_uploads'] as $index => $file) {
                        if ($file->isValid() && !$file->hasMoved()) {

                            $fileName = $id . $file->getRandomName();
                            if (in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                                $image = \Config\Services::image()
                                    ->withFile($file)
                                    ->save($this->loan_application_documents_uploadPath . $fileName);
                            } else {
                                $file->move($this->loan_application_documents_uploadPath, $fileName);
                            }



                            $uploaded_files[$index] = $fileName;
                        }

                    }
                }
                // Prepare data for saving to DB
                $data['la_loan_application_documents'] = implode(',', $uploaded_files);
                $data['la_document_names'] = $document_names;
                $data['la_no_of_documents'] = count($uploaded_files);
                unset($data['la_date']);
                $data['la_total_amount'] = $data['la_sanctioned_amount'] ?? $data['la_total_amount'];
                if ($data['la_status'] == 'hold') {

                    $this->model->query("update loan_application set la_collection_slot='$data[la_collection_slot]',la_status = 'hold',la_approval_stage_employee_id='$action_emp_id',la_action_taken_position_id='$action_pos_id',la_status_description='$data[la_status_description]',
                        la_loan_application_documents = '$data[la_loan_application_documents]', 
                        la_document_names = '$data[la_document_names]', 
                        la_no_of_documents = '$data[la_no_of_documents]' 
                        where la_id = '$id'");
                } else {
                    $this->model->update($id, $data);
                }



                foreach ($data['customer_id_check'] as $c_key => $c_val) {

                    $product_name = $data['product_name'][$c_key] ?? 0;
                    $product_amount = $data['product_amount'][$c_key] ?? $data['la_total_amount'];
                    $loan_purpose = $data['loan_purpose'][$c_key];
                    $las_cutomer_occupation = $data['las_cutomer_occupation'][$c_key];
                    $customer_house_type = $data['customer_house_type'][$c_key];
                    $total_earning_member = $data['total_earning_member'][$c_key];
                    $total_income = $data['total_income'][$c_key];
                    $customer_ownership_status = $data['customer_ownership_status'][$c_key];
                    $customer_id = $data['customer_id'][$c_key];
                    $las_id = $data['las_id'][$c_key];
                    $stage_level = $data['la_approval_stage_level'];
                    $las_tenure = isset($data['la_tenure']) ? $data['la_tenure'] : 0;
                    $las_interest = isset($data['la_interest']) ? $data['la_interest'] : 0;
                    $las_amount = isset($data['product_amount'][$c_key]) ? $data['product_amount'][$c_key] : $data['la_total_amount'];
                    $las_sanctioned_amount = isset($data['la_sanctioned_amount']) ? $data['la_sanctioned_amount'] : 0;
                    $las_is_group_loan = $data['la_is_group_loan'];

                    $las_center_id = $data['la_center_id'] ?? 0;
                    $las_insurance = isset($data['la_insurance']) ? $data['la_insurance'] : 0;
                    $las_processing_fee = isset($data['la_processing_fee']) ? $data['la_processing_fee'] : 0;
                    $las_collection_staff = $data['la_collection_staff'] ?? '';


                    if ($data['la_status'] != 'hold') {


                        $this->model->query("update loan_application_sub set las_la_id = '$id',las_customer_id='$customer_id',las_date='$date',las_loan_type='$data[la_loan_type]',las_branch_id='$data[la_branch_id]',las_center_id='$las_center_id',las_product_id='$product_name',las_amount='$las_amount',las_loan_purpose='$loan_purpose',las_cutomer_occupation='$las_cutomer_occupation',las_house_type='$customer_house_type',las_total_earning_member='$total_earning_member',las_total_income='$total_income',las_ownership_status='$customer_ownership_status',las_la_status='$data[la_status]',las_la_reject_reason='$data[la_reject_reason]',las_approval_stage='$data[la_approval_stage]',las_final_stage='$data[la_final_stage]',las_approval_stage_position_id='$action_pos_id',las_employee_id='$data[la_applied_by_employee_id]',las_employee_position_id='$data[la_applied_by_position_id]',las_previous_approval_stage='$data[la_previous_approval_stage]',las_approval_stage_employee_id='$action_emp_id',las_sanctioned_amount='$las_sanctioned_amount',las_tenure='$las_tenure',las_interest='$las_interest',las_is_group_loan='$las_is_group_loan',las_approval_stage_level='$data[la_approval_stage_level]',las_processing_fee = '$las_processing_fee',las_insurance = '$las_insurance',las_collection_staff = '$las_collection_staff' where las_id = '$las_id'");

                        $this->model->query("INSERT INTO `loan_application_history` (`lah_customer_id`, `lah_la_id`, `lah_las_id`, `lah_approval_stage`,`lah_moved_to`,`lah_approval_description`, `lah_action_by_employee_id`,`lah_action_by_position_id`,`lah_status`,`lah_date`,`lah_proposed_amount`,`lah_sanctioned_amount`,`lah_tenure`,`lah_interest`,`lah_approval_stage_level`,`lah_processing_fee`,`lah_insurance`) VALUES ('$customer_id','$id','$las_id','$moved_from','$data[la_approval_stage]','$data[la_status_description]','$action_emp_id','$action_pos_id','$data[la_status]','$date','$las_amount','$las_sanctioned_amount','$las_tenure','$las_interest','$data[la_approval_stage_level]','$las_processing_fee','$las_insurance')");
                    } else {

                        $this->model->query("update loan_application_sub set las_la_status = 'hold' where las_la_id = '$id' ");

                        $history_details = $this->model->query("select * from loan_application_history where lah_customer_id='$customer_id' and lah_la_id='$id' order by lah_id desc limit 1")->getResult('array')[0];


                        $this->model->query("INSERT INTO `loan_application_history` (`lah_customer_id`, `lah_la_id`, `lah_las_id`, `lah_approval_stage`,`lah_moved_to`,`lah_approval_description`, `lah_action_by_employee_id`,`lah_action_by_position_id`,`lah_status`,`lah_date`,`lah_proposed_amount`,`lah_sanctioned_amount`,`lah_tenure`,`lah_interest`,`lah_approval_stage_level`,`lah_created_by`,`lah_processing_fee`,`lah_insurance`) VALUES ('$history_details[lah_customer_id]','$id','$history_details[lah_las_id]','$history_details[lah_approval_stage]','$history_details[lah_moved_to]','$data[la_status_description]','$action_emp_id','$action_pos_id','$data[la_status]','$date','$history_details[lah_proposed_amount]','$history_details[lah_sanctioned_amount]','$history_details[lah_tenure]','$history_details[lah_interest]','$history_details[lah_approval_stage_level]','$action_emp_id','$las_processing_fee','$las_insurance')");
                    }

                }


            }

            return redirect()->to('/admin/loan_application');
        } else {

            $this->add_loan_application($id);
        }

    }


    public function get_field_by_loan_type($branch_id = '', $group_loan = '', $loan_type = '', $req_from = 'ajax', $center_or_customer_id = '')
    {
        if ($req_from == 'ajax') {
            $branch_id = base64_decode($this->request->getVar('branch_id'));
            $group_loan = $this->request->getVar('group_loan');
            $loan_type = $this->request->getVar('loan_type');
            $disable_select = '';
            $name = "name='la_center_id'";
        } else {
            $disable_select = "disabled";
            $name = '';
        }

        if ($group_loan == 'yes') {

            $field = "<label for='la_center_id'>Center</label> <font color='red'>*</font><select class='form-control' " . $name . " id='la_center_id' required " . $disable_select . " onchange='get_customer_details()'><option value=''>Select center</option>";

            $list = $this->model->query("select center_id,center_name,center_code,center_parent_id from center where center_branch_id = '$branch_id' and center_status ='active' and center_deleted = 'no' and center_block_transaction='no' order by center_parent_id asc")->getResult('array');


            $field .= build_center($list, $center_or_customer_id, '', $list[0]['center_parent_id'] ?? '');
            // foreach($list as $key=>$val)
            // {
            //     $selected = ($center_or_customer_id == $val['center_id'])?'selected':'';
            //     $option = "<option value=''>Select Center</option>";

            //     $option .= build_center($list,$center_or_customer_id,'',$list[0]['center_parent_id']??'');

            //     $field .="<option value='".$val['center_id']."'".$selected." >".$val['center_name']." [".$val['center_code']."]</option>";
            // }

            $field .= "</select>";
        } else {
            if ($req_from == 'ajax') {
                $field = "<label for='la_customer'>Customer Name</label> <font color='red'>*</font><input type='text' class='form-control customer_name_autocomplete' name='la_customer[]' id='la_customer' required>
                    <input type='hidden' required name='la_customer_id' id='la_customer_id' >";
            } else {
                $field = "<input type='hidden' required name='la_customer_id' id='la_customer_id' value='" . $center_or_customer_id . "' >";
            }
        }
        return $field;

    }

    public function get_approval_stage_details()
    {

        $branch_id = base64_decode($this->request->getVar('branch_id'));
        $group_loan = $this->request->getVar('group_loan');
        $loan_type = $this->request->getVar('loan_type');

        $data['approval_stage_details'] = $this->model->query("select group_loan,loan_type_approval_required,loan_approval_stage_id,loan_approval_stage_level,loan_approval_stage_name,is_final_stage,group_concat(employee_position_id) as position_id from loan_approval_stage join employee_position on employee_position_role_id = loan_approval_stage_approver_id and employee_position_deleted = 'no' and employee_position_status = 'active' join loan_type on loan_type_id = loan_approval_stage_loan_type  where loan_approval_stage_level = '1' and  loan_approval_stage_loan_type = '$loan_type' and employee_position_branch_id in ($this->branch_dependents) and  loan_approval_stage_status = 'active' and loan_approval_stage_deleted='no'")->getResult('array');

        return json_encode($data['approval_stage_details'][0]);
    }

    public function get_customer_details()
    {
        $id = base64_decode($this->request->getVar('la_id'));
        $customer_id = base64_decode($this->request->getVar('customer_id'));
        $center_id = base64_decode($this->request->getVar('center_id'));
        $loan_type = base64_decode($this->request->getVar('loan_type'));
        $group_loan = $this->request->getVar('group_loan');
        $branch_id = base64_decode($this->request->getVar('branch_id'));

        $data['house_type'] = $this->model->query("select house_type_id,house_type from house_type where house_type_status='active' and house_type_deleted = 'no'")->getResult('array');

        $data['occupation'] = $this->model->query("select occupation_id,occupation_name from occupation where occupation_status='active' and occupation_deleted = 'no'")->getResult('array');

        $data['product'] = $this->model->query("select product_id,product_name,product_amount from product where product_status='active' and product_deleted = 'no' and product_loan_type = '$loan_type'")->getResult('array');

        $is_product_defined = $this->model->query("select group_loan,is_product_defined from loan_type where loan_type_id = '$loan_type'")->getResult('array')[0];


        if ($id > 0) {
            $details = [];

            $las_details = $this->model->query("select * from loan_application_sub where las_la_id = '$id' and las_deleted = 'no'")->getResult('array');

            foreach ($las_details as $las_key => $las_value) {
                $details[$las_value['las_customer_id']] = $las_value;
            }

            $data['details'] = $details;

        }

        if ($group_loan == 'yes') {
            $data['customer_details'] = $this->model->query("select las_id,customer_id,customer_name,customer_aadhar_no,customer_center_head from customer left join loan_application_sub on las_customer_id = customer_id and las_loan_disbursed = 'no' and las_deleted= 'no' and las_la_status != 'rejected' and las_loan_type='$loan_type' left join loan_disbursement_details on customer_id = ldd_customer_id and ldd_loan_type = '$loan_type' and ldd_ld_status = 'not_completed' and ldd_deleted='no' where  customer_branch_id = '$branch_id' and customer_center_id = '$center_id'  and customer_status = 'active' and customer_deleted= 'no' and las_id is null and ldd_id is null  order by customer_name asc")->getResult('array');
        } else {
            $data['customer_details'] = $this->model->query("select las_id,customer_id,customer_name,customer_aadhar_no from customer left join loan_application_sub on las_customer_id = customer_id and las_loan_disbursed = 'no' and las_deleted= 'no' and las_la_status != 'rejected' and las_loan_type='$loan_type' left join loan_disbursement_details on customer_id = ldd_customer_id and ldd_loan_type = '$loan_type' and ldd_ld_status = 'not_completed' and ldd_deleted='no' where customer_id = '$customer_id'  and customer_status = 'active' and customer_deleted= 'no' and las_id is null and ldd_id is null and customer_branch_id = '$branch_id' order by customer_name asc")->getResult('array');

        }

        $data['group_loan'] = $group_loan;

        $data['gst_enabled'] = get_config_value('gst_enabled');

        $data['enable_extra_charge'] = get_config_value('enable_extra_charge');

        $data['extra_charge_label'] = get_config_value('extra_charge_label');

        $data['is_product_defined'] = $is_product_defined['is_product_defined'];

        $table = view('admin/loan_application/customer_details', $data);

        return $table;
    }

    function loan_application_history($id = '')
    {
        $id = ($id != '') ? base64_decode($id) : '';
        if ($id != '') {
            $data['loan_application_history'] = $this->model->query("select lah_date,las1.loan_approval_stage_name,lah_la_id,lah_las_id,las2.loan_approval_stage_name as lah_moved_to,lah_approval_description,lah_status,employee_position_name,employee_name from loan_application_history join employee on employee_id = lah_action_by_employee_id join employee_position on employee_position_id = lah_action_by_position_id left join loan_approval_stage as las1 on las1.loan_approval_stage_id = lah_approval_stage left join loan_approval_stage as las2 on las2.loan_approval_stage_id  = lah_moved_to  where lah_la_id = '$id' group by lah_id  order by lah_id asc")->getResult('array');
        } else {
            $data['loan_application_history'] = '';
        }

        return view('admin/loan_application/application_history', $data);

    }

}