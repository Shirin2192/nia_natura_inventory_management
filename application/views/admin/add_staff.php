<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
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
                     <li class="breadcrumb-item active"><a href="<?=base_url()?>admin/add_staff">Add Staff</a></li>
                  </ol>
               </div>
            </div>
            <!-- row -->
            <div class="container-fluid">
               <div class="row justify-content-center">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="col-form-label" for="first_name">First Name <span class="text-danger">*</span>
                                       </label>
                                       <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="col-form-label" for="last_name">Last Name <span class="text-danger">*</span>
                                       </label>
                                       <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="col-form-label" for="email">Email <span class="text-danger">*</span>
                                       </label>
                                       <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="col-form-label" for="password">Password <span class="text-danger">*</span>
                                       </label>
                                       <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    </div>
                                 </div>
                                 <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                                </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                           <div class="form-group">
                              <label class="col-form-label" for="profile_picture">Profile Picture</label>
                              <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                           </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                           <div class="form-group">
                              <label class="col-form-label" for="role">Role/Designation <span class="text-danger">*</span></label>
                              <!-- <input type="text" class="form-control" id="role" name="role" placeholder="Enter Role/Designation"> -->
                              <select class="form-control choosen" id="val-skill" name="val-skill">
                                <option value="">Please select</option>
                                <option value="html">HTML</option>
                                <option value="css">CSS</option>
                                <option value="javascript">JavaScript</option>
                                <option value="angular">Angular</option>
                                <option value="angular">React</option>
                                <option value="vuejs">Vue.js</option>
                                <option value="ruby">Ruby</option>
                                <option value="php">PHP</option>
                                <option value="asp">ASP.NET</option>
                                <option value="python">Python</option>
                                <option value="mysql">MySQL</option>
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
   </body>
</html>