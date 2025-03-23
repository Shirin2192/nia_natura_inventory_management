<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Nia Natura Inventory Management</title>
      <!-- Favicon icon -->
      <?php include('common/css_files.php')?>
   </head>
   <body>
      <!--*******************
         Preloader start
         ********************-->
      <div id="preloader">
         <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
               <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
         </div>
      </div>
      <!--*******************
         Preloader end
         ********************-->
      <!--**********************************
         Main wrapper start
         ***********************************-->
      <div id="main-wrapper">
         <!--**********************************
            Nav header start
            ***********************************-->
         <?php include('common/nav_head.php')?>
         <!--**********************************
            Nav header end
            ***********************************-->
         <!--**********************************
            Header start
            ***********************************-->
         <?php include('common/header.php')?>
         <!--**********************************
            Header end ti-comment-alt
            ***********************************-->
         <!--**********************************
            Sidebar start
            ***********************************-->
         <?php include('common/sidebar.php')?>
         <!--**********************************
            Sidebar end
            ***********************************-->
         <!--**********************************
            Content body start
            ***********************************-->
         <div class="content-body">
            <div class="row page-titles mx-0">
               <div class="col p-md-0">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="<?=base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item active"><a href="<?=base_url()?>admin/add_order_details">Add Order Detail</a></li>
                  </ol>
               </div>
            </div>
            <!-- row -->
            <div class="container-fluid">
               <div class="row justify-content-center">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-body">
                           <form>
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <label class="col-form-label" for="flavour_name">Flavour Name <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" id="flavour_name" name="flavour_name">
                                        <option value="Neem">Neem</option>
                                        <option value="Tulsi">Tulsi</option>
                                        <option value="Himalaya">Himalaya</option>
                                        <option value="Jamun">Jamun</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <label class="col-form-label" for="flavour_name">Flavour Name <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" id="flavour_name" name="flavour_name">
                                        <option value="Neem">Neem</option>
                                        <option value="Tulsi">Tulsi</option>
                                        <option value="Himalaya">Himalaya</option>
                                        <option value="Jamun">Jamun</option>
                                    </select>
                                 </div>
                              </div>
                              
                           </div>
                           <div class="form-group">
                              <div class="col-lg-8 ml-auto">
                                 <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                           </div>
                           </form>
                            <!-- Row for DataTable -->
         <div class="container-fluid">
            <div class="row justify-content-center">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5>Flavour List</h5>
                        <table id="flavourTable" class="display">
                           <thead>
                              <tr>
                                 <th>Flavour Name</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <!-- Example Row -->
                              <tr>
                                 <td>John</td>
                                 <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal" data-target="#edit_flavour_modal" data-id="1">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="1">Delete</button>
                                 </td>
                              </tr>
                              <!-- More rows will be dynamically generated -->
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
                        </div>
                     </div>
                  </div>
                  
                   
               </div>
            </div>
         </div>
      </div>
      <!-- #/ container -->
      </div>
      <!--**********************************
         Content body end
         ***********************************-->
         <!-- Edit Product Modal -->
      <div class="modal fade" id="edit_flavour_modal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form id="edit-product-form">
                     <div class="row">
                        <div class="col-lg-6 mb-3">
                           <div class="form-group">
                              <label class="col-form-label" for="edit_flavour_name">Flavour Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="edit_flavour_name" name="edit_flavour_name" placeholder="Enter Product Name">
                           </div>
                        </div>                      
                     </div>                                       
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" form="edit-product-form" class="btn btn-primary">Save Changes</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  Are you sure you want to delete this product?
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
               </div>
            </div>
         </div>
      </div>
      <!--**********************************
         Footer start
         ***********************************-->
      <div class="footer">
         <div class="copyright">
            <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
         </div>
      </div>
      <!--**********************************
         Footer end
         ***********************************-->
      </div>
      <!--**********************************
         Main wrapper end
         ***********************************-->
      <!--**********************************
         Scripts
         ***********************************-->
      <?php include('common/js_files.php')?>
      <script>
      $(document).ready(function() {
         $('#flavourTable').DataTable();

         // Edit button click event
         $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            // Populate the edit modal fields using AJAX or dummy data
            $('#edit_flavour_name').val('Neem');
           
         });

         // Delete button click event
         $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#confirmDelete').on('click', function() {
               // Call delete API or perform delete action
               console.log('Deleting staff with ID: ' + id);
               // Close modal
               $('#deleteModal').modal('hide');
            });
         });
      });
   </script>
   </body>
</html>
