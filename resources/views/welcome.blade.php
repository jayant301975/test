@extends('layout.app')
@section('title','Contact List')
@section('content')
@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

@endpush


<div class="container">
   @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <div class="card mt-5">
        <div class="card-header p-3 d-flex justify-content-between align-items-center">
         <h3 class="mb-0">List Of Contacts</h3>
		 <div class="ms-auto">
			<a href="javscript:void(0);" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Import XML</a>
			<a href="javascript:void(0);" class="btn btn-success btn-sm" data-bs-toggle="modal"  data-bs-target=".bs-example-add-center">Add Contact</a>
		</div>
		</div>
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
						<th width="50px;">Country Code</th>
                        <th width="200px;">Phone</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


 <div class="modal fade bs-example-modal-center" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center p-5">
					<div id="error-file" class="alert alert-danger d-none"></div>
					<div class="mt-4">
					<form id="uploadXmlForm" action="javascript:void(0)"  enctype="multipart/form-data">
					@csrf
						<h4 class="mb-3">Upload XML File Here For Import</h4>
						 <input type="file" class="form-control" name="file" id="xmlFile" />
						 <span class="text-danger error-text file_error"></span>
						 </br>
						<div class="hstack gap-2 justify-content-center">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" >Upload</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

 <!-- Bootstrap Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Contact</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			     <div id="error-messages" class="alert alert-danger d-none"></div>
                <form id="editForm" action="javascript:void(0)">
				   @csrf
                    <input type="hidden" id="contact_id" name="id">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="contact_name">
						<span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Country Code</label>
                        <input type="text" class="form-control" name="country_code" id="contact_country_code">
						<span class="text-danger error-text country_code_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="contact_mobile">
						<span class="text-danger error-text mobile_error"></span>
                    </div>
					<div class="form-group mt-3">
                    <button type="submit" class="btn btn-success" id="updateChanges">Save Changes</button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-add-center" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Contact</h5>
               <button type="button" class="close_add" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			     <div id="error-message" class="alert alert-danger d-none"></div>
                <form   id="addForm" >
				   @csrf
                    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="contact_name_add">
						<span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label>Country Code</label>
                        <input type="text" class="form-control" name="country_code" id="contact_country_code_add">
						<span class="text-danger error-text country_code_error"></span>
					</div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="contact_mobile_add">
						<span class="text-danger error-text mobile_error"></span>
                    </div>
					<div class="form-group mt-3">
                    <button type="submit" class="btn btn-success" >Save Data</button>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   
    $(".data-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('load') }}",
            type: "GET", 
            dataType: "json",
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'country_code', name: 'country_code' },
            { data: 'mobile', name: 'mobile' },
            { data: 'action', name: 'action', orderable: true, searchable: true },
        ],
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        pageLength: 50, 
        error: function(xhr, error, thrown) {
            console.log("DataTables error:", error, thrown);
        }
    });
});
$(document).ready(function () {
    
    $(document).on("click", ".bs-upload-edit", function () {
        var contactId = $(this).data("id");
        $.ajax({
            url: "/upload-data/" + contactId, 
            type: "GET",
            success: function (response) {
				
                if (response.success) {
                    $("#contact_id").val(response.data.id);
                    $("#contact_name").val(response.data.name);
                    $("#contact_country_code").val(response.data.country_code);
                    $("#contact_mobile").val(response.data.mobile);

                    // Open the modal
                    $("#editModal").modal("show");
                }
            },
            error: function () {
                alert("Failed to load data");
            }
        }); 
    });
	 $(document).on("click", ".close", function () {
		$("#editModal").modal("hide");
	});	
	$(document).on("click", ".close_add", function () {
		$("#addModal").modal("hide");
	});
	$("#editForm").on("submit", function (e) {
		e.preventDefault();
		 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
		
        var contactId = $("#contact_id").val(); 
		 var formData = {
       
        name: $("#contact_name").val(),
        country_code: $("#contact_country_code").val(),
        mobile: $("#contact_mobile").val()
		};
        console.log(formData);
        
        $.ajax({
            url: "/update-contact/" + contactId,
            type: "Post",
            data: formData,
            success: function (response) {
				if (response.status === "success") {
                alert(response.message);
                $("#editModal").modal("hide");
                location.reload();
            } else {
                alert("Update failed: " + response.message);
            } 
            },
            error: function (xhr) {
                $(".error-text").text(""); 
				$("input").removeClass("is-invalid"); 

				let errors = xhr.responseJSON.errors;
				$.each(errors, function (key, value) {
					$("#" + key).addClass("is-invalid"); 
					$("." + key + "_error").text(value[0]); 
				});
            }
        });
    });
	
	$(document).on("click", ".delete", function (e) {
		e.preventDefault();

		var contactId = $(this).data("id");

		if (confirm("Are you sure you want to delete this contact?")) {
			$.ajax({
				url: "/update-delete/" + contactId,
				type: "DELETE",
				data: { _token: "{{ csrf_token() }}" },
				success: function (response) {
					alert("Contact deleted successfully!");
					location.reload();
				},
				error: function (xhr) {
					alert("Failed to delete contact!");
				}
			});
		}
	});
    $("#addForm").on("submit", function (e) {
		e.preventDefault();
		 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
		
        
		 var formData = {
       
        name: $("#contact_name_add").val(),
        country_code: $("#contact_country_code_add").val(),
        mobile: $("#contact_mobile_add").val()
		};
       
        
        $.ajax({
            url: "/add-contact",
            type: "Post",
            data: formData,
            success: function (response)
			{
				if (response.status === "success") {
                alert(response.message);
                $("#addModal").modal("hide");
                location.reload();
            } 
			else 
			{
                alert("Add failed: " + response.message);
            } 
            },
            error: function (xhr) {
                $(".error-text").text(""); 
				$("input").removeClass("is-invalid"); 

				let errors = xhr.responseJSON.errors;
				$.each(errors, function (key, value) {
					$("#" + key).addClass("is-invalid"); 
					$("." + key + "_error").text(value[0]); 
				});
            }
        });
    });
	$(document).on("submit", "#uploadXmlForm", function (e) {
			e.preventDefault();
			
			let formData = new FormData(this); 
			$.ajax({
				url: "{{ route('upload') }}", 
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					alert("File uploaded successfully!");
					$("#uploadXmlForm")[0].reset(); 
					$(".error-text").text(""); 
					$("#uploadModal").modal("hide");
					setTimeout(function () {
						$(".modal-backdrop").remove();
						$("body").removeClass("modal-open").css("overflow", "auto");
					}, 500);
					location.reload();
				},
				error: function (xhr) {
					$(".error-text").text(""); 
					$("input").removeClass("is-invalid"); 
					
					if (xhr.responseJSON.errors) {
						let errors = xhr.responseJSON.errors;
						$.each(errors, function (key, value) {
							$("." + key + "_error").text(value[0]); 
							$("#" + key).addClass("is-invalid"); 
						});
					}
				},
			});
		});
	
});	
</script>



@endpush
