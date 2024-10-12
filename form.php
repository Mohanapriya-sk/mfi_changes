<?= $this->extend('admin/layout/layout') ?>

<?= $this->section('content') ?>

<div class="row">
	<div class="col-md-12">
		<?php
		if (isset($validation)): ?>
			<div class="alert alert-danger">
				<?= $validation->listErrors() ?>
			</div>
		<?php endif; ?>
		<div class="card">

			<form method="POST" action="<?php echo $save_url ?? '' ?>" novalidate id="loan_application_form">
				<div class="card-body">


					<input type="hidden" name="la_id" value="<?php echo $edit_details['la_id'] ?? '0'; ?>">
					<input type="hidden" id="la_approval_stage" name="la_approval_stage"
						value="<?php echo $loan_approval_stage['loan_approval_stage_id'] ?? '0'; ?>">
					<input type="hidden" id="la_approval_stage_level" name="la_approval_stage_level"
						value="<?php echo $loan_approval_stage['loan_approval_stage_level'] ?? '0'; ?>">
					<input type="hidden" id="la_is_group_loan" name="la_is_group_loan"
						value="<?php echo $loan_approval_stage['group_loan'] ?? ''; ?>">
					<input type="hidden" id="la_approval_stage_position_id" name="la_approval_stage_position_id"
						value="<?php echo $loan_approval_stage['position_id'] ?? '0'; ?>">
					<input type="hidden" id="la_final_stage" name="la_final_stage"
						value="<?php echo $loan_approval_stage['is_final_stage'] ?? ''; ?>">
					<input type="hidden" name="la_previous_approval_stage"
						value="<?php echo $edit_details['la_previous_approval_stage'] ?? '0'; ?>">
					<input type="hidden" name="la_previous_approval_stage_level"
						value="<?php echo $edit_details['la_previous_approval_stage_level'] ?? '0'; ?>">
					<input type="hidden" name="la_previous_approval_stage_position_id"
						value="<?php echo $edit_details['la_previous_approval_stage_position_id'] ?? '0'; ?>">
					<input type="hidden" name="la_previous_approval_stage_employee_id"
						value="<?php echo $edit_details['la_previous_approval_stage_employee_id'] ?? '0'; ?>">
					<input type="hidden" name="loan_type_approval_required" id="loan_type_approval_required"
						value="<?php echo $edit_details['loan_type_approval_required'] ?? '' ?>">


					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="la_branch_id">Date</label>
							<font color='red'>*</font>
							<input type="date" class="form-control" name="la_date" value="<?php echo date('Y-m-d') ?>"
								required>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="la_branch_id">Branch</label>
							<font color='red'>*</font>

							<select class='form-control get_employee_based_on_branch'
								replace_id="la_applied_by_employee_id" <?php if (!isset($edit_details['la_branch_id'])) { ?> name="la_branch_id" <?php } ?> id="la_branch_id" required <?php if (isset($edit_details['la_loan_type']))
										   echo "disabled"; ?>>
								<option value="">Select Branch</option>
								<?php

								$selected = (isset($edit_details['la_branch_id'])) ? $edit_details['la_branch_id'] : '';
								$options = build_branch($branch, $selected, '', $branch[0]['branch_parent_id'] ?? '');

								echo $options;
								?>
							</select>
							<?php if (isset($edit_details['la_branch_id'])) { ?>
								<input type="hidden" name="la_branch_id"
									value="<?php echo $edit_details['la_branch_id'] ?>">
							<?php } ?>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="la_loan_type">Loan Type</label>
							<font color='red'>*</font>
							<select class='form-control' <?php if (!isset($edit_details['la_branch_id'])) { ?>
									name="la_loan_type" <?php } ?>id="la_loan_type" required <?php if (isset($edit_details['la_loan_type']))
										  echo "disabled"; ?>>
								<option value="">Select Loan Type</option>
								<?php
								if (isset($loan_type)) {
									foreach ($loan_type as $s_key => $s_val) { ?>
										<option value='<?php echo $s_val['loan_type_id'] ?>' <?php if (isset($edit_details['la_loan_type']) && $edit_details['la_loan_type'] == $s_val['loan_type_id'])
											   echo 'selected' ?>
												group_loan='<?php echo $s_val['group_loan'] ?>'><?php echo $s_val['loan_type'] ?>
										</option>
									<?php }

									?>
								<?php } ?>
							</select>

							<?php if (isset($edit_details['la_loan_type'])) { ?>
								<input type="hidden" name="la_loan_type"
									value="<?php echo $edit_details['la_loan_type'] ?>">
							<?php } ?>
						</div>
					</div>


					<div class="form-row">
						<div class="form-group col-md-4">
							<span id='center_customer_div'>
								<?php
								if (isset($customer_or_center_field) && !empty($customer_or_center_field)) {
									echo $customer_or_center_field;
								}
								?>
							</span>
						</div>
					</div>


					<span id="customer_details">
						<?php
						if (isset($customer_details_view) && !empty($customer_details_view)) {
							echo $customer_details_view;
						}
						if (isset($edit_details['la_center_id'])) { ?>
							<input type="hidden" name="la_center_id" value="<?php echo $edit_details['la_center_id'] ?>">
						<?php }
						?>
					</span>


					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="la_applied_by_employee_id">Sales Staff</label>
							<font color='red'>*</font>
							<select class='form-control' <?php if (!isset($edit_details['la_branch_id'])) { ?>
									name="la_applied_by_employee_id" <?php } ?> id="la_applied_by_employee_id" <?php if (isset($edit_details['la_loan_type']))
										   echo "disabled";
									   else
										   echo "required"; ?>>
								<option value="">Select Staff</option>
								<?php
								if (isset($staff_list)) {
									foreach ($staff_list as $s_key => $s_val) { ?>
										<option value='<?php echo $s_val['employee_id'] ?>' <?php if (isset($edit_details['la_applied_by_employee_id']) && $edit_details['la_applied_by_employee_id'] == $s_val['employee_id'])
											   echo 'selected' ?>><?php echo $s_val['employee_name'] . " [" . $s_val['employee_code'] . "]" ?>
										</option>
									<?php }
									?>
								<?php } ?>
							</select>
							<?php if (isset($edit_details['la_applied_by_employee_id'])) { ?>
								<input type="hidden" name="la_applied_by_employee_id"
									value="<?php echo $edit_details['la_applied_by_employee_id'] ?>">
							<?php } ?>
							<input type="hidden" name="la_applied_by_position_id" id="la_applied_by_position_id"
								value="<?php echo $edit_details['la_applied_by_position_id'] ?? '0' ?>">
						</div>
					</div>
					<?php if ((isset($edit_details['la_collection_staff']) && $edit_details['la_is_group_loan'] == 'no') || (!isset($edit_details['la_collection_staff']))) { ?>
						<div class="form-row" style="display: none;" id="collection_staff_div">
							<div class="form-group col-md-4">
								<label for="la_collection_staff">Collection Staff</label>
								<font color='red'>*</font>
								<select class='form-control' <?php if (!isset($edit_details['la_branch_id'])) { ?>
										name="la_collection_staff" <?php } ?> id="la_collection_staff" required <?php if (isset($edit_details['la_loan_type']))
											   echo "disabled"; ?>>
									<option value="">Select Staff</option>
									<?php
									if (isset($staff_list)) {
										foreach ($staff_list as $s_key => $s_val) { ?>
											<option value='<?php echo $s_val['employee_id'] ?>' <?php if (isset($edit_details['la_collection_staff']) && $edit_details['la_collection_staff'] == $s_val['employee_id'])
												   echo 'selected' ?>>
												<?php echo $s_val['employee_name'] . " [" . $s_val['employee_code'] . "]" ?>
											</option>
										<?php }
										?>
									<?php } ?>
								</select>
								<?php if (isset($edit_details['la_collection_staff'])) { ?>
									<input type="hidden" name="la_collection_staff"
										value="<?php echo $edit_details['la_collection_staff'] ?>">
								<?php } ?>
							</div>
						</div>
					<?php } ?>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="la_status">Action</label>
							<font color='red'>*</font>
							<select class='form-control' name="la_status" id="la_status" required>
								<?php
								if (isset($edit_details['la_final_stage'])) {
									?>
									<option value="">Select status</option>
									<option value="hold">In Progress</option>
									<?php
								} ?>
								<?php if ((isset($edit_details['la_final_stage']) && $edit_details['la_final_stage'] == 'no') || (!isset($edit_details['la_final_stage']))) { ?>
									<option value="forwarded">Forward To Next Stage</option>
								<?php }
								if (isset($edit_details['la_final_stage']) && $edit_details['la_final_stage'] == 'no') {
									if ($edit_details['is_first_stage'] != 0) { ?>}
										<option value="sent_back">Send Back To previous Stage</option>
									<?php } ?>

									<option value="rejected">Reject</option>

									<!-- <option value = "approved"  >Approve</option> -->
								<?php }
								if ((isset($edit_details['la_final_stage']) && $edit_details['la_final_stage'] == 'yes')) { ?>

									<?php
									if ($edit_details['is_first_stage'] != 0) {
										?>
										<option value="sent_back">Send Back To previous Stage</option>
									<?php } ?>
									<option value="rejected">Reject</option>
									<option value="approved">Approve</option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4" id="la_reject_reason_div" <?php if ((isset($edit_details['la_status']) && $edit_details['la_status'] != 'rejected') || (!isset($edit_details['la_status']))) {
							echo "style='display:none'";
						} ?>>
							<label for="la_reject_reason">Reject Reason</label>
							<font color='red'>*</font>
							<select style="width: 100%" class='form-control' name="la_reject_reason"
								id="la_reject_reason" <?php if (isset($edit_details['la_status']) && $edit_details['la_status'] == 'rejected') {
									echo "required";
								} ?>>
								<?php
								if (isset($loan_reject_reason)) {
									foreach ($loan_reject_reason as $s_key => $s_val) { ?>
										<option value='<?php echo $s_val['loan_reject_reason_id'] ?>' <?php if (isset($edit_details['la_reject_reason']) && $edit_details['la_reject_reason'] == $s_val['loan_reject_reason_id'])
											   echo 'selected' ?>><?php echo $s_val['loan_reject_reason'] ?></option>
									<?php }
									?>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php if ($enable_collection_slot == 'yes') { ?>
						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="la_branch_id">Collection Slot</label>
								<font color='red'>*</font>
								<select style="width: 100%" class='form-control' name="la_collection_slot"
									id="la_collection_slot" required>
									<option value="1" <?php if (isset($edit_details['la_collection_slot']) && $edit_details['la_collection_slot'] == "1")
										echo 'selected' ?>>AM1</option>
										<option value="2" <?php if (isset($edit_details['la_collection_slot']) && $edit_details['la_collection_slot'] == "2")
										echo 'selected' ?>>AM2</option>
										<option value="3" <?php if (isset($edit_details['la_collection_slot']) && $edit_details['la_collection_slot'] == "3")
										echo 'selected' ?>>PM1</option>
										<option value="4" <?php if (isset($edit_details['la_collection_slot']) && $edit_details['la_collection_slot'] == "4")
										echo 'selected' ?>>PM2</option>
									</select>
								</div>
							</div>
					<?php } ?>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="la_reject_reason">Description</label>
							<font color='red'>*</font>
							<textarea class="form-control" name="la_status_description" required></textarea>
						</div>
					</div>


				</div>
				<div class="card-footer bg-light text-right">
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<?php if (($edit_details['la_applied_by_employee_id'] ?? '0' != $_SESSION['user_employee_id']) && ($edit_details['la_created_by'] ?? '0' != $_SESSION['user_id'])) { ?>


									<a href="#" onclick="submit_loan_application('loan_application_form')"
										class="btn btn-primary ">Submit</a>
								<?php } ?>
								<?php if (isset($edit_details['la_loan_type'])) { ?>
									<a class="btn" style="background:#736cc7;color:white" data-remote="true"
										href="<?php echo base_url('admin/loan_application_history') . "/" . base64_encode($edit_details['la_id'] ?? '') ?>"
										title="Loan Application History" data-toggle="modal"
										data-target="#la_history_modal">Approval Flow </a>
								<?php } ?>
								<a href="<?php echo $back_url ?? '' ?>" data-qt-block="body"
									class="btn btn-light  btn-outline">Back</a>

							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



<!-- popup -->
<!-- The Modal -->
<div class="modal" id="la_history_modal">
	<div class="modal-dialog" style="max-width: 95%;">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Loan Application History</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">

			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<?= $this->endSection() ?>