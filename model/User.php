<?php
session_start();

require_once 'DB.php';

class User
{
    private $db;
    private $userId;

    public function __construct($userId=null)
    {
		$this->db = new DB();
		$this->userId = $userId;
	}

    /**
     * Function will login the user
     *
     * @param array $requestData POST Data
     *
     * @return array
     */
    public function login($requestData)
    {
        $response = [];
        try {
            $user = $this->db->query(
                'SELECT * FROM user WHERE username = ? AND password = ?',
                $requestData['username'],
                md5($requestData['password'])
            )->fetchArray();

            if (empty($user)){
                $response = [
                    'success'=>false,
                    'message'=>'Invalid Username or Password',
                ];
            } else {
                $_SESSION['user'] = $user;
                $response = [
                    'success'=>true,
                    'message'=>'Login Successfully',
                ];
            }
        }catch(Execption $e){
            $response = [
                'success'=>true,
                'message'=>'Something Went Wrong!',
            ];
        }


        return $response;
    }

    /**
     * Function will register the user
     *
     * @param array $requestData POST Data
     *
     * @return array
     */
    public function register($requestData)
    {
        $response = [];
        try {
            $user = $this->db->query(
                'SELECT * FROM user WHERE username = ?',
                $requestData['username'],
            )->fetchArray();
            if (!empty($user)){
                $error['username'] = 'Username Already exists';
                $response = [
                    'success' => false,
                    'validationError' => $error,
                    'error' => true,
                ];
                return $response;
            }
            $insert = $this->db->query(
                'INSERT INTO user (username,first_name,last_name,password,email,dob) VALUES (?,?,?,?,?,?)',
                $requestData['username'],
                $requestData['first_name'],
                $requestData['last_name'],
                md5($requestData['password']),
                $requestData['email'],
                date('Y-m-d',strtotime($requestData['dob'])),
            );

            if ($insert->affectedRows() > 0){
                $imagePath = '';
                $path = '../assets/images/users/';
                $img = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                // get uploaded file's extension
                $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                // can upload same image using rand function
                $final_image = $this->userId.'.'.$ext;
                // check's valid format
                $path = $path.strtolower($final_image);
                if (move_uploaded_file($tmp,$path)) {
                    $imagePath = $path;
                }
                $query = 'UPDATE user SET ';
                if(! empty($imagePath)){
                    $query .= 'image = "'.$imagePath.'"';
                }
                $query .= ' WHERE id="'.$insert->lastInsertID().'"';
                $update = $this->db->query($query);
                $response = [
                    'success'=>true,
                    'message'=>'Registeration Successfully',
                ];
            }
        }catch(Execption $e){
            $response = [
                'success'=>false,
                'message'=>'Something Went Wrong!',
            ];
        }
        return $response;
    }
    /**
     * Function will update the user detail
     *
     * @param array $requestData POST Data
     *
     * @return array
     */
    public function update($requestData)
    {
        unset($requestData['action']);
        unset($requestData['confirm-password']);
        $response = [];
        try {
            $user = $this->db->query(
                'SELECT * FROM user WHERE username = ? AND id!=?',
                $requestData['username'],
                $this->userId,
            )->fetchArray();
            if (!empty($user)){
                $error['username'] = 'Username Already exists';
                $response = [
                    'success' => false,
                    'validationError' => $error,
                    'error' => true,
                ];
                return $response;
            }
            $imagePath = '';
            $path = '../assets/images/users/';
            $img = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            $final_image = $this->userId.'.'.$ext;
            // check's valid format
            $path = $path.strtolower($final_image);
            if (move_uploaded_file($tmp,$path)) {
                $imagePath = $path;
            }
            $updateTimestamp = false;
            $query = 'UPDATE user SET ';
            foreach($requestData as $key => $value){
                if ($key == 'password'){
                    if(! empty($value)){
                        $query .= $key.' = "'.md5($value).'",';
                        $updateTimestamp = true;
                    }
                }  else if($key == 'dob'){
                    $query .= $key.' = "'.date('Y-m-d',strtotime($value)).'",';
                } else{
                    $query .= $key.' = "'.$value.'",';
                }
            }
            if(! empty($imagePath)){
                $query .= 'image = "'.$imagePath.'",';
                $updateTimestamp = true;
            }
            if ($updateTimestamp){
                $query .= 'updated_at = "'.date('Y-m-d H:i:s').'",';
            }
            $query = rtrim($query,',');
            $query .= ' WHERE id="'.$this->userId.'"';
            $update = $this->db->query($query);

            if ($update->affectedRows() > 0){
                $response = [
                    'success'=>true,
                    'message'=>'Profile Updated Successfully',
                ];
            } else {
                $response = [
                    'success'=>false,
                    'warning'=>true,
                    'message'=>'Nothing to Update',
                ];
            }
        }catch(Execption $e){
            $response = [
                'success'=>false,
                'message'=>'Something Went Wrong!',
            ];
        }
        return $response;
    }

    /**
     * Function will logout the user
     *
     * @return bool
     */
    public function logout()
    {
        session_destroy();
        $response = [
            'success'=>true,
            'message'=>'Logout Successfully',
        ];
        return $response;
    }

    /**
     * Function will get the user details
     *
     * @return array
     */
    public function get()
    {
        $user = $this->db->query(
            'SELECT * FROM user WHERE id = ?',
            $this->userId,
        )->fetchArray();

        return $user;
    }

}
