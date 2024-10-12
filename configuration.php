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
			<form method="POST" action="<?php echo $save_url ?? '' ?>" novalidate id="configuration_form">
				<div class="card-body">

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="branch_name">GST Number</label>
							<font color='red'>*</font>
							<input class='form-control' type="text" name="gst_number" id="gst_number" required
								placeholder="gst_number" value="<?php echo $configuration["gst_number"] ?? '' ?>">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="branch_name">Cash Inflow Label</label>
							<font color='red'>*</font>
							<input class='form-control' type="text" name="cash_inflow" id="cash_inflow" required
								placeholder="Cash Inflow Lable" value="<?php echo $configuration["cash_inflow"] ?? '' ?>">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="branch_name">Cash Outflow Label</label>
							<font color='red'>*</font>
							<input class='form-control' type="text" name="cash_outflow" id="cash_outflow" required
								placeholder="Cash Outflow Lable"
								value="<?php echo $configuration["cash_outflow"] ?? '' ?>">
						</div>
					</div>


					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="branch_name">Auto Approve Loan Application?</label>
							<font color='red'>*</font>
							<select class='form-control' name="auto_approve_loan" id="auto_approve_loan" required>
								<option value="no" <?php if (isset($configuration['auto_approve_loan']) && $configuration['auto_approve_loan'] == 'no')
									echo 'selected' ?>>No</option>
									<option value="yes" <?php if (isset($configuration['auto_approve_loan']) && $configuration['auto_approve_loan'] == 'yes')
									echo 'selected' ?>>Yes</option>
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="branch_name">Allow Loan Disbursement?</label>
								<font color='red'>*</font>
								<select class='form-control' name="loan_disbursement" id="loan_disbursement" required>
									<option value="no" <?php if (isset($configuration['loan_disbursement']) && $configuration['loan_disbursement'] == 'no')
									echo 'selected' ?>>No</option>
									<option value="yes" <?php if (isset($configuration['loan_disbursement']) && $configuration['loan_disbursement'] == 'yes')
									echo 'selected' ?>>Yes</option>
								</select>
							</div>
						</div>


						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="branch_name">Collection Approval Required?</label>
								<font color='red'>*</font>
								<select class='form-control' name="collection_approval_required"
									id="collection_approval_required" required>
									<option value="no" <?php if (isset($configuration['collection_approval_required']) && $configuration['collection_approval_required'] == 'no')
									echo 'selected' ?>>No</option>
									<option value="yes" <?php if (isset($configuration['collection_approval_required']) && $configuration['collection_approval_required'] == 'yes')
									echo 'selected' ?>>Yes
									</option>
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="branch_name">Office Transaction Approval Required?</label>
								<font color='red'>*</font>
								<select class='form-control' name="expense_approval_required" id="expense_approval_required"
									required>
									<option value="no" <?php if (isset($configuration['expense_approval_required']) && $configuration['expense_approval_required'] == 'no')
									echo 'selected' ?>>No</option>
									<option value="yes" <?php if (isset($configuration['expense_approval_required']) && $configuration['expense_approval_required'] == 'yes')
									echo 'selected' ?>>Yes</option>
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label for="branch_name">Holiday Dates</label>
								<font color='red'>*</font>
								<textarea name='holiday_dates'
									class='form-control'><?php echo $configuration['holiday_dates'] ?? '' ?></textarea>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="no_of_loan_application_documents">No. of Loan Applications</label>
							<font color='red'>*</font>
							<select class='form-control' name="no_of_loan_application_documents"
								id="no_of_loan_application_documents" required onchange="toggleDocumentNames()">
								<?php for ($i = 0; $i <= 10; $i++): ?>
									<option value="<?= $i ?>" <?php if (isset($configuration['no_of_loan_application_documents']) && $configuration['no_of_loan_application_documents'] == $i)
										  echo 'selected' ?>>
										<?= $i ?>
									</option>
								<?php endfor; ?>
							</select>
						</div>
					</div>

					<div class="form-row" id="document_names_row" style="display: none;">
						<div class="form-group col-md-4">
							<label for="document_names">Document Names</label>
							<font color='red'>*</font>
							<input class='form-control' type="text" name="document_names" id="document_names"
								placeholder="Enter document names"
								value="<?php echo $configuration["document_names"] ?? '' ?>">
							<small class="form-text text-danger" id="document_names_error" style="display: none;">Number
								of document names must match the number of loan applications.</small>
						</div>
					</div>

				</div>
				<div class="card-footer bg-light text-right">
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<a href="#" onclick="submit_form('configuration_form')" data-qt-block="body"
									class="btn btn-primary ">Submit</a>
								<a href="<?php echo base_url('/admin/dashboard/admin') ?>" data-qt-block="body"
									class="btn btn-light  btn-outline">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<?= $this->endSection() ?>