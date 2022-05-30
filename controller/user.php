<?php
session_start();
$userId = $_SESSION['user']['id'];
require_once '../model/User.php';
$action = $_POST['action'];
switch ($action) {
    case 'login':
        $user = new User();
        $data = $_POST;
        if(empty($data['username']) || empty($data['password']))
        {
            $error = [];
            if(empty($data['username'])){
                $error['username'] = 'Username is Required.';
            }
            if(empty($data['password'])){
                $error['password'] = 'Password is Required.';
            }
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
            break;
        }

        $response = $user->login($data);
        break;
    case 'register':
        $user = new User();
        $data = $_POST;
        $genderArray = ['male','female','other'];
        $username = trim($data['username']);
        $firstName = trim($data['first_name']);
        $lastName = trim($data['last_name']);
        $email = trim($data['email']);
        $dob = trim($data['dob']);
        $gender = trim($data['gender']);
        $password = trim($data['password']);
        $image = $_FILES['image'];
        $confirmPassword = trim($data['confirm-password']);
        $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
        if(
            empty($username)
            || empty($password)
            || empty($firstName)
            || empty($lastName)
            || empty($confirmPassword)
            || empty($email)
            || empty($dob)
            || empty($gender)
            || ($image['size']<=0)
        )
        {
            $error = [];
            if($image['size']<=0) {
                $error['image'] = 'Please Upload image.';
            }
            if(empty($username)){
                $error['username'] = 'Username is Required.';
            }
            if(empty($firstName)){
                $error['first_name'] = 'First name is Required.';
            }
            if(empty($lastName)){
                $error['last_name'] = 'Last name is Required.';
            }
            if(empty($email)){
                $error['email'] = 'Email Address is Required.';
            }
            if(empty($dob)){
                $error['dob'] = 'Date of Birth is Required.';
            }
            if(empty($password)){
                $error['password'] = 'Password is Required.';
            }
            if(empty($confirmPassword)){
                $error['confirm-password'] = 'Confirm Password is Required.';
            }
            if(empty($gender)){
                $error['gender'] = 'Select Gender';
            }
        }
        if($image['size']>0) {
            $img = $image['name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            // check's valid format
            if(! in_array($ext, $valid_extensions)){
                $error['image'] = 'Invalid File Type.Please upload jpeg/jpg/png file';
            }
        }
        if(! empty($gender) && ! in_array($gender,$genderArray)){
            $error['gender'] = 'Invalid Selection';
        }
        if(! empty($password) && !empty($confirmPassword)){
            if ($password != $confirmPassword){
                $error['confirm-password'] = 'Confirm Password not match.';
            }
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Invalid email address";
          }
        if(!empty($error)){
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
            break;
        }

        $response = $user->register($data);
        break;
    case 'logout':
        $user = new User();
        $response = $user->logout();
        break;
    case 'update':
        $user = new User($userId);
        $data = $_POST;
        $genderArray = ['male','female','other'];
        $username = trim($data['username']);
        $firstName = trim($data['first_name']);
        $lastName = trim($data['last_name']);
        $email = trim($data['email']);
        $dob = trim($data['dob']);
        $gender = trim($data['gender']);
        $image = $_FILES['image'];
        $password = trim($data['password']);
        $confirmPassword = trim($data['confirm-password']);
        $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
        if(
            empty($username)
            || empty($firstName)
            || empty($lastName)
            || empty($email)
            || empty($dob)
            || empty($gender)
        )
        {
            $error = [];
            if(empty($username)){
                $error['username'] = 'Username is Required.';
            }
            if(empty($firstName)){
                $error['first_name'] = 'First name is Required.';
            }
            if(empty($lastName)){
                $error['last_name'] = 'Last name is Required.';
            }
            if(empty($email)){
                $error['email'] = 'Email Address is Required.';
            }
            if(empty($dob)){
                $error['dob'] = 'Date of Birth is Required.';
            }
            if(empty($gender)){
                $error['gender'] = 'Select Gender';
            }
        }
        if($image['size']>0) {
            $img = $image['name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            // check's valid format
            if(! in_array($ext, $valid_extensions)){
                $error['image'] = 'Invalid File Type.Please upload jpeg/jpg/png file';
            }
        }
        if(! empty($password) || !empty($confirmPassword)){
            if(empty($password)){
                $error['password'] = 'Password is Required.';
            }
            if(empty($confirmPassword)){
                $error['confirm-password'] = 'Confirm Password is Required.';
            }
        }
        if(! empty($gender) && ! in_array($gender,$genderArray)){
            $error['gender'] = 'Invalid Selection';
        }
        if(!empty($password) && !empty($confirmPassword)){
            if ($password != $confirmPassword){
                $error['confirm-password'] = 'Confirm Password not match.';
            }
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Invalid email address";
            }
        if(!empty($error)){
            $response = [
                'success' => false,
                'validationError' => $error,
                'error' => true,
            ];
            break;
        }

        $response = $user->update($data);
        break;
    default:
        $response = [
            'success' => false,
            'message' => 'Invalid Request'
        ];
}

echo json_encode($response);
    ?>