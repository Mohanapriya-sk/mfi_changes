<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\admin\permission_model;
use App\Controllers\BaseController;
use App\Models\admin\branch_type_model;

class Dashboard extends BaseController
{
   public function __construct()
   {
      helper(['form']);
      if (!session()->get('user_logged_in')) {
         return redirect()->to('admin/');
      }
      $this->filters = [];
   }

   public function get_filters()
   {
      $branch_type_model = new branch_type_model();
      $branch_filter = base64_decode($this->request->getVar('branch_filter')) ?? '';
      $branch_where_in = session()->get('branch_child');
      $filter_branch_list = $branch_type_model->query("select branch_id,branch_name,branch_parent_id,branch_code from branch where branch_status='active' and branch_deleted='no' and branch_id in ($branch_where_in) order by branch_parent_id,branch_name asc")->getResult('array');
      $this->filters['branch_filter'] = [
         'show' => true,
         'selected' => $branch_filter,
         'list' => $filter_branch_list
      ];
   }

   public function dashboard()
   {
      if (!session()->get('user_logged_in')) {
         return redirect()->to('admin/');
      }
      $this->page_name = 'dashboard';

      $data['breadcrumb1'] = 'Dashboard';
      $data['breadcrumb2'] = 'Home';
      $data['breadcrumb3'] = 'Dashboard';
      $data['create_button'] = false;
      $data['back_button'] = false;
      $this->get_filters();
      $data['filters'] = $this->filters;
      $data['filters']['filter_url'] = base_url('/admin/dashboard');
      $data['filters']['employee_filter']['show'] = false;
      $data['filters']['from_date_filter']['show'] = false;
      $data['filters']['to_date_filter']['show'] = false;
      $data['filters']['date_filter']['show'] = false;
      $data['filters']['loan_no_filter']['show'] = false;
      $data['filters']['loan_type_filter']['show'] = false;
      $data['filters']['center_filter']['show'] = false;
      $data['filters']['customer_filter']['show'] = false;
      $data['filters']['center_filter']['show'] = false;
      $data['filters']['status_filter']['show'] = false;


      $this->page_name = 'dashboard';
      $this->page_group = 'dashboard';
      $Permission_model = new Permission_model();
      $data['user_role_id'] = session()->get('user_role_id');

      $branch_child = session()->get('branch_child');

      if (isset($_GET['branch_filter']) && $_GET['branch_filter'] != '') {
         $branch_child = base64_decode($_GET['branch_filter']);
      }

      $ldd_details = "select count(ldd_id) as no_of_disbursement,sum(ldd_amount) as value_of_disbursement,sum(ldd_processing_fee) as tot_processing_fee,sum(ldd_insurance_amount) as tot_insurance from loan_disbursement_details  where ldd_deleted = 'no' and ldd_branch_id in ($branch_child)";

      $no_of_center = "select count(center_id) as no_of_center from center where center_deleted = 'no' and center_branch_id in ($branch_child)";

      $no_of_customer = "select count(customer_id) as no_of_customer from customer where customer_deleted = 'no' and customer_branch_id in ($branch_child) and customer_status = 'active'";

      $inactive_customer = "select count(ldd_id) as inactive_customer from (select ldd_id,sum(if(ldd_ld_status = 'not_completed',1,0)) as nc_count from loan_disbursement_details where ldd_deleted = 'no' and ldd_branch_id in ($branch_child) group by ldd_customer_id having nc_count = 0)  as a";

      $capital_investment = " select sum(capital_investment_amount) as capital_investment from capital_investment where capital_investment_deleted = 'no' and capital_investment_transaction_type = 'cash_inflow' and capital_investment_branch_id in ($branch_child)";

      $total_expense = "select sum(ot_amount) as total_expense from office_transaction where ot_deleted = 'no' and ot_branch_id in ($branch_child)";

      $table_name = $Permission_model->query("select dt_name from dynamic_table where dt_category='transaction'")->getResult('array');

      $query = '';
      foreach ($table_name ?? '' as $t_key => $t_val) {
         $table_exist = $Permission_model->query("SHOW TABLES LIKE '" . $t_val['dt_name'] . "'")->getResult('array');
         if (!empty($table_exist)) {
            $query .= " select sum(IF(transaction_type = 'cash_inflow',transaction_amount,0)) as tot_inflow,sum(IF(transaction_type = 'cash_outflow',transaction_amount,0)) as tot_outflow from " . $t_val['dt_name'] . " where transaction_deleted = 'no' and transaction_approved='yes' and transaction_branch_id in ($branch_child) union ";
         }
      }
      $tot_dc = rtrim($query, 'union ');
      $tot_dc = "select sum(tot_inflow) as tot_inflow,sum(tot_outflow) as tot_outflow from ($tot_dc) as a";
      $table_name = $Permission_model->query("select dt_name from dynamic_table where dt_category='collection'")->getResult('array');
      $query = '';

      foreach ($table_name ?? '' as $t_key => $t_val) {
         $table_exist = $Permission_model->query("SHOW TABLES LIKE '" . $t_val['dt_name'] . "'")->getResult('array');
         if (!empty($table_exist)) {
            $query .= " select sum(lcd_principal_amount - (if(lcd_approved='yes' ,lcd_paid_principal_amount,0))) as p_out,sum(lcd_interest_amount - if(lcd_approved='yes',lcd_paid_interest_amount,0)) as i_out ,sum(if(lcd_approved='yes',lcd_paid_interest_amount,0)) as paid_interest from " . $t_val['dt_name'] . " where lcd_delete_status = 'no'  and lcd_branch_id in ($branch_child) union ";
         }
      }
      $tot_out = rtrim($query, 'union ');
      $tot_out = "select sum(p_out) as p_out,sum(i_out) as i_out,sum(paid_interest) as tot_paid_interest from ($tot_out) as a";

      $ldd_details = $Permission_model->query($ldd_details)->getResult('array');
      $no_of_center = $Permission_model->query($no_of_center)->getResult('array');
      $no_of_customer = $Permission_model->query($no_of_customer)->getResult('array');
      $inactive_customer = $Permission_model->query($inactive_customer)->getResult('array');
      $capital_investment = $Permission_model->query($capital_investment)->getResult('array');
      $total_expense = $Permission_model->query($total_expense)->getResult('array');
      $tot_dc = !empty($tot_dc) ? $Permission_model->query($tot_dc)->getResult('array') : [];
      $tot_out = !empty($tot_out) ? $Permission_model->query($tot_out)->getResult('array') : [];

      $total_income = ((!empty($ldd_details)) ? ($ldd_details[0]['tot_processing_fee'] + $ldd_details[0]['tot_insurance']) : 0);
      $total_income += (!empty($tot_out)) ? $tot_out[0]['tot_paid_interest'] : 0;

      $data['no_of_customer'] = (!empty($no_of_customer)) ? $no_of_customer[0]['no_of_customer'] : 0;
      $data['no_of_center'] = (!empty($no_of_center)) ? $no_of_center[0]['no_of_center'] : 0;
      $data['inactive_customer'] = (!empty($inactive_customer)) ? $inactive_customer[0]['inactive_customer'] : 0;
      $data['active_customer'] = $data['no_of_customer'] - $data['inactive_customer'];
      $data['no_of_disbursement'] = (!empty($ldd_details)) ? $ldd_details[0]['no_of_disbursement'] : 0;
      $data['value_of_disbursement'] = (!empty($ldd_details)) ? (!empty($ldd_details[0]['value_of_disbursement']) ? $ldd_details[0]['value_of_disbursement'] : 0) : 0;
      $data['p_out'] = (!empty($tot_out)) ? $tot_out[0]['p_out'] : 0;
      $data['i_out'] = (!empty($tot_out)) ? $tot_out[0]['i_out'] : 0;
      $data['capital_investment'] = (!empty($capital_investment)) ? (!empty($capital_investment[0]['capital_investment']) ? $capital_investment[0]['capital_investment'] : 0) : 0;
      $data['total_income'] = $total_income ?? 0;
      $data['total_expense'] = (!empty($total_expense)) ? (!empty($total_expense[0]['total_expense']) ? $total_expense[0]['total_expense'] : 0) : 0;
      $data['net_profit'] = $data['total_income'] - $data['total_expense'];
      $data['total_outflow'] = (!empty($tot_dc)) ? (!empty($tot_dc[0]['tot_outflow']) ? $tot_dc[0]['tot_outflow'] : 0) : 0;
      $data['total_inflow'] = (!empty($tot_dc)) ? (!empty($tot_dc[0]['tot_inflow']) ? $tot_dc[0]['tot_inflow'] : 0) : 0;

      $this->arr_data = $data;
      echo view('admin/dashboard', $this->format_data());
   }

