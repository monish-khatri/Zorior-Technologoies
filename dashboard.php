<?php
session_start();
if (!isset($_SESSION['user'])){
    header('Location: index.php');
}
$userId = $_SESSION['user']['id'];

include_once 'model/User.php';
$user = new User($userId);
$userDetail = $user->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zorior Technologies</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.css"
    rel="stylesheet"
    />
    <!-- MDB -->
    <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.js"
    ></script>
    <script
    type="text/javascript"
    src="assets/js/index.js"
    ></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
  	$(function() {
      $( "#dob" ).datepicker({
        setDate:'<?=$userDetail['dob']?>',
        dateFormat: 'dd/mm/yy'
      });
	})
	</script>
  <style>
    .error{
        color: red;
    }
  </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Profile</a>
        </li>
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

    <!-- Right elements -->
    <div class="d-flex align-items-center">
      <!-- Avatar -->
      <div class="dropdown">
        <!-- Avatar -->
        <div class="dropdown">
          <a class="btn btn-danger" id="logout-user">Logout</a>
        </div>
      </div>
    </div>
    <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
</nav>

<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="container-xl">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <form class="form-horizontal" id="update-form" method="post" enctype="multipart/form-data">
              <input type="hidden" name="action" value="update">
                  <div class="panel panel-default">
                    <div class="panel-body text-center">
                      <img src="<?= ltrim($userDetail['image'],'../')?>" class="img-circle profile-avatar" alt="User avatar">
                    </div>
                  </div>
                  <hr>
                <div class="panel panel-default">
                  <div class="panel-heading">
                  <h4 class="panel-title">User info:</h4>
                  </div>
                  <div class="panel-body">
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Username:</label>
                          <div class="col-sm-12">
                              <input type="text" name="username" id="username" class="form-control username" value="<?= $userDetail['username']?>">
                              <span class="error d-none"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label">First Name:</label>
                          <div class="col-sm-12">
                              <input type="text" name="first_name" id="first_name" class="form-control first_name" value="<?= $userDetail['first_name']?>">
                              <span class="error d-none"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Last Name:</label>
                          <div class="col-sm-12">
                              <input type="text" name="last_name" id="last_name" class="form-control last_name" value="<?= $userDetail['last_name']?>">
                              <span class="error d-none"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Date Of Birth:</label>
                          <div class="col-sm-12">
                              <input type="text" name="dob" id="dob" class="form-control dob" value="<?= $userDetail['dob']?>">
                              <span class="error d-none"></span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Profile Image:</label>
                          <div class="col-sm-12">
                              <input type="file" name="image" id="image" class="form-control image" value="">
                              <span class="error d-none"></span>
                          </div>
                      </div>
                      <div class="form-group">
                        <?php  $genderArray = ['male','female','other'];?>
                        <label class="col-sm-2 control-label">Gender:</label>
        								<select name="gender" id="gender" name="gender" class="form-control gender">
                            <option value="">Gender</option>
                            <?php for($i=0;$i<count($genderArray);$i++){?>
                              <option value="<?= $genderArray[$i]?>" <?=($genderArray[$i] == $userDetail['gender'])?'selected':''?>><?= ucfirst($genderArray[$i])?></option>
                            <?php }
                            ?>
											</select>
										  <span class="error d-none"></span>
									</div>
                  </div>
                </div>
                <hr>
                <div class="panel panel-default">
                  <div class="panel-heading">
                  <h4 class="panel-title">Contact info:</h4>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-12">
                            <input type="text" name="email" id="email" class="form-control email" value="<?= $userDetail['email']?>">
                            <span class="error d-none"></span>
                        </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="panel panel-default">
                  <div class="panel-heading">
                  <h4 class="panel-title">Security:</h4>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">New password:</label>
                      <div class="col-sm-12">
                        <input type="password" name="password" id="password" class="password form-control">
                        <span class="error d-none"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Confirm password:</label>
                      <div class="col-sm-12">
                        <input type="password" name="confirm-password" id="confirm-password" class="confirm-password form-control">
                        <span class="error d-none"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12 col-sm-offset-2">
                          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                          <input type="button" id="update-submit" class="btn btn-success" value="Update">
                      </div>
                    </div>
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
</body>
</html>