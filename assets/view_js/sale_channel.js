$(".chosen-select").chosen({
	allow_single_deselect: true,
	heigth: "100%",
});
$(document).ready(function () {
	loadSaleChannel();
	let currentPermission = null;
	// Load DataTable
	function loadSaleChannel() {
		$.ajax({
			url: frontend + controllerName + "/fetch_sale_channel",
			type: "POST",
			dataType: "json",
			success: function (data) {
				const permissions = data.data.permissions;
				const currentSidebarId = data.data.current_sidebar_id;
				currentPermission = permissions[currentSidebarId];

				if ($.fn.DataTable.isDataTable("#SalechannelTable")) {
					$("#SalechannelTable").DataTable().destroy(); // Destroy previous instance
				}
				$("#SalechannelTable").DataTable({
					dom: "Bfrtip", // B = Buttons, f = filter, r = process info, t = table, i = info, p = paginate
					buttons: ["csv", "excel"],
					responsive: true,
					destroy: true,
					data: data.response, // Provide data directly
					columns: [
						{
							data: null,
							title: "Sr. No",
							orderable: false,
							searchable: false,
							render: function (data, type, row, meta) {
								return meta.row + 1;
							},
						},
						{
							data: "channel_type",
							title: "Channel Type",
						},
						{
							data: "sale_channel",
							title: "Sale Channel",
						},
						{
							data: "id",
							title: "Action",
							orderable: false,
							searchable: false,
							render: function (data) {
								let actions = "";
								if (currentPermission) {
									if (currentPermission.can_view === "1") {
										actions += `<button class="btn btn-info btn-sm view-sale-channel me-1" data-id="${data}" data-target="#sale_channelModal">
                                                        <i class="icon-eye menu-icon"></i>
                                                    </button>`;
									}
									if (currentPermission.can_edit === "1") {
										actions += `<button class="btn btn-warning btn-sm edit-sale-channel me-1" data-id="${data}" data-target="#edit_sale_channel_modal">
                                                        <i class="icon-pencil menu-icon"></i>
                                                    </button>`;
									}
									if (currentPermission.can_delete === "1") {
										actions += `<button class="btn btn-danger btn-sm" onclick="deleteSaleChannel(${data})">
                                                        <i class="icon-trash menu-icon"></i>
                                                    </button>`;
									}
								}
								return actions || "-";
							},
						},
					],
					language: {
						emptyTable: "No Sale Channels found",
					},
				});
			},
			error: function () {
				console.error("Error fetching Sale Channels.");
			},
		});
	}
	$("#SaleChannelForm").on("submit", function (event) {
		event.preventDefault(); // Prevent page reload
		$.ajax({
			url: frontend + controllerName + "/save_sale_channel",
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (response) {
				if (response.status === "error") {
					$("#sale_channel_error").html(response.sale_channel_error);
				} else {
					swal({
						icon: "success",
						title: "Added!",
						text: response.message,
						button: false,
						timer: 2000,
					});
					$("#SaleChannelForm")[0].reset();
					$("#sale_channel_error").text("");
					setTimeout(() => {
						loadSaleChannel();
					}, 500);
				}
			},
		});
	});
});

$(document).on("click", ".view-sale-channel", function () {
	var channelId = $(this).data("id");
	$.ajax({
		url: frontend + controllerName + "/get_sale_channel_details",
		type: "POST",
		data: { id: channelId },
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				var modalContent = `
                    <p><strong>Channel Type:</strong> ${response.sale_channel.channel_type}</p>
                    <p><strong>Sale Channel:</strong> ${response.sale_channel.sale_channel}</p>
                `;
				$("#sale_channelContent").html(modalContent);
				$("#sale_channelModal").modal("show");
			} else {
				alert("Error: Unable to fetch sale channel details.");
			}
		},
		error: function () {
			alert("Error: Could not retrieve data.");
		},
	});
});

$(document).on("click", ".edit-sale-channel", function () {
	var channelId = $(this).data("id");
	$.ajax({
		url: frontend + controllerName + "/get_sale_channel_details",
		type: "POST",
		data: { id: channelId },
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				$("#edit_sale_channel_id").val(response.sale_channel.id);
				$("#edit_sale_channel").val(response.sale_channel.sale_channel);
				$("#edit_channel_type").val(response.sale_channel.channel_type);
				$("#edit_sale_channel_modal").modal("show");
			} else {
				alert("Error: Unable to fetch details.");
			}
		},
		error: function () {
			alert("Error: Could not retrieve data.");
		},
	});
});

$("#edit_sale_channel_form").on("submit", function (event) {
	event.preventDefault();
	$.ajax({
		url: frontend + controllerName + "/update_sale_channel",
		type: "POST",
		data: $(this).serialize(),
		dataType: "json",
		success: function (response) {
			if (response.status === "error") {
				$("#edit_sale_channel_error").html(response.sale_channel_error);
			} else {
				swal({
					icon: "success",
					title: "Updated!",
					text: response.message,
					button: false,
					timer: 2000,
				});
				$("#edit_sale_channel_modal").modal("hide");
				$("#edit_sale_channel_form")[0].reset();
				location.reload();
			}
		},
		error: function () {
			console.error("Error updating Bottle Size.");
		},
	});
});
function deleteSaleChannel(id) {
	swal({
		title: "Are you sure?",
		text: "Once deleted, you will not be able to recover this Sale Channel!",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url: frontend + controllerName + "/delete_sale_channel",
				type: "POST",
				data: { id: id },
				dataType: "json",
				success: function (response) {
					if (response.status === "success") {
						swal("Deleted!", response.message, "success");
						location.reload();
					} else {
						swal("Error!", response.message, "error");
					}
				},
				error: function () {
					swal("Error!", "Something went wrong.", "error");
				},
			});
		}
	});
}