   public function menu_dashboard($parent_menu = '')
   {
      if (!session()->get('user_logged_in')) {
         return redirect()->to('admin/');
      }

      $data['breadcrumb1'] = ucfirst($parent_menu);
      $data['breadcrumb2'] = 'Home';
      $data['breadcrumb3'] = 'Dashboard';
      $data['create_button'] = false;
      $data['back_button'] = false;
      $this->page_name = 'dashboard';
      $this->page_group = 'dashboard';

      $Permission_model = new Permission_model();

      $data['sub_menu'] = $Permission_model->where(['permission_user_role_id' => $_SESSION['user_role_id'], 'permission_view_enabled' => 'yes', 'permission_menu_category_name' => $parent_menu])->orderBy('permission_menu_order_by', 'asc')->findAll();

      $this->arr_data = $data;

      echo view('admin/menu_dashboard', $this->format_data());

   }

   public function configuration()
   {
      $Permission_model = new Permission_model();
      $this->page_name = 'configuration';
      $this->page_group = 'form';
      $data['breadcrumb1'] = ucfirst(str_replace("_", " ", $this->page_name));
      $data['breadcrumb2'] = 'Home';
      $data['breadcrumb3'] = 'Configuration';
      $data['create_button'] = false;
      $data['back_button'] = false;
      $data['save_url'] = base_url('/admin/save_configuration');
      ;
      $data['configuration'] = $Permission_model->query("select * from configuration")->getResult('array');
      $data['configuration'] = array_column($data['configuration'], 'configuration_value', 'configuration_name');
      $this->arr_data = $data;
      return view('admin/configuration', $this->format_data());
   }

   public function save_configuration()
   {
      $data = [];
      $Permission_model = new Permission_model();
      foreach ($this->request->getVar() as $key => $val) {
         $data[$key] = $val;
      }
      $emp_id = session()->get('user_employee_id');
      foreach ($data as $key => $val) {
         $Permission_model->query("update configuration set configuration_value = '" . $val . "',configuration_updated_by = '" . $emp_id . "' where configuration_name = '" . $key . "'");
      }
      return redirect()->to('/admin/dashboard/admin');
   }
}
