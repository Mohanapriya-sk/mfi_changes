<?php
namespace App\Models\admin;
use CodeIgniter\Model;

class Loan_application_model extends Model
{
    protected $table = 'loan_application';
    protected $primaryKey = 'la_id';
    protected $allowedFields = ['la_collection_slot', 'la_ec', 'la_gst', 'la_id', 'la_no', 'la_loan_type', 'la_branch_id', 'la_center_id', 'la_total_members', 'la_applied_by_employee_id', 'la_applied_by_position_id', 'la_date', 'la_status', 'la_approval_stage', 'la_approval_stage_position_id', 'la_total_amount', 'la_auto_approved', 'la_created_by', 'la_created_at', 'la_deleted', 'la_updated_at', 'la_deleted_by', 'la_final_stage', 'la_reject_reason', 'la_status_description', 'la_previous_approval_stage_position_id', 'la_previous_approval_stage', 'la_approval_stage_employee_id', 'la_previous_approval_stage_employee_id', 'la_proposed_amount', 'la_sanctioned_amount', 'la_tenure', 'la_interest', 'la_approval_stage_level', 'la_is_group_loan', 'la_previous_approval_stage_level', 'la_action_taken_position_id', 'la_customer_id', 'la_processing_fee', 'la_insurance', 'la_collection_staff', 'la_loan_application_documents', 'la_document_names', 'la_no_of_documents'];


}
?>