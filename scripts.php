<script src="<?php echo base_url('admin_asset/vendor/modernizr/modernizr.custom.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/js-storage/js.storage.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/js-cookie/src/js.cookie.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/pace/pace.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/metismenu/dist/metisMenu.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/switchery-npm/index.js') ?>"></script>
<script
	src="<?php echo base_url('admin_asset/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/datatables.net/js/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js') ?>"></script>

<script src="<?php echo base_url('admin_asset/vendor/select2/select2.min.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/vendor/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('admin_asset/js/components/sweetalert2.js') ?>"></script>

<script src="<?php echo base_url('admin_asset/js/global/app.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin_asset/js/image_cropper.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin_asset/js/jquery_migrate_ui.js') ?>"></script>
<!-- <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script> -->
<script type="text/javascript" src="<?php echo base_url('admin_asset/vendor/dropzone/dropzone.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin_asset/js/dt_buttons.js') ?>"></script>
<script type="text/javascript">

	$("select").select2({
		width: '100%'
	})

	function show_loader() {
		$('body').append('<div class="qt-block-ui"></div><div class="qt-block-ui"></div>');
	}

	function hide_loader() {
		$('.qt-block-ui').remove();
	}

	function detectConsole(heightThreshold = 150, widthThreshold = 100) {
		var heightDiff = window.outerHeight - window.innerHeight;
		var widthDiff = window.outerWidth - window.innerWidth;
		if (heightDiff > heightThreshold || widthDiff > widthThreshold) {
			console.log('Console is opened!');
			window.stop(); // Stop loading the page
			$('body').html('');
		}
	}

	function disable_inspect_element() {
		$(document).on("contextmenu", function (e) {
			e.preventDefault();
		});
		$(document).on("keydown", function (e) {
			if (e.ctrlKey && e.key === "u") {
				e.preventDefault();
			}

			if (e.ctrlKey && e.shiftKey && e.key === "I") {
				e.preventDefault();
			}

			if (e.ctrlKey && e.shiftKey && e.key === "J") {
				e.preventDefault();
			}

			if (e.ctrlKey && e.key === "s") {
				e.preventDefault();
			}

			if (e.ctrlKey && e.shiftKey && e.key === "C") {
				e.preventDefault();
			}

			if (e.key === "F12") {
				e.preventDefault();
			}

		});
	}
	//detectConsole();
	//disable_inspect_element();
	$(document).on('keyup', '.employee_name_autocomplete', function () {
		$('.employee_name_autocomplete').blur(function () {
			var keyEvent = $.Event("keydown");
			keyEvent.keyCode = $.ui.keyCode.ENTER;
			$(this).trigger(keyEvent);
			return false;
		}).autocomplete({
			source: base_url + '/admin/get_employee_name_autocomplete',
			select: function (event, ui) {
				var row_id = $(this).attr('row_id');
				$('#employee_id' + row_id).val(ui.item.id);
			}
		});
	});

	$(document).ready(function () {
		$('#changePasswordForm').submit(function (e) {
			e.preventDefault();
			$('#password_change_button').hide();
			$.ajax({
				url: '<?php echo base_url('admin/change_password'); ?>',
				type: 'POST',
				data: $('#changePasswordForm').serialize(),
				success: function (response) {
					var alertBox = $('#passwordChangeAlert');

					if (response.status === 'success') {
						alertBox.removeClass('alert-danger').addClass('alert-success').removeClass('d-none').text(response.message);
						setTimeout(function () {
							$('#changePasswordModal').modal('hide');
						}, 2000);
					} else {
						$('#password_change_button').show();
						alertBox.removeClass('alert-success').addClass('alert-danger').removeClass('d-none').text(response.message);
					}

					setTimeout(function () {
						alertBox.addClass('d-none');
					}, 5000);
				},
				error: function () {
					$('#password_change_button').show();
					$('#passwordChangeAlert').removeClass('d-none').addClass('alert-danger').text('An error occurred while changing the password.');
				}
			});
		});
	});

	$(document).on('keypress', '.employee_name_autocomplete', function (e) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			e.preventDefault();
			return false;
		}
	});

	$(document).on('blur', '.employee_name_autocomplete', function () {
		var row_id = $(this).attr('row_id');
		if ($('#employee_id' + row_id).val() == '') {
			$(this).val('');
			$(this).focus();
		}
	});

	$(document).on('blur', '.customer_name_autocomplete', function () {
		if ($('#la_customer_id').val() == '') {
			$(this).val('');
			$(this).focus();

		}
	});

	$(document).on('keypress', '.customer_name_autocomplete', function (e) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			e.preventDefault();
			return false;
		}
	});


	$(document).on('keyup', '.customer_name_autocomplete', function () {

		if (page_name == 'loan_application' || page_name == 'loan_disbursement') {
			if (page_name == 'loan_application') {
				var loan_type = $('#la_loan_type').val();
				var branch_id = $('#la_branch_id').val();
			} else {
				var loan_type = $('#ld_loan_type').val();
				var branch_id = $('#ld_branch_id').val();
			}


			var req_from = page_name;
			var path = 'get_la_customer_name_autocomplete?loan_type=' + loan_type + '&req_from=' + req_from + '&branch_id=' + branch_id;
		} else {
			var path = 'get_customer_name_autocomplete';
		}
		$('.customer_name_autocomplete').blur(function () {
			var keyEvent = $.Event("keydown");
			keyEvent.keyCode = $.ui.keyCode.ENTER;
			$(this).trigger(keyEvent);
			return false;
		}).autocomplete({

			source: base_url + '/admin/' + path,
			select: function (event, ui) {
				if (page_name == 'loan_application') {
					$('#la_customer_id').val(ui.item.id);
					get_customer_details();
				}
				else {
					$('#ld_customer_id').val(ui.item.id);
					get_loan_application();
				}
			}
		});
	});

	if (page_group == 'form') {
		$(document).on('input', '.aathar_no_split', function (e) {
			$(this).val($(this).val().replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1  ').trim());
		});

		$(document).on('input', '.mobile_no_split', function (e) {
			$(this).val($(this).val().replace(/[^\dA-Z]/g, '').replace(/(.{5})/g, '$1  ').trim());
		});


		$(document).on('blur', '.pan_validation', function (e) {
			var panVal = $(this).val();
			var regpan = /([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;

			if (regpan.test(panVal)) {
				$(this).css('border', '2px solid #ccc');
			} else {
				$(this).css('border', '2px solid red');
				$(this).val('');
			}
		});

		function toggleDocumentNames() {
			var noOfLoanApplications = $('#no_of_loan_application_documents').val();

			if (parseInt(noOfLoanApplications) > 0) {
				$('#document_names_row').show();
			} else {
				$('#document_names_row').hide();
			}
		}
		function validateForm() {
			var noOfLoanApplications = parseInt($('#no_of_loan_application_documents').val());
			var documentNames = $('#document_names').val();
			var documentNamesArray = documentNames.split(',').map(name => name.trim());

			if (noOfLoanApplications > 0 && documentNamesArray.length !== noOfLoanApplications) {
				$('#document_names_error').show();
				return false;
			} else {
				$('#document_names_error').hide();
				return true;
			}
		}

		$(document).ready(function () {
			toggleDocumentNames();

			$('#no_of_loan_application_documents').on('change', toggleDocumentNames);
			$('#configuration_form').on('submit', function (event) {
				if (!validateForm()) {
					event.preventDefault();
				}
			});
		});
		function submit_form(form_id) {

			var forms = $('#' + form_id);
			var validation = Array.prototype.filter.call(forms, function (form) {
				if (form.checkValidity() === false) {
					alert("Please fill all the required data.");
					event.preventDefault();
					event.stopPropagation();
				} else {
					show_loader();
					$('#submit_btn').prop("disabled", true);
					if (page_name == 'dynamic_form' || page_name == 'product' || page_name == 'loan_application' || page_name == 'loan_disbursement' || page_name == 'loan_cillection') {
						$.ajax({
							url: $('#' + form_id).attr('action'),
							type: 'POST',
							data: $('#' + form_id).serialize(),
							success: function (response) {
								hide_loader();
								if (page_name == 'loan_disbursement') {
									if (response == 'Insufficient Cash In Hand' || response == 'Unable To Disburse.Contact Admin') {
										Swal.fire({
											type: 'error',
											title: 'Oops',
											text: response,
										})
									} else {
										window.location.href = base_url + '/admin/' + page_name;
									}
								} else {
									window.location.href = base_url + '/admin/' + page_name;
								}
							},
							error: function (xhr, status, error) {
								hide_loader();
							}
						});

					} else {
						$('#' + form_id).submit();
					}


				}
				form.classList.add('was-validated');
			});
		}

	}

	if (page_group == 'list') {

		$(document).ready(function () {
			$('#bs4-table').DataTable({
				"bLengthChange": false,
				"pageLength": 20
			});
		});

		$(document).on('change', '.filter_field', function (e) {
			$('.filter_form').submit();
		});

		$(document).on('blur', '.filter_date_field', function (e) {

			$('.filter_form').submit();
		});

		function delete_data(url) {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					Swal.fire(
						'Deleted!',
						'Data has been deleted.',
						'success'
					)
					show_loader();
					window.location.href = base_url + '/admin/' + url;
				}

			});
		}
	}
	if (page_name == 'capital_investment') {
		$(function () {
			$('#capital_investment').DataTable({
				"bLengthChange": false,
				"pageLength": '100000',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": "100%",
				"bSort": false,
				"order": [[0, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'pdf',
						"text": 'PDF',
						"title": page_name,
						"action": newexportaction
					},

					{
						"extend": 'csv',
						"text": 'CSV',
						"title": page_name,
						"action": newexportaction
					},
				],
				"ajax": {
					url: base_url + '/admin/capital_investment_list',
					type: "get",
					data: filters,

					error: function () {  // error handling
						$("#capital_investment").html("");
						$("#capital_investment").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});
	}

	if (page_name == 'dynamic_form') {

		$(document).on('change', '#dynamic_form_field_type', function () {
			if ($(this).val() != 'dropdown') {
				$('#dynamic_form_field_options_div').hide();
			} else {
				$('#dynamic_form_field_options_div').show();
			}
		});

		function remove_current_row(This, e) {
			if (confirm("Are you sure to delete?") == true) {
				$(This).closest('tr').remove();

			} else {
				e.preventDefault();
				e.stopPropagation();
				return false;
			}
		}

		function add_new_row(count) {
			tot_rows = parseInt(count) + parseInt(1);
			$('#line_item_count').val(tot_rows);
			var date = '<?php echo date("Y-m"); ?>';
			var tab = "<tr id='tr_" + tot_rows + "'>";
			tab += "<td><input type='text' id='dynamic_form_field_options" + tot_rows + "' name='dynamic_form_field_options[]' class='form_control' required  ></td>";
			tab += "<td id='td_" + tot_rows + "'><button class='btn btn_secondary' onclick='remove_current_row(this,event)'><i class='la la-trash-o' style='color:#ff5050 !important;font-size:20px' ></i></button></td>";

			tab += "</tr>";
			$('#dynamic_field_options_table').append(tab);

		}
	}

	if (page_name == 'employee') {

		function change_form(direction) {
			var full_form_name = 'employee_form';
			var form_name = $('#current_form').val();
			var valid = 0;
			$('#' + full_form_name + ' #' + form_name + ' input').each(function () {
				if (!this.checkValidity()) {
					$(this).css('border', '2px solid red');
					valid++;
				} else {
					$(this).css('border', '2px solid green');
				}
			});

			if ((direction == 'next' && valid == 0) || (direction == 'previous')) {
				show_loader();

				var form_arr = ['personal_information', 'address_details', 'bank_details', 'id_proofs', 'pay_details', 'others'];

				var key = form_arr.indexOf(form_name);

				if (direction == 'next')
					key += 1;
				else
					key -= 1;

				if (key > 0) {
					$('#prev_button').attr('onclick', "change_form('previous')");
				} else {
					$('#prev_button').attr('onclick', 'return false;');
				}

				if ((key === (parseInt(form_arr.length) - 1)) || ($('#' + form_arr[key + 1]).find('input').length < 1)) {
					$('#next_button').attr('onclick', "submit_form('" + full_form_name + "')");
					$('#next_button').text('Submit');
				} else {
					$('#next_button').attr('onclick', "change_form('next')");
					$('#next_button').text('Next');
				}


				$('#current_form').val(form_arr[key]);
				$('.tab-section').addClass('tab-section-hide');
				$('#' + form_arr[key]).removeClass('tab-section-hide');
				$('.tabs').removeClass('tab-width-active').addClass('tab-width disabled');
				$('#' + form_arr[key] + '_tab').addClass('tab-width-active').removeClass('tab-width disabled');
				hide_loader();
			}

		}


		$(document).on('blur', '#employee_user_name', function (e) {
			var user_name = $(this).val();
			var employee_id = btoa($(this).attr('employee_id'));
			show_loader();
			$.ajax({
				type: 'GET',
				url: base_url + '/admin/check_user_name?user_name=' + user_name + '&employee_id=' + employee_id,
				success: function (data) {
					if (data != 'Valid') {
						$('#user_name_valid').text(data);
						$('#employee_user_name').val('');
						$('#employee_user_name').focus();
					} else {
						$('#user_name_valid').text('');
					}
					hide_loader();
				},
				error: function (xhr, status, error) {
					hide_loader();
				}
			});

		});
		$(document).on('change', '#employee_create_login', function (e) {
			if ($(this).val() == 'no') {
				$('#employee_user_name').removeAttr('required');
				$('#employee_password').removeAttr('required');
				$('#employee_user_name_div').hide();
				$('#employee_password_div').hide();

			} else {
				$('#employee_user_name').attr('required', 'required');
				$('#employee_password').attr('required', 'required');
				$('#employee_user_name_div').show();
				$('#employee_password_div').show();
			}
		});

		$(document).on('change', '#employee_status', function (e) {
			if ($(this).val() !== 'relieved') {
				$('#employee_lwd').removeAttr('required');
				$('#employee_lwd_div').hide();

			} else {
				$('#employee_lwd').attr('required', 'required');
				$('#employee_lwd_div').show();
			}
		});

		function copy_address(el) {
			if ($(el).is(':checked')) {
				$('#employee_permanent_address_line1').val($('#employee_present_address_line1').val());
				$('#employee_permanent_address_line2').val($('#employee_present_address_line2').val());
				$('#employee_permanent_location').val($('#employee_present_location').val()).trigger('change');
				$('#employee_permanent_pincode').val($('#employee_present_pincode').val());

			} else {
				$('#employee_permanent_address_line1').val('');
				$('#employee_permanent_address_line2').val('');
				$('#employee_permanent_location').val('').trigger('change');
				$('#employee_permanent_pincode').val('');
			}
		}

		function readURL(input, id) {
			id = id;
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$(id).attr('src', e.target.result);
					$(id + '_cropper').attr('src', e.target.result);
					$('#cropper_image_name').val(id);
					$('#imageCropModal').modal({ backdrop: 'static', keyboard: false }, 'show');
				};
				reader.readAsDataURL(input.files[0]);
			}
		}

		var cropper1, cropper2, cropper3, cropper4;
		$(document).on('shown.bs.modal', '#imageCropModal', function () {
			var cropper_image_name = $('#cropper_image_name').val();
			$('.modal_preview').addClass('tab-section-hide');
			$(cropper_image_name + '_cropper_div').removeClass('tab-section-hide');
			if (cropper_image_name == '#employee_image_preview') {

				if (cropper1) {
					cropper1.destroy();
				}

				cropper1 = new Cropper($('#employee_image_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3,
				});

				$('#cropImageBtn').attr('onclick', 'crop_image("cropper1")');
			} else if (cropper_image_name == '#employee_aadhar_image_preview') {
				if (cropper2) {
					cropper2.destroy();
				}
				cropper2 = new Cropper($('#employee_aadhar_image_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("cropper2")');
			} else if (cropper_image_name == '#employee_pan_image_preview') {
				if (cropper3) {
					cropper3.destroy();
				}
				cropper3 = new Cropper($('#employee_pan_image_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("cropper3")');
			} else if (cropper_image_name == '#employee_dl_image_preview') {
				if (cropper4) {
					cropper4.destroy();
				}
				cropper4 = new Cropper($('#employee_dl_image_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("cropper4")');
			}




		}).on('hidden.bs.modal', function () {
			// cropper1.destroy();
			// cropper1 = null;
			// cropper2.destroy();
			// cropper2 = null;
			// cropper3.destroy();
			// cropper3 = null;
		});

		function crop_image(cropper) {
			if (cropper) {

				if (cropper == 'cropper1') {
					canvas = cropper1.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, $('#employee_code').val() + '_image.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#employee_image').prop('files', container.files);

					$('#employee_image_preview').attr('src', img_src);

				} else if (cropper == 'cropper2') {
					canvas = cropper2.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, $('#employee_code').val() + '_aadhar_image.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#employee_aadhar_image').prop('files', container.files);

					$('#employee_aadhar_image_preview').attr('src', img_src);

				} else if (cropper == 'cropper3') {
					canvas = cropper3.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, $('#employee_code').val() + '_pan_image.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#employee_pan_image').prop('files', container.files);

					$('#employee_pan_image_preview').attr('src', img_src);

				} else if (cropper == 'cropper4') {
					canvas = cropper4.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, $('#employee_code').val() + '_dl_image.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#employee_dl_image').prop('files', container.files);

					$('#employee_dl_image_preview').attr('src', img_src);
				}

				$('#imageCropModal').modal('hide');
			} else {
				comsole.log("error" + cropper);
			}
		}

		function dataURLtoFile(dataurl, filename) {
			var arr = dataurl.split(",");
			var mime = arr[0].match(/:(.*?);/)[1];
			var bstr = atob(arr[1]);
			var n = bstr.length;
			var u8arr = new Uint8Array(n);
			while (n--) {
				u8arr[n] = bstr.charCodeAt(n);
			}
			return new File([u8arr], filename, { type: mime });
		}

	}
	if (page_name == 'permission') {
		$(document).on('click', '#selectAll_view_permission', function () {
			$('.view_permission').prop('checked', this.checked);
		});

		$(document).on('click', '#selectAll_edit_permission', function () {
			$('.edit_permission').prop('checked', this.checked);
		});

		$(document).on('click', '#selectAll_delete_permission', function () {
			$('.delete_permission').prop('checked', this.checked);
		});

		$('.select-row').on('change', function () {
			var isChecked = $(this).is(':checked');
			$(this).closest('tr').find('.view_permission, .edit_permission, .delete_permission').prop('checked', isChecked);
		});
	}

	if (page_name == 'center') {
		$(function () {
			$('#center_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": true,
				'processing': true,
				"scrollx": true,
				"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/get_center_list',
					type: "get",

					error: function () {  // error handling
						$("#center_list").html("");
						$("#center_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});
	}


	if (page_name == 'office_transaction') {
		$(function () {
			$('#ot_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": true,
				'processing': true,
				"scrollx": true,
				"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/get_office_transaction_list',
					type: "post",

					error: function () {  // error handling
						$("#ot_list").html("");
						$("#ot_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('change', '#ot_type_id', function () {

			var category = $('#ot_type_id').find("option:selected").attr('ot_category_option');

			$('#ot_category').val(category);
		});
	}

	if (page_name == 'fund_transfer') {
		$(function () {
			$('#fund_transfer_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/get_fund_transfer_list',
					type: "get",

					error: function () {  // error handling
						$("#fund_transfer_list").html("");
						$("#fund_transfer_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});
	}
	if (page_name == 'customer') {

		$(function () {
			$('#customer_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": true,
				'processing': true,
				"scrollx": true,
				"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/get_customer_list',
					type: "get",

					error: function () {  // error handling
						$("#customer_list").html("");
						$("#customer_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		if ($('#enable_otp_verification').val() == 'yes') {
			//$('#next_button').attr('onclick',"return false;");
		} else {
			$('#customer_primary_contact').append("<input type='hidden' id='otp'>");
			$('#otp').val('verified');
		}

		function change_form(direction) {
			var full_form_name = 'customer_form';
			var form_name = $('#current_form').val();
			var valid = 0;
			$('#' + full_form_name + ' #' + form_name + ' input').each(function () {
				if (!this.checkValidity()) {
					$(this).css('border', '2px solid red');
					valid++;
				} else {
					$(this).css('border', '2px solid green');
				}
			});

			if ((direction == 'next' && valid == 0) || (direction == 'previous')) {
				show_loader();

				$('#next_button').show();

				var form_arr = ['personal_information', 'address_details', 'id_proofs', 'bank_details', 'guarantor_information', 'others'];

				var key = form_arr.indexOf(form_name);

				if (direction == 'next')
					key += 1;
				else
					key -= 1;

				if (key > 0) {
					$('#prev_button').attr('onclick', "change_form('previous')");
				} else {
					$('#prev_button').attr('onclick', 'return false;');
				}
				if ((key === (parseInt(form_arr.length) - 1))) {
					if ('<?php echo $show_save ?? "no" ?>' == 'yes') {
						if ($('#otp').val() == 'verified') {
							$('#next_button').attr('onclick', "submit_form('" + full_form_name + "')");
							$('#next_button').text('Submit');
						} else {
							$('#next_button').attr('onclick', "return false;");
							$('#next_button').hide();
						}

					} else {
						$('#next_button').attr('onclick', "return false;");
						$('#next_button').hide();
					}

				} else {
					$('#next_button').attr('onclick', "change_form('next')");
					$('#next_button').text('Next');
				}


				$('#current_form').val(form_arr[key]);
				$('.tab-section').addClass('tab-section-hide');
				$('#' + form_arr[key]).removeClass('tab-section-hide');
				$('.tabs').removeClass('tab-width-active').addClass('tab-width disabled');
				$('#' + form_arr[key] + '_tab').addClass('tab-width-active').removeClass('tab-width disabled');
				hide_loader();
			}

		}

		$(document).on('change', '#customer_dob', function () {
			var today = new Date();
			var birthDate = new Date($(this).val());
			var age = today.getFullYear() - birthDate.getFullYear();
			var m = today.getMonth() - birthDate.getMonth();
			if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				age--;
			}
			$('#customer_age').val(age);
		});
		$(document).on('blur', '#customer_aadhar_no', function () {

			var aadhar = $(this).val();

			if (aadhar.length == 16) {
				show_loader();
				$.ajax({
					type: 'GET',
					url: base_url + '/admin/check_customer_validation?aadhar_no=' + aadhar,
					success: function (data) {
						$('#mem_valid').html(data);
						if (data != 'New Customer')
							$('#customer_aadhar_no').val('');
						hide_loader();
					}
				});
			}

		});
		$(document).on('blur', '#customer_smart_card_no', function () {

			var customer_smart_card_no = $(this).val();
			show_loader();
			$.ajax({
				type: 'GET',
				url: base_url + '/admin/check_customer_smart_card?smartcard_no=' + customer_smart_card_no,
				success: function (data) {
					$('#smartcard_valid').html(data);
					if (data != 'New Customer')
						$('#customer_smart_card_no').val('');
					hide_loader();
				}
			});

		});

		$(document).on('blur', '#customer_primary_contact', function () {

			var mobile = $('#customer_primary_contact').val();
			var valid_mobile = mobile;
			valid_mobile = valid_mobile.replace(/\s+/g, "");
			if (valid_mobile == '' || valid_mobile.length != 10) {
				alert("Please enter valid mobile number");
				$('#customer_primary_contact').val('');
			} else {
				show_loader();
				$.ajax({
					type: 'GET',
					url: base_url + '/admin/check_customer_mobile?mobile=' + mobile,
					success: function (data) {
						$('#mobile_primary_valid').html(data);
						if (data != 'New Customer') {
							$('#customer_primary_contact').val('');
							$('#sendOtpBtn').hide();
							hide_loader();
						} else {
							if ($('#enable_otp_verification') == 'yes') {
								$('#sendOtpBtn').show();
								$('#sendOtpBtn').trigger('click');
							} else {
								hide_loader();
							}

						}


					}
				});
			}

		});

		$(document).on('blur', '#customer_secondary_contact', function () {

			var mobile = $(this).val();
			show_loader();
			$.ajax({
				type: 'GET',
				url: base_url + '/admin/check_customer_mobile?mobile=' + mobile,
				success: function (data) {
					$('#mobile_secondary_valid').html(data);
					if (data != 'New Customer')
						$('#customer_secondary_contact').val('');
					hide_loader();
				}
			});

		});

		$(document).on('change', '#customer_status', function (e) {
			if ($(this).val() == 'active') {
				$('#customer_dropout_reason').removeAttr('required');
				$('#customer_dropout_reason_div').hide();

			} else {
				$('#customer_dropout_reason').attr('required', 'required');
				$('#customer_dropout_reason_div').show();
			}
		});

		$(document).on('change', '#assign_center', function (e) {

			if ($(this).val() == 'no') {
				$('#customer_center_head').removeAttr('required');
				$('#customer_center_head_div').hide();
				$('#customer_center_id').removeAttr('required');
				$('#customer_center_id_div').hide();

			} else {
				$('#customer_center_head').attr('required', 'required');
				$('#customer_center_head_div').show();
				$('#customer_center_id').attr('required', 'required');
				$('#customer_center_id_div').show();
			}
		});

		$(document).on('click', '#sendOtpBtn', function (e) {
			var mobile = $('#customer_primary_contact').val().replace(/\s+/g, "");
			if (mobile == '' || mobile.length != 10) {
				alert("Please enter valid mobile number");
			} else {
				show_loader();
				$.ajax({
					type: 'GET',
					url: base_url + '/admin/customer_otp_verification?mobile=' + mobile + '&sms_name=customer_otp',
					success: function (data) {
						data = JSON.parse(data);
						if (data.status) {
							$('#otp').remove();
							$('#customer_primary_contact').append("<input type='hidden' id='otp'>");
							$('#otpModal').modal('show');
							$('#otp').val(data.otp);
						} else {
							alert(data.message);
						}


						hide_loader();
					}
				});
			}

		});

		$(document).on('keyup', '.otp-input', function (e) {
			if (this.value.length == this.maxLength) {
				$(this).next('.otp-input').focus();
			}
		});

		$(document).on('click', '#verify_otp', function (e) {
			var otp = $('#otpInput1').val() + $('#otpInput2').val() + $('#otpInput3').val() + $('#otpInput4').val() + $('#otpInput5').val() + $('#otpInput6').val();
			if (btoa(otp) == $('#otp').val()) {
				alert("verified successfully;");
				$('#otp').val('verified');
				$('#sendOtpBtn').removeClass('btn-accent').addClass('btn-success').text('Verified').attr('id', 'verified');
				$('#otpModal').modal('hide');
				$('.otp-input').val('');
				$('#next_button').attr('onclick', "change_form('next')");
			} else {
				alert("Invalid OTP.");
				$('.otp-input').val('');
			}

		});

		function copy_address(el) {
			if ($(el).is(':checked')) {
				$('#permanent_address_line1').val($('#present_address_line1').val());
				$('#permanent_address_line2').val($('#present_address_line2').val());
				$('#permanent_address_location_id').val($('#present_address_location_id').val()).trigger('change');
				$('#permanent_address_pincode').val($('#present_address_pincode').val());

			} else {
				$('#permanent_address_line1').val('');
				$('#permanent_address_line2').val('');
				$('#permanent_address_location_id').val('').trigger('change');
				$('#permanent_address_pincode').val('');
			}
		}

		function readURL(input, id) {
			id = id;
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$(id).attr('src', e.target.result);
					$(id + '_cropper').attr('src', e.target.result);
					$('#cropper_image_name').val(id);
					$('#imageCropModal').modal({ backdrop: 'static', keyboard: false }, 'show');
				};
				reader.readAsDataURL(input.files[0]);
			}
		}

		var customer_cropper, guarantor_cropper, customer_primary_proof_image_front_preview_cropper, customer_secondary_proof_image_back_preview_cropper, customer_aadhar_image_front_preview_cropper, customer_aadhar_image_back_preview_cropper, customer_smartcard_image_front_preview_cropper, customer_smartcard_image_back_preview_cropper, customer_primary_proof_image_back_preview_cropper, customer_secondary_proof_image_front_preview_cropper;
		$(document).on('shown.bs.modal', '#imageCropModal', function () {
			var cropper_image_name = $('#cropper_image_name').val();
			$('.modal_preview').addClass('tab-section-hide');
			$(cropper_image_name + '_cropper_div').removeClass('tab-section-hide');
			if (cropper_image_name == '#customer_image_preview') {

				if (customer_cropper) {
					customer_cropper.destroy();
				}

				customer_cropper = new Cropper($('#customer_image_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3,
				});

				$('#cropImageBtn').attr('onclick', 'crop_image("customer_cropper")');
			} else if (cropper_image_name == '#guarantor_image_preview') {

				if (guarantor_cropper) {
					guarantor_cropper.destroy();
				}

				guarantor_cropper = new Cropper($('#guarantor_image_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3,
				});

				$('#cropImageBtn').attr('onclick', 'crop_image("guarantor_cropper")');
			} else if (cropper_image_name == '#customer_primary_proof_image_front_preview') {
				if (customer_primary_proof_image_front_preview_cropper) {
					customer_primary_proof_image_front_preview_cropper.destroy();
				}
				customer_primary_proof_image_front_preview_cropper = new Cropper($('#customer_primary_proof_image_front_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_primary_proof_image_front_preview_cropper")');
			} else if (cropper_image_name == '#customer_primary_proof_image_back_preview') {
				if (customer_primary_proof_image_back_preview_cropper) {
					customer_primary_proof_image_back_preview_cropper.destroy();
				}
				customer_primary_proof_image_back_preview_cropper = new Cropper($('#customer_primary_proof_image_back_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_primary_proof_image_back_preview_cropper")');
			} else if (cropper_image_name == '#customer_secondary_proof_image_back_preview') {
				if (customer_secondary_proof_image_back_preview_cropper) {
					customer_secondary_proof_image_back_preview_cropper.destroy();
				}
				customer_secondary_proof_image_back_preview_cropper = new Cropper($('#customer_secondary_proof_image_back_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_secondary_proof_image_back_preview_cropper")');
			} else if (cropper_image_name == '#customer_secondary_proof_image_front_preview') {
				if (customer_secondary_proof_image_front_preview_cropper) {
					customer_secondary_proof_image_front_preview_cropper.destroy();
				}
				customer_secondary_proof_image_front_preview_cropper = new Cropper($('#customer_secondary_proof_image_front_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_secondary_proof_image_front_preview_cropper")');
			} else if (cropper_image_name == '#customer_aadhar_image_front_preview') {
				if (customer_aadhar_image_front_preview_cropper) {
					customer_aadhar_image_front_preview_cropper.destroy();
				}
				customer_aadhar_image_front_preview_cropper = new Cropper($('#customer_aadhar_image_front_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_aadhar_image_front_preview_cropper")');
			}
			else if (cropper_image_name == '#customer_aadhar_image_back_preview') {
				if (customer_aadhar_image_back_preview_cropper) {
					customer_aadhar_image_back_preview_cropper.destroy();
				}
				customer_aadhar_image_back_preview_cropper = new Cropper($('#customer_aadhar_image_back_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_aadhar_image_back_preview_cropper")');
			} else if (cropper_image_name == '#customer_smartcard_image_back_preview') {
				if (customer_smartcard_image_back_preview_cropper) {
					customer_smartcard_image_back_preview_cropper.destroy();
				}
				customer_smartcard_image_back_preview_cropper = new Cropper($('#customer_smartcard_image_back_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_smartcard_image_back_preview_cropper")');
			} else if (cropper_image_name == '#customer_smartcard_image_front_preview') {
				if (customer_smartcard_image_front_preview_cropper) {
					customer_smartcard_image_front_preview_cropper.destroy();
				}
				customer_smartcard_image_front_preview_cropper = new Cropper($('#customer_smartcard_image_front_preview_cropper')[0], {
					aspectRatio: 1,
					viewMode: 3
				});
				$('#cropImageBtn').attr('onclick', 'crop_image("customer_smartcard_image_front_preview_cropper")');
			}




		}).on('hidden.bs.modal', function () {

		});

		function crop_image(cropper) {
			var image_name = $('#customer_name').val() + '_' + Date.now();

			image_name.replace(' ', '_');

			if (cropper) {

				if (cropper == 'customer_cropper') {
					canvas = customer_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_image.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_image').prop('files', container.files);

					$('#customer_image_preview').attr('src', img_src);

				} else if (cropper == 'guarantor_cropper') {
					canvas = guarantor_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_guarantor_image.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#guarantor_image').prop('files', container.files);

					$('#guarantor_image_preview').attr('src', img_src);

				} else if (cropper == 'customer_primary_proof_image_front_preview_cropper') {
					canvas = customer_primary_proof_image_front_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_primary_proof.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_primary_proof_image_front').prop('files', container.files);

					$('#customer_primary_proof_image_front_preview').attr('src', img_src);

				} else if (cropper == 'customer_primary_proof_image_back_preview_cropper') {
					canvas = customer_primary_proof_image_back_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_primary_proof.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_primary_proof_image_back').prop('files', container.files);

					$('#customer_primary_proof_image_back_preview').attr('src', img_src);

				} else if (cropper == 'customer_secondary_proof_image_back_preview_cropper') {
					canvas = customer_secondary_proof_image_back_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_secondary_proof.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_secondary_proof_image_back').prop('files', container.files);

					$('#customer_secondary_proof_image_back_preview').attr('src', img_src);

				} else if (cropper == 'customer_secondary_proof_image_front_preview_cropper') {
					canvas = customer_secondary_proof_image_front_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_secondary_proof.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_secondary_proof_image_front').prop('files', container.files);

					$('#customer_secondary_proof_image_front_preview').attr('src', img_src);

				} else if (cropper == 'customer_aadhar_image_front_preview_cropper') {
					canvas = customer_aadhar_image_front_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_aadhar_front.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_aadhar_image_front').prop('files', container.files);

					$('#customer_aadhar_image_front_preview').attr('src', img_src);
				}
				else if (cropper == 'customer_aadhar_image_back_preview_cropper') {
					canvas = customer_aadhar_image_back_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_aadhar_back.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_aadhar_image_back').prop('files', container.files);

					$('#customer_aadhar_image_back_preview').attr('src', img_src);
				} else if (cropper == 'customer_smartcard_image_front_preview_cropper') {
					canvas = customer_smartcard_image_front_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_smartcard_front.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_smartcard_image_front').prop('files', container.files);

					$('#customer_smartcard_image_front_preview').attr('src', img_src);
				}
				else if (cropper == 'customer_smartcard_image_back_preview_cropper') {
					canvas = customer_smartcard_image_back_preview_cropper.getCroppedCanvas();

					var img_src = canvas.toDataURL();

					var file = dataURLtoFile(img_src, image_name + '_smartcard_back.png');

					let container = new DataTransfer();

					container.items.add(file);

					$('#customer_smartcard_image_back').prop('files', container.files);

					$('#customer_smartcard_image_back_preview').attr('src', img_src);
				}

				$('#imageCropModal').modal('hide');
			} else {
				comsole.log("error" + cropper);
			}
		}

		function dataURLtoFile(dataurl, filename) {
			var arr = dataurl.split(",");
			var mime = arr[0].match(/:(.*?);/)[1];
			var bstr = atob(arr[1]);
			var n = bstr.length;
			var u8arr = new Uint8Array(n);
			while (n--) {
				u8arr[n] = bstr.charCodeAt(n);
			}
			return new File([u8arr], filename, { type: mime });
		}
	}

	function get_branch_based_on_loc(id, selected_value) {
		show_loader();
		$.ajax({
			url: base_url + '/admin/get_branch_based_on_loc?location_id=' + selected_value,
			type: 'GET',
			success: function (response) {
				$('#' + id).html(response)
				$('#' + id).val('').trigger('change');
				hide_loader();
			},
			error: function (xhr, status, error) {
				alert('select another location');
				hide_loader();
			}
		});

	}

	function get_center_based_on_branch(id, selected_value) {
		show_loader();
		$.ajax({
			url: base_url + '/admin/get_center_based_on_branch?branch_id=' + selected_value,
			type: 'GET',
			success: function (response) {
				$('#' + id).html(response)
				$('#' + id).val('').trigger('change');
				hide_loader();
			},
			error: function (xhr, status, error) {
				alert('select another location');
				hide_loader();
			}
		});

	}

	function get_employee_based_on_branch(id, selected_value) {
		show_loader();
		$.ajax({
			url: base_url + '/admin/get_employee_based_on_branch?location_id=' + selected_value,
			type: 'GET',
			success: function (response) {
				$('#' + id).html(response)
				$('#' + id).val('').trigger('change');
				if (page_name == 'center') {
					$('#center_collection_staff_id').html(response)
					$('#center_collection_staff_id').val('').trigger('change');
				}
				if (page_name == 'loan_application') {
					$('#la_collection_staff').html(response);
					$('#la_collection_staff').val('').trigger('change');
				}
				hide_loader();

			},
			error: function (xhr, status, error) {
				alert('select another location');
				hide_loader();
			}
		});

	}

	function get_employee_based_on_position(id, selected_value) {
		$.ajax({
			url: base_url + '/admin/get_employee_based_on_position?position_id=' + selected_value,
			type: 'GET',
			success: function (response) {
				$('#' + id).html(response)
				$('#' + id).val('').trigger('change');
				if (page_name == 'center') {
					$('#center_collection_staff_id').html(response)
					$('#center_collection_staff_id').val('').trigger('change');
				}
				if (page_name == 'loan_application') {
					$('#la_collection_staff').html(response);
					$('#la_collection_staff').val('').trigger('change');
				}
				hide_loader();

			},
			error: function (xhr, status, error) {
				alert('select another location');
				hide_loader();
			}
		});
	}

	$(document).on('change', '.get_branch_based_on_loc', function () {
		var id = $(this).attr('replace_id');
		var selected_value = btoa($(this).val());
		if (selected_value != '')
			get_branch_based_on_loc(id, selected_value);
	});

	$(document).on('change', '.get_center_based_on_branch', function () {
		var id = $(this).attr('replace_id');
		var selected_value = btoa($(this).val());
		if (page_name == 'center') {
			id = 'center_parent_id';
		}
		if (selected_value != '')
			get_center_based_on_branch(id, selected_value);

	});

	$(document).on('change', '.get_employee_based_on_branch', function () {
		var id = $(this).attr('replace_id');
		var selected_value = btoa($(this).val());
		if (selected_value != '')
			get_employee_based_on_branch(id, selected_value)

	});

	if (page_name == 'employee_position') {


		$(document).on('change', '#assign_multiple_employee', function () {
			var option = $(this).val();
			if (option == 'yes') {
				$('#employee_id_add_new_btn').show();
			} else {
				$('#employee_id_add_new_btn').hide();
				$('#employee_position_employee_id_table tr:not(:first-child)').remove();
				add_new_row($('#line_item_count').val())
			}
		});

		//27-02-2024 employee name on emploee position change
		$(document).on('change', '#employee_position_primary_reporting_to', function () {
			var id = $(this).attr('replace_id');
			var selected_value = btoa($(this).val());
			if (selected_value != '')
				get_employee_based_on_position(id, selected_value);
		});

		function remove_current_row(This, e) {
			var result = confirm("Are you sure to delete?");
			if (result) {
				$(This).closest('tr').remove();
				var tot_length = $('#employee_position_employee_id_table tr').length;
				if (tot_length == 2) {
					$('.rm_btn').hide();
				}

			} else {
				e.preventDefault();
				e.stopPropagation();
				return false;

			}
		}

		function add_new_row(count, release_employee = '') {
			if (count == 0)
				count = 1;
			var multiple_employee = $('#assign_multiple_employee').val();

			if ((multiple_employee == 'no' && release_employee == 'no') || (multiple_employee == 'yes' && release_employee != '')) {
				if (multiple_employee == 'no')
					$('#employee_id_add_new_btn').hide();

				return false;
			}

			tot_rows = parseInt(count) + parseInt(1);
			$('#line_item_count').val(tot_rows);
			var date = '<?php echo date("Y-m-d"); ?>';
			var tab = "<tr id='tr_" + tot_rows + "'>";

			tab += '<td><input type="text" row_id = "' + tot_rows + '" class="form-control employee_name_autocomplete" id= "employee_name' + tot_rows + '" name="employee_position_employee_id[' + tot_rows + '][employee_name]"  required>	<input type="hidden" id= "employee_id' + tot_rows + '" name="employee_position_employee_id[' + tot_rows + '][employee_id]"  required></td>';

			tab += '<td><input type="date" class="form-control" id= "employee_start_date' + tot_rows + '" name="employee_position_employee_id[' + tot_rows + '][employee_start_date]" valid="' + date + '"  required></td>';

			tab += '<td><input type="date" class="form-control" id= "employee_end_date' + tot_rows + '" name="employee_position_employee_id[' + tot_rows + '][employee_end_date]" ></td>';

			tab += '<td><select class="form-control" name = "employee_position_employee_id[' + tot_rows + '][employee_released]" id = "employee_released" required >												<option value = "no"  >No</option><option value = "yes"  >Yes</option>											</select></td>';

			tab += "<td id='td_" + tot_rows + "'><button class='btn btn_secondary rm_btn' id='employee_history_delete_btn" + tot_rows + "' onclick='remove_current_row(this,event)'><i class='la la-trash-o' style='color:#ff5050 !important;font-size:20px' ></i></button></td>";

			tab += "</tr>";

			$('#employee_position_employee_id_table').append(tab);

		}
	}

	if (page_name == 'product') {

		$("#myModal").on("show.bs.modal", function (e) {
			var link = $(e.relatedTarget);
			$(this).find(".modal-body").load(link.attr("href"));
			var title = link.attr("title");
			$("#myModalLabel").text(title);
		});

		$(document).on('blur', '#product_total_dues', function () {
			if ($('#product_amount').val() > 0) {
				var total_dues = $(this).val();
				if (total_dues > 0) {
					var due_table = "<table class='table table-striped table-responsive table-bordered'>" +
						"<tr>" +
						"<th>Due No</th>" +
						"<th>Principal Amount</th>" +
						"<th>Interest Amount</th>" +
						"<th>Total EMI</th>" +
						"<th>Balance Amount</th>" +
						"</tr>";
					for (i = 1; i <= total_dues; i++) {
						due_table += "<tr>" +
							"<td>" + i + "</td>" +
							"<td><input type='text' row_no='" + i + "' class='form-control calculate_due_amount calculate_principal_amount' name='principal_amount[]' id='pricipal_amount_" + i + "' onkeypress='if((event.keyCode < 46)||(event.keyCode > 57)) event.returnValue = false;' required></td>" +
							"<td><input type='text' row_no='" + i + "' class='form-control calculate_due_amount' name='interest_amount[]' id='interest_amount_" + i + "' onkeypress='if((event.keyCode < 46)||(event.keyCode > 57)) event.returnValue = false;' required></td>" +
							"<td><input type='text' row_no='" + i + "' class='form-control' name='total_emi[]' id='total_emi_" + i + "' onkeypress='if((event.keyCode < 46)||(event.keyCode > 57)) event.returnValue = false;' required readonly></td>" +
							"<td><input type='text' row_no='" + i + "' class='form-control' name='balance[]' id='balance_" + i + "' onkeypress='if((event.keyCode < 46)||(event.keyCode > 57)) event.returnValue = false;' required readonly ></td>" +
							"</tr>";
					}
					due_table += "</table>";
					$('#due_details').html(due_table);
				} else {
					$('#due_details').html('');
				}
			} else {
				$('#product_total_dues').val('');
				$('#product_amount').focus();
			}
		});

		$(document).on('keyup', '.calculate_due_amount', function () {
			var row_no = $(this).attr('row_no');
			var p_amount = $('#pricipal_amount_' + row_no).val();
			var i_amount = $('#interest_amount_' + row_no).val();
			if (i_amount > 0 || p_amount > 0) {
				var tot_emi = parseInt(p_amount) + parseInt(i_amount);
				tot_emi = (tot_emi > 0) ? tot_emi : "";
				$('#total_emi_' + row_no).val(tot_emi);
				if (p_amount > 0) {
					var tot_principal = 0;
					// for(i=1;i<=row_no;i++)
					// {
					// 	tot_principal += parseInt($('#pricipal_amount_'+row_no).val());
					// }

					$('.calculate_principal_amount').each(function () {
						var cur_val = ($(this).val() == '') ? 0 : $(this).val();
						tot_principal += parseInt(cur_val);
					});

					var balance = parseInt($('#product_amount').val()) - tot_principal;
					if (row_no == $('#product_total_dues').val()) {
						var balance = 0;
					}
					$('#balance_' + row_no).val(balance);
				}
			}
		});
	}

	if (page_name == 'loan_disbursement') {

		$(function () {
			$('#loan_disbursement').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": true,
				'processing': true,
				"scrollx": true,
				"order": [[0, 'desc']],
				"ajax": {
					url: base_url + '/admin/loan_disbursement_list',
					type: "get",

					error: function () {  // error handling
						$("#loan_disbursement").html("");
						$("#loan_disbursement").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('change', '#ld_branch_id', function (e) {
			$('#center_customer_div').html('');
			$('#customer_details').html('');
			$('#ld_loan_type').val('').trigger('change');
		});

		$(document).on('change', '#ld_loan_type', function (e) {
			var group_loan = $(this).find("option:selected").attr('group_loan');
			var branch_id = btoa($('#ld_branch_id').val());
			var loan_type = $(this).val();
			if (group_loan != undefined && branch_id != '' && loan_type != '') {
				show_loader();
				$.ajax({
					url: base_url + '/admin/get_field_by_loan_type_disbursement?branch_id=' + branch_id + '&group_loan=' + group_loan + '&loan_type=' + loan_type,
					type: 'GET',
					success: function (response) {
						$('#customer_details').html('');
						$('#center_customer_div').html('');
						$('#center_customer_div').html(response);
						$('select').select2({ width: '100%' });
						hide_loader();
					},
					error: function (xhr, status, error) {
						hide_loader();
						alert('select branch and loan type');

					}
				});


			}
		});
		function get_loan_details() {
			var center_id = $('#ld_center_id').val();
			center_id = (center_id != 'undefined') ? btoa(center_id) : btoa(0);
			var group_loan = $('#ld_loan_type').find("option:selected").attr('group_loan');
			var loan_type = btoa($('#ld_loan_type').val());
			var la_id = btoa($('#ld_id').val());

			// alert(la_id);
			var branch_id = btoa($('#ld_branch_id').val());

			if (group_loan != '' && branch_id != '' && center_id != '') {
				show_loader();
				$.ajax({
					url: base_url + '/admin/get_loan_details_disbursement?group_loan=' + group_loan + '&center_id=' + center_id + '&loan_type=' + loan_type + '&la_id=' + la_id + '&branch_id=' + branch_id,
					type: 'GET',
					dataType: "json",
					success: function (response) {


						$("#sales_staff").val(response["center_creation"]["sales_staff"]);
						$("#collection_staff").val(response.center_creation.collection_staff);
						$("#loan_cycle").val(response.center_creation.center_loan_cycle);
						$("#group_head").val(response.center_creation.customer_name);
						$('#customer_details').html(response.table);
						$('select').select2({ width: '100%' });
						hide_loader();

					},
					error: function (xhr, status, error) {
						alert('select branch and loan type');
						hide_loader();
					}
				});


			}

		}

		function get_loan_application(load_applicant_details = 'no') {
			var center_id = $('#ld_center_id').val();
			center_id = (center_id != 'undefined') ? btoa(center_id) : btoa(0);
			var sel_la_id = $('#ld_center_id').find("option:selected").attr('la_id');
			sel_la_id = (typeof sel_la_id != "undefined") ? btoa(sel_la_id) : '';
			var customer_id = btoa($('#ld_customer_id').val());
			var group_loan = $('#ld_loan_type').find("option:selected").attr('group_loan');
			var loan_type = btoa($('#ld_loan_type').val());
			var la_id = btoa($('#la_id').val());
			var branch_id = btoa($('#ld_branch_id').val());


			if (group_loan != '' && branch_id != '' && center_id != '') {
				show_loader();
				$.ajax({
					url: base_url + '/admin/get_loan_application_details?customer_id=' + customer_id + '&group_loan=' + group_loan + '&center_id=' + center_id + '&loan_type=' + loan_type + '&la_id=' + la_id + '&branch_id=' + branch_id + '&load_applicant_details=' + load_applicant_details + '&sel_la_id=' + sel_la_id,
					type: 'GET',
					success: function (response) {
						$('#customer_details').html(response);
						hide_loader();

					},
					error: function (xhr, status, error) {
						alert('select branch and loan type');
						hide_loader();
					}
				});
			}
		}

	}

	if (page_name == 'loan_application') {
		$("#la_history_modal").on("show.bs.modal", function (e) {
			var link = $(e.relatedTarget);
			$(this).find(".modal-body").load(link.attr("href"));
			var title = link.attr("title");
			$("#myModalLabel").text(title);

		});


		$(function () {
			$('#loan_application').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"order": [[0, 'desc']],
				"ajax": {
					url: base_url + '/admin/loan_application_list',
					type: "get",

					error: function () {  // error handling
						$("#loan_application").html("");
						$("#loan_application").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
			calculate_total_amount();
		});

		$(document).on('change', '.checkbox', function () {
			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
			calculate_total_amount();
		});

		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}

		$(document).on('change', '#la_applied_by_employee_id', function (e) {
			var position_id = $(this).find("option:selected").attr('position_id');
			$('#la_applied_by_position_id').val(position_id);
		});

		$(document).on('change', '#la_branch_id', function (e) {
			$('#center_customer_div').html('');
			$('#customer_details').html('');
			$('#la_loan_type').val('').trigger('change');
		});

		$(document).on('change', '.product_amount_calculation', function (e) {
			var row_no = $(this).attr('row_no');
			var prod_amount = $(this).find("option:selected").attr('product_amount');
			$('#product_amount_' + row_no).val(prod_amount);
			calculate_total_amount();
		});

		function calculate_total_amount() {
			var tot_amount = 0;
			$('.product_amount_hidden').each(function (index) {
				var amount = $(this).val();
				if (!(isNaN(amount)) && $(this).closest('tr').find('.checkbox').is(":checked")) {
					tot_amount = parseInt(tot_amount) + parseInt(amount);
					$('#la_proposed_amount').val(tot_amount);
				}
			});

		}


		$(document).on('change', '#la_status', function (e) {
			var status = $(this).val();
			if (status == 'rejected') {
				$('#la_reject_reason').attr('required', 'required');
				$('#la_reject_reason_div').show();
			} else {
				$('#la_reject_reason').removeAttr('required');
				$('#la_reject_reason_div').hide();
			}
		});

		$(document).on('change', '#la_loan_type', function (e) {
			var group_loan = $(this).find("option:selected").attr('group_loan');
			var branch_id = btoa($('#la_branch_id').val());
			var loan_type = $(this).val();
			if (group_loan != undefined && branch_id != '' && loan_type != '') {
				show_loader();
				$.ajax({
					url: base_url + '/admin/get_field_by_loan_type?branch_id=' + branch_id + '&group_loan=' + group_loan + '&loan_type=' + loan_type,
					type: 'GET',
					success: function (response) {
						$('#customer_details').html('');
						$('#center_customer_div').html('');
						$('#center_customer_div').html(response);
						$('select').select2({ width: '100%' });
						if (group_loan == 'no') {
							$('#collection_staff_div').show();
							$('#la_collection_staff').prop("disabled", false);
						} else {
							$('#collection_staff_div').hide();
							$('#la_collection_staff').attr('disabled', 'disabled');
						}
						hide_loader();
					},
					error: function (xhr, status, error) {
						hide_loader();
						alert('select branch and loan type');
					}
				});

				$.ajax({
					url: base_url + '/admin/get_approval_stage_details?branch_id=' + branch_id + '&group_loan=' + group_loan + '&loan_type=' + loan_type,
					type: 'GET',
					dataType: "json",
					success: function (response) {
						$('#la_approval_stage').val(response.loan_approval_stage_id);
						$('#la_approval_stage_position_id').val(response.position_id);
						$('#la_final_stage').val(response.is_final_stage);
						$('#loan_type_approval_required').val(response.loan_type_approval_required);
						$('#la_approval_stage_level').val(response.loan_approval_stage_level);
						$('#la_is_group_loan').val(response.group_loan);

						hide_loader();
					},
					error: function (xhr, status, error) {
						hide_loader();
						//alert('select branch and loan type');
					}
				});

			}
		});

		function get_customer_details() {
			var center_id = $('#la_center_id').val();
			center_id = (center_id != 'undefined') ? btoa(center_id) : btoa(0);
			var customer_id = btoa($('#la_customer_id').val());
			var group_loan = $('#la_loan_type').find("option:selected").attr('group_loan');
			var loan_type = btoa($('#la_loan_type').val());
			var la_id = btoa($('#la_id').val());
			var branch_id = btoa($('#la_branch_id').val());

			if (group_loan != '' && branch_id != '' && center_id != '') {
				show_loader();
				$.ajax({
					url: base_url + '/admin/get_customer_details?customer_id=' + customer_id + '&group_loan=' + group_loan + '&center_id=' + center_id + '&loan_type=' + loan_type + '&la_id=' + la_id + '&branch_id=' + branch_id,
					type: 'GET',
					success: function (response) {
						$('#customer_details').html(response);
						$('select').select2();
						hide_loader();
					},
					error: function (xhr, status, error) {
						hide_loader();
						alert('select branch and loan type');
					}
				});
			}

		}


		function submit_loan_application(form_name) {
			show_loader();
			var check = 0;
			$('.checkbox').closest('tr').find('input').css('border', '2px solid #ccc');
			$('.checkbox:checked').each(function () {
				var $inputField = $(this).closest('tr').find('input');
				$($inputField).each(function () {
					if ($(this).val() == '') {
						check++;
						$(this).css('border', '2px solid red');
					} else {
						$(this).css('border', '2px solid green');
					}
				});
			});
			hide_loader();
			if (check == 0) {
				submit_form('loan_application_form');
			} else {
				return false;
			}

		}

		function removeFile(index, fileName, la_id) {
			// SweetAlert confirmation
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					show_loader();

					// Perform the AJAX call to delete the file
					$.ajax({
						url: base_url + '/admin/delete_loan_application_document',
						type: 'POST',
						data: {
							index: index, // Pass the file index
							file_name: fileName,
							la_id: la_id
						},
						success: function (response) {
							if (response.success) {
								hide_loader();
								Swal.fire({
									title: 'Deleted!',
									text: 'File has been deleted.',
									icon: 'success'
								}).then(() => {
									// Replace the file link with an input file element
									// $('#file-' + index).html('<input type="file" class="form-control" name="document_uploads[' + index + ']" id="document_' + index + '" accept=".pdf,.doc,.docx,.jpg,.png" />');
									// Reload the page after the deletion is processed
									window.location.reload();
								});
							} else {
								Swal.fire({
									title: 'Error!',
									text: 'Error removing file: ' + response.message,
									icon: 'error'
								});
							}
						},
						error: function (xhr, status, error) {
							console.log('Error:', error);
							Swal.fire({
								title: 'Error!',
								text: 'An error occurred while removing the file.',
								icon: 'error'
							});
						}
					});
				}
			});
		}

		function submit_form(form_id) {
			// $('#'+form_id).submit();					
			var formData = new FormData($('#' + form_id)[0]); // Use FormData to capture all form inputs, including files
			var form = $('#' + form_id);
			var actionUrl = form.attr('action');

			$.ajax({
				url: actionUrl,
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {

					Swal.fire({
						title: "Success",
						text: "Your form has been submitted successfully!",
						type: "success"
					}).then(function () {
						// window.location.reload();
						window.location.href = base_url + '/admin/loan_application';
					});
				},
				error: function (xhr, status, error) {
					console.error("Form submission error:", error);
					Swal.fire({
						title: "Error",
						text: "There was an error submitting your form.",
						type: "error"
					});
				}
			});


		}
	}


	$(document).on('show.bs.modal', '#scrolling_modal', function (e) {
		var link = $(e.relatedTarget);
		$(this).find(".modal-body").load(link.attr("href"));
		var title = link.attr("title");
		$("#ModalTitle1").text(title);
	});



	window.addEventListener('beforeunload', function (event) {
		show_loader();

	});

	if (page_name == 'loan_approval_stage') {
		$(document).on('change', '#loan_approval_stage_loan_type', function () {
			var loan_approval_stage_loan_type = $('#loan_approval_stage_loan_type').val();
			if (loan_approval_stage_loan_type != "") {
				show_loader();
				$.ajax({
					url: base_url + '/admin/get_loan_approval_stage/' + loan_approval_stage_loan_type,
					type: 'GET',
					dataType: 'json',
					success: function (response) {
						hide_loader();
						selOpts = "<option value=''>Select Approval Stage Level</option>";
						flag = 1;
						for (i = 1; i <= 10; i++) {
							$.each(response, function (k, v) {
								if (i == v) {
									flag = 0;
								}
							});
							if (flag == 0) {
								selOpts += "<option value='" + i + "' disabled>" + i + "</option>";
							}
							else {
								selOpts += "<option value='" + i + "'>" + i + "</option>";
							}
							flag = 1;
						}
						$('#loan_approval_stage_level').html(selOpts);
						hide_loader();
					},
					error: function (xhr, status, error) {
						hide_loader();
					}
				});
			}
			else {
				return "";
			}
		});
	}

	if (page_name == 'loan_type') {
		$(document).on('change', '#group_loan', function (e) {
			var group_loan = $(this).val();
			if (group_loan == 'yes') {
				$("#is_product_defined").val("yes").trigger('change');
				$("#is_product_defined").parent().css("pointer-events", "none");
			} else {
				$("#is_product_defined").val("").trigger('change');
				$("#is_product_defined").parent().css("pointer-events", "");
			}
		});
	}
	if (page_name == 'loan_collection') {

		$(document).on('keydown', '.read_only', function (e) {
			return false;
		});

		$(document).on('keyup', '.amount_validate', function (e) {
			var field_val = $(this).val();
			field_val = field_val.replace(/\D/g, '');
			$(this).val(field_val);
		});

		$(function () {
			$('#loan_collection').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"order": [[0, 'asc']],
				"ajax": {
					url: base_url + '/admin/loan_collection_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#loan_collection").html("");
						$("#loan_collection").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		function delete_collection(url) {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					Swal.fire(
						'Deleted!',
						'Data has been deleted.',
						'success'
					)
					show_loader();
					window.location.href = base_url + '/' + url;
				}

			});
		}

		$("#la_history_modal").on("show.bs.modal", function (e) {
			var link = $(e.relatedTarget);
			$(this).find(".modal-body").load(link.attr("href"));
			var title = link.attr("title");
			$("#myModalLabel").text(title);

		});

	}

	if (page_name == 'preclose_approval') {
		$(function () {
			$('#preclose_approval').DataTable({
				"bLengthChange": false,
				"pageLength": '100',
				"serverSide": true,
				"searching": false,
				"bSort": false,
				'processing': true,
				"scrollx": true,
				"order": [[4, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				"ajax": {
					url: base_url + '/admin/preclose_approval_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#preclose_approval").html("");
						$("#preclose_approval").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});
	}

	if (page_name == 'change_collection_date') {
		$(function () {
			$('#change_collection_date').DataTable({
				"bLengthChange": false,
				"pageLength": '1000000',
				"serverSide": true,
				"searching": false,
				"bSort": false,
				'processing': true,
				"scrollx": true,
				"order": [[4, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				"ajax": {
					url: base_url + '/admin/change_collection_date_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#change_collection_date").html("");
						$("#change_collection_date").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {

			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}


		function submit_form(form_id) {

			$('#' + form_id).submit();

		}
	}

	if (page_name == 'preclose') {
		$(function () {
			$('#preclose').DataTable({
				"bLengthChange": false,
				"pageLength": '100',
				"serverSide": true,
				"searching": false,
				"bSort": false,
				'processing': true,
				"scrollx": true,
				"order": [[4, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				"ajax": {
					url: base_url + '/admin/preclose_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#preclose").html("");
						$("#preclose").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {

			var id = $(this).data('id');
			if ($(this).is(':checked')) {
				$('select[data-id="' + id + '"]').prop('required', true);
			} else {
				$('select[data-id="' + id + '"]').prop('required', false).val('');
			}

			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}


		function submit_form(form_id) {
			var isValid = true;
			$('.checkbox:checked').each(function () {
				var id = $(this).data('id');
				var selectValue = $('select[data-id="' + id + '"]').val();
				if (selectValue === '') {
					isValid = false;
					$('select[data-id="' + id + '"]').addClass('is-invalid');
				} else {
					$('select[data-id="' + id + '"]').removeClass('is-invalid');
				}
			});

			if (!isValid) {
				hide_loader();
				alert('Please select a value from the dropdown for all checked checkboxes.');
				return false;
			} else {
				$('#' + form_id).submit();
			}

		}

		$(document).on('blur', '.preclose-limit', function (e) {
			var cur_val = $(this).val();
			var limit = $(this).attr('limit');
			if (parseInt(cur_val) < parseInt(limit)) {
				$(this).val(limit);
			}
		});

		$(document).on('keydown', '.read_only', function (e) {
			return false;
		});
	}

	if (page_name == 'collection_approval') {

		$(function () {
			$('#collection_approval').DataTable({
				"bLengthChange": false,
				"pageLength": '100',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"bSort": false,
				"order": [[0, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				"ajax": {
					url: base_url + '/admin/collection_approval_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#collection_approval").html("");
						$("#collection_approval").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {
			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}

		function submit_form(form_id) {
			$('#' + form_id).submit();
		}

	}

	if (page_name == 'disbursement_approval') {
		function submit_form(form_id) {
			$('#' + form_id).submit();
		}

		$(function () {
			$('#disbursement_approval').DataTable({
				"bLengthChange": false,
				"pageLength": '1000',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"bSort": false,
				"order": [[0, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'pdf',
						"text": 'PDF',
						"title": 'Disbursement Details',
						"action": newexportaction
					},

					{
						"extend": 'csv',
						"text": 'CSV',
						"title": 'Disbursement Details',
						"action": newexportaction
					},
				],
				"ajax": {
					url: base_url + '/admin/disbursement_approval_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#disbursement_approval").html("");
						$("#disbursement_approval").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {
			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}

		function submit_form(form_id) {
			$('#' + form_id).submit();
		}

	}

	if (page_name == 'death_claim') {


		Dropzone.autoDiscover = false;

		$(function () {
			//Dropzone class
			var myDropzone = new Dropzone(".dropzone", {
				paramName: "file",
				parallelUploads: 20,
				maxFilesize: 5,
				maxFiles: 20,
				uploadMultiple: true,
				acceptedFiles: "image/*",
				autoProcessQueue: false,
				addRemoveLinks: false,
			});


		});


		function submit_form(form_id) {
			var myDropzone = Dropzone.forElement(".dropzone");
			myDropzone.processQueue();
			myDropzone.on("complete", function (file) {
				if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

					window.location.reload();
				}
			});
		}

		function delete_attachment(dc_id, file_name) {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					show_loader();
					$.ajax({
						type: "GET",
						url: base_url + "/admin/delete_attachment?dc_id=" + btoa(dc_id) + "&file_name=" + btoa(file_name),
						success: function (data) {
							hide_loader();
							Swal.fire(
								'Deleted!',
								'Your file has been deleted.',
								'success'
							).then(function () {
								window.location.reload(true);

							});
						}

					});
				}
			});

		}


	}

	if (page_name == 'death_claim_action') {
		$(function () {
			$('#death_claim_action_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"bSort": false,
				//"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/death_claim_action_list',
					type: "post",
					data: filters,
					error: function () {  // error handling
						$("#death_claim_action_list").html("");
						$("#death_claim_action_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$("#la_history_modal").on("show.bs.modal", function (e) {
			var link = $(e.relatedTarget);
			$(this).find(".modal-body").load(link.attr("href"));
			var title = link.attr("title");
			$("#myModalLabel").text(title);

		});
	}

	if (page_name == 'miscellaneous_charge') {
		$(function () {
			$('#mc').DataTable({
				"bLengthChange": false,
				"pageLength": '100',
				"serverSide": true,
				"searching": false,
				"bSort": false,
				'processing': true,
				"scrollx": true,
				"order": [[4, 'asc']],
				"columnDefs": [{ "orderable": false, "targets": 0 }],
				drawCallback: function (settings) {
					$("select").select2({
						templateResult: formatState
					});

				},
				"ajax": {
					url: base_url + '/admin/miscellaneous_charge_list',
					type: "post",
					data: filters,

					error: function () {  // error handling
						$("#mc").html("");
						$("#mc").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		function formatState(state) {
			if (!state.id) {
				return state.text;
			}
			var $state
			if (state.element.attributes.type && atob(state.element.attributes.type.value) == "cash_inflow") {
				$state = $('<span style="color:green">' + state.text + '</span>');
			} else {
				$state = $('<span style="color:red">' + state.text + '</span>');
			}
			return $state;
		};

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {
			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}

		function submit_form(form_id) {
			$('#' + form_id).submit();
		}

		$(document).on('blur', '.preclose-limit', function (e) {
			var cur_val = $(this).val();
			var limit = $(this).attr('limit');
			if (parseInt(cur_val) < parseInt(limit)) {
				$(this).val(limit);
			}
		});

		$(document).on('keydown', '.read_only', function (e) {
			return false;
		});

		$(document).on('change', '.calculate_amount', function (e) {

			var ci_amount = 0;
			var co_amount = 0;

			var mc_type = $(this).find('option:selected').each(function () {
				var $type = atob($(this).attr('type'));
				var $amount = atob($(this).attr('amount'));
				if ($type == 'cash_inflow') {
					ci_amount += parseInt($amount);

				} else {
					co_amount += parseInt($amount);
				}
			});
			var tot_amount = parseInt(ci_amount) - parseInt(co_amount);
			$(this).closest('td').next('td').find('input.read_only').val(tot_amount);

		});
	}

	if (page_name == 'change_cs') {
		function submit_form(form_id) {
			if ($('#new_cs').val() == '') {
				alert("select collection staff");
			} else {
				$('#' + form_id).submit();
			}

		}

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {
			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}
	}

	if (page_name == 'transfer_customer') {
		function submit_form(form_id) {
			if ($('#new_center').val() == '') {
				alert("select center");
			} else {
				$('#' + form_id).submit();
			}

		}

		$(document).on('click', '#selectAll', function () {
			$('.checkbox').prop('checked', this.checked);
			updateCheckedCount();
		});

		$(document).on('change', '.checkbox', function () {
			if ($('.checkbox:checked').length == $('.checkbox').length) {
				$('#selectAll').prop('checked', true);
			} else {
				$('#selectAll').prop('checked', false);
			}
			updateCheckedCount();
		});
		function updateCheckedCount() {
			var count = $('.checkbox:checked').length;
			$('#checkedCount').text('Total Count - ' + count);
		}
	}

	if (page_name == 'office_transaction_action') {
		$(function () {
			$('#office_transaction_action_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": false,
				'processing': true,
				"scrollx": true,
				"bSort": false,
				//"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/office_transaction_action_list',
					type: "post",
					data: filters,
					error: function () {  // error handling
						$("#office_transaction_action_list").html("");
						$("#office_transaction_action_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		function ot_action(url) {
			show_loader();
			$.ajax({
				type: "GET",
				url: url,
				success: function (data) {
					window.location.reload(true);
				}

			});
		}


	}

	if (page_name == 'asset_return') {
		$(function () {
			$('#asset_return_list').DataTable({
				"bLengthChange": false,
				"pageLength": '20',
				"serverSide": true,
				"searching": true,
				'processing': true,
				"scrollx": true,
				"bSort": false,
				//"order": [[1, 'asc']],
				"ajax": {
					url: base_url + '/admin/asset_return_list',
					type: "post",
					data: filters,
					error: function () {  // error handling
						$("#asset_return_list").html("");
						$("#asset_return_list").append('<tbody class="employee-grid-error"><tr><th colspan="6" style="text-align:center">No data found in server</th></tr></tbody>');
					}

				}
			});
		});

		$(document).on('blur', '#asset_return_amount', function () {
			var limit = $(this).attr('asset_return_balance');
			var amount = $(this).val();

			if (parseInt(amount) > parseInt(limit)) {
				$('#asset_return_amount').val(limit);
			}
		});
	}

	if (page_group == 'dashboard') {
		$(document).on('change', '.filter_field', function (e) {
			$('.filter_form').submit();
		});

		$(document).on('blur', '.filter_date_field', function (e) {
			$('.filter_form').submit();
		});

	}

	if (page_group == 'report') {
		$(document).on('change', '.filter_field', function (e) {
			$('.filter_form').submit();
		});

		$(document).on('blur', '.filter_date_field', function (e) {

			$('.filter_form').submit();
		});

		if (page_name == 'customer_statement') {

			$(function () {
				var customer_name = $('#customer_filter').find("option:selected").text();
				$('#customer_name').text("Customer Name :" + customer_name);
				$('#customer_statement').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": true,
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": 'Customer Statement',
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": 'Customer Statement',
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/customer_statement_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#customer_statement").html("");
							$("#customer_statement").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}
		if (page_name == 'center_demand_report') {

			$(function () {
				$('#center_demand_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": true,
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": 'Center Demand report',
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": 'Center Demand report',
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/center_demand_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#center_demand_report").html("");
							$("#center_demand_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}
		if (page_name == 'customer_demand_report') {

			$(function () {
				$('#customer_demand_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": 'Customer Demand report',
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": 'Customer Demand report',
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/customer_demand_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#customer_demand_report").html("");
							$("#customer_demand_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}
		if (page_name == 'daily_collection_report') {

			$(function () {
				$('#daily_collection_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": 'Daily Collection report',
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": 'Daily Collection report',
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/daily_collection_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#daily_collection_report").html("");
							$("#daily_collection_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}
		if (page_name == 'fee_collection_report') {

			$(function () {
				$('#fee_collection_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/fee_collection_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#fee_collection_report").html("");
							$("#fee_collection_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}
		if (page_name == 'interest_collection_report') {

			$(function () {
				$('#interest_collection_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/interest_collection_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#interest_collection_report").html("");
							$("#interest_collection_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'branch_wise_portfolio') {
			$(function () {
				$('#branch_wise_portfolio').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/branch_wise_portfolio_list',
						type: "post",
						data: filters,
						error: function () {  // error handling
							$("#branch_wise_portfolio").html("");
							$("#branch_wise_portfolio").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'overdue_report') {

			$(function () {
				$('#overdue_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/overdue_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#overdue_report").html("");
							$("#overdue_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'office_transaction_report') {

			$(function () {
				$('#office_transaction_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/office_transaction_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#office_transaction_report").html("");
							$("#office_transaction_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}


		if (page_name == 'fund_transfer_report') {

			$(function () {
				$('#fund_transfer_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/fund_transfer_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#fund_transfer_report").html("");
							$("#fund_transfer_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'cash_in_hand_report') {

			$(function () {
				$('#cash_in_hand_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/cash_in_hand_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#cash_in_hand_report").html("");
							$("#cash_in_hand_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'preclose_report') {

			$(function () {
				$('#preclose_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/preclose_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#preclose_report").html("");
							$("#preclose_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}


		if (page_name == 'inactive_customer_report') {

			$(function () {
				$('#inactive_customer_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/inactive_customer_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#inactive_customer_report").html("");
							$("#inactive_customer_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'repayment_schedule_report') {

			$(function () {
				$('#repayment_schedule_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/repayment_schedule_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#repayment_schedule_report").html("");
							$("#repayment_schedule_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'eligible_customer_report') {

			$(function () {
				$('#eligible_customer_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/eligible_customer_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#eligible_customer_report").html("");
							$("#eligible_customer_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'daybook_report') {

			$(function () {
				$('#daybook_report').DataTable({
					"bLengthChange": false,
					"pageLength": '1000',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/daybook_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#daybook_report").html("");
							$("#daybook_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'balance_sheet_report') {

			$(function () {
				$('#balance_sheet_report').DataTable({
					"bLengthChange": false,
					"pageLength": '1000',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/balance_sheet_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#balance_sheet_report").html("");
							$("#balance_sheet_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'master_data') {

			$(function () {
				$('#master_data').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/master_data_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#master_data").html("");
							$("#master_data").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}

		if (page_name == 'loan_application_report') {
			$("#la_history_modal").on("show.bs.modal", function (e) {
				var link = $(e.relatedTarget);
				$(this).find(".modal-body").load(link.attr("href"));
				var title = link.attr("title");
				$("#myModalLabel").text(title);
			});

			$(function () {
				$('#loan_application_report').DataTable({
					"bLengthChange": false,
					"pageLength": '25',
					"serverSide": true,
					"searching": false,
					'processing': true,
					"scrollx": "100%",
					"bSort": false,
					"order": [[0, 'asc']],
					"columnDefs": [{ "orderable": false, "targets": 0 }],
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'pdf',
							"text": 'PDF',
							"title": page_name,
							"action": newexportaction
						},

						{
							"extend": 'csv',
							"text": 'CSV',
							"title": page_name,
							"action": newexportaction
						},
					],
					"ajax": {
						url: base_url + '/admin/loan_application_report_list',
						type: "post",
						data: filters,

						error: function () {  // error handling
							$("#loan_application_report").html("");
							$("#loan_application_report").append('<tbody class="employee-grid-error"><tr><th colspan="10" style="text-align:center">No data found in server</th></tr></tbody>');
						}

					}
				});
			});
		}
	}


	function newexportaction(e, dt, button, config) {
		var self = this;
		var oldStart = dt.settings()[0]._iDisplayStart;
		dt.one('preXhr', function (e, s, data) {
			// Just this once, load all data from the server...
			data.start = 0;
			data.length = 2147483647;
			dt.one('preDraw', function (e, settings) {
				// Call the original action function
				if (button[0].className.indexOf('buttons-copy') >= 0) {
					$.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-excel') >= 0) {
					$.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
						$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
						$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-csv') >= 0) {
					$.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
						$.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
						$.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-pdf') >= 0) {
					$.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
						$.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
						$.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-print') >= 0) {
					$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
				}
				dt.one('preXhr', function (e, s, data) {
					// DataTables thinks the first item displayed is index 0, but we're not drawing that.
					// Set the property to what it was before exporting.
					settings._iDisplayStart = oldStart;
					data.start = oldStart;
				});
				// Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
				//setTimeout(dt.ajax.reload, 0);
				// Prevent rendering of the full data to the DOM
				return false;
			});
		});
		// Requery the server with the new one-time export settings
		dt.ajax.reload();
	}

</script>