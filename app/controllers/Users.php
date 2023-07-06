<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->serverKey  = 'secret_server_key'.date("H");
    }
    ////////////////////////// LOGIN//////
    public function loginfunc()
    {
        $jsonData = $this->getData();
         if (!isset($jsonData['email']) || !isset($jsonData['password'])) {
            $response = array(
              'status' => 'false',

              'message' => 'Enter login details',

            );

            print_r(json_encode($response));
            exit;
        }
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginData = $this->getData();
            $data = [
              'email' => trim($jsonData['email']),
              'password' => trim($jsonData['password']),
              'email_err' => '',
              'msg' => '',
              'loginStatus' => '',
              'password_err' => '',
            ];
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            if ((empty($data['email_err'])) && (empty($data['password_err']))) {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $postPassword = $data['password'];
                    $loginDatax = $this->userModel->loginUser($data['email'],$postPassword);
                    $email = $loginDatax->email;
                    $user_id = $loginDatax->user_id;
                        $tokenX = $token = "token" . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787));
                        $this->userModel->updateToken($user_id, $tokenX, $email);
                        $loginData = $this->userModel->findLoginByToken($tokenX);
                        $userData = $this->userModel->findUserByEmail_det($loginData->email);
                        $initData = [
                          'loginData' => $loginData,
                          'userData' => $userData,
                        ];
                        $datatoken = [
                          'user_id' => $user_id,
                          'email' => $email,
                          'appToken' => $initData['loginData']->bearer_token,

                        ];
                        $JWT_token = $this->getMyJsonID($datatoken, $this->serverKey);
                           $response = array(
                          'status' => 'true',
                          'access_token' => $JWT_token,
                          'datatoken' => $datatoken,
                          'message' => 'success',
                        //   'data' => $initData,

                        );


                        print_r(json_encode($response));


                    /////////////////end

                    } else {
                        // $data['msg'] = 'User access has Not Been activad, please contact or visit NIS secretariat !';


                        $response = array(
                          'status' => 'false',
                          'message' => 'Invalid password',

                        );

                        print_r(json_encode($response));
                        exit;
                    }



                ///////////////////////////////end

                } else {


                    $response = array(
                      'status' => 'false',

                      'message' => 'invalid user login detail',
                      'data' => $data,
                    );

                    print_r(json_encode($response));
                    exit;


                    //$data['msg'] = 'Invalid Login Access !';

                    redirect('users/login/1');
                }
       

        } else {

            $response = array(
              'status' => 'false',

              'message' => 'Invalid server method',

            );

            print_r(json_encode($response));
            exit;
        }

        ////end
    }
    //////LOGIN END////


    ////////GETSELLERPROFILE
    public function getSellerProfile()
    {
        try {
          $userData = $this->RouteProtecion();
      } catch (UnexpectedValueException $e) {
          $res = [
            'status' => 401,
            'message' =>  $e->getMessage(),
          ];
          print_r(json_encode($res));
          exit;
      } if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        print_r(json_encode($userData));
   
          }else {
            $response = [
              "status" => 400,
            'message' => 'invalid method',
          ];
          print_r(json_encode($response));
        exit;
         }
      // $userid = $userData->user_id ;
      // $tag = $userData->user_tag;
      
      // $this->reportModel->getTagname($userid, $tag);
    }
  
    public function register_userx()
    {
    
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $loginData = $this->getData();
        $data = [
          'full_name' => trim($loginData['fullname']),
          'email' => trim($loginData['email']),
        //   'phone_number' => trim($loginData['phone']),
          'user_id' => "",
          'password' => trim($loginData['password']),
          'confirm_password' => trim($loginData['confirm_password']),
          'full_name_err' => '',
          'email_err' => '',
        //   'phone_number_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'user_id_err' => '',
        ];
        if (empty($data['full_name'])) {
          $data['full_name_err'] = 'Please Enter Your fullname';
        }
        if (empty($data['email'])) {
          $data['email_err'] = 'Please enter email';
        } else {
          if ($this->userModel->findUserByEmail($data['email'])) {
            $data['email_err'] = 'Email is already taken';
          }
        }
        if (empty($data['password'])) {
          $data['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
        } 
        if (empty($data['confirm_password'])) {
          $data['confirm_password_err'] = 'Please confirm password';
        } else {
          if ($data['password'] != $data['confirm_password']) {
            $data['confirm_password_err'] = 'Passwords is not match';
          }
        }
        $data['user_id'] = $this->generateSecureUuid();
        if (empty($data['full_name_err']) && empty($data['user_id_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          if ($this->userModel->register_Veluxite($data)) {
            $response = [
              'status' => 200,
              'message' => 'registeration successful'
            ];
            print_r(($response));
          } else {
            $response = [
                'status'=>200,
              'message' => 'registration failed',
              'data' => $data
            ];
            print_r(json_encode($response));
          }
        } else {
         $response = [
              'status' => 'there is an error',
              'data' => $data
            ];
            print_r(json_encode($response));
        }
      } else {
        $data = [
          'firstName_err' => '',
          'middleName_err' => '',
          'lastName_err' => '',
          'email_err' => '',
          'phone_err' => '',
          'address_err' => '',
          'work_err' => '',
          'facebook_err' => '',
          'twitter_err' => '',
          'youtube_err' => '',
          'profilePhoto_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];
        $response = [
            "status" => 400,
          'message' => 'invalid method',
        ];
        print_r(json_encode($response));
      }
    }
    public function profileUpdate()
    {
     try {
        $userData = $this->RouteProtecion();
        } catch (UnexpectedValueException $e) {
            $res = [
              'status' => 401,
              'message' =>  $e->getMessage(),
            ];
            print_r(json_encode($res));
            exit;
        }
        $userid = $userData->user_id ;
        $token = $userData->bearer_token;
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $loginData = $this->getData();
        $data = [
          'full_name' => trim($loginData['fullname']),
          'email' => trim($loginData['email']),
        //   'phone_number' => trim($loginData['phone']),
          'user_id' => $userid,
          'password' => trim($loginData['password']),
          'confirm_password' => trim($loginData['confirm_password']),
          'full_name_err' => '',
          'email_err' => '',
        //   'phone_number_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'user_id_err' => '',
        ];
        if (empty($data['full_name'])) {
          $data['full_name_err'] = 'Please Enter Your fullname';
        }
        if (empty($data['email'])) {
          $data['email_err'] = 'Please enter email';
        } else {
          if ($this->userModel->findUserByEmail($data['email'])) {
            $data['email_err'] = 'Email is already taken';
          }
        }
        if (empty($data['password'])) {
          $data['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
        } 
        if (empty($data['confirm_password'])) {
          $data['confirm_password_err'] = 'Please confirm password';
        } else {
          if ($data['password'] != $data['confirm_password']) {
            $data['confirm_password_err'] = 'Passwords is not match';
          }
        }
        // $data['user_id'] = $this->generateSecureUuid();
        if (empty($data['full_name_err']) && empty($data['user_id_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
          if ($this->userModel->profileUpdate($data, $token)) {
            $response = [
              'status' => 200,
              'message' => 'profile update successful'
            ];
            print_r(json_encode($response));
          } else {
            $response = [
                'status'=>200,
              'message' => 'profile update failed',
              'data' => $data
            ];
            print_r(json_encode($response));
          }
        } else {
         $response = [
              'status' => 'there is an error',
              'data' => $data
            ];
            print_r(json_encode($response));
        }
      } else {
        $data = [
          'firstName_err' => '',
          'middleName_err' => '',
          'lastName_err' => '',
          'email_err' => '',
          'phone_err' => '',
          'address_err' => '',
          'work_err' => '',
          'facebook_err' => '',
          'twitter_err' => '',
          'youtube_err' => '',
          'profilePhoto_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];
        $response = [
            "status" => 400,
          'message' => 'invalid method',
        ];
        print_r(json_encode($response));
      }
    }
   
}
