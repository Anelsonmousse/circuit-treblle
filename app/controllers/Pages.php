<?php

use Controller;

  class Pages extends Controller{
    public function __construct(){
      $this->serverKey  = 'secret_server_key'.date("H");
      $this->userModel = $this->model('User');
    }

    public function addProduct()
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
        $email = $userData->email;
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginData = $this->getData();
            $data = [
              'productname' => trim($loginData['productname']),
              'price' => trim($loginData['price']),
              'owner_id' => $userid,
              'owner_email' => $email,
              'productname_err' => '',
              'price_err' => '',
              'owner_email_err' => '',
              'owner_id_err' => '',
              'user_id_err' => '',
            ];
      
        if (empty($data['productname'])) {
          $data['productname_err'] = 'Please Enter Your productname';
        }
        if (empty($data['price'])) {
          $data['price_err'] = 'Please enter price';
         }
        $data['product_id'] = $this->generateSecureUuid();
        if (empty($data['productname_err']) && empty($data['price_err'])) {
         
          if ($this->userModel->addproductx($data)) {
            $response = [
              'status' => 200,
              'message' => 'product uploaded successfully'
            ];
            print_r(json_encode($response));
          } else {
            $response = [
                'status'=>200,
              'message' => 'product upload failed',
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
    public function editProduct()
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
        $email = $userData->email;
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loginData = $this->getData();
            $data = [
              'productname' => trim($loginData['productname']),
              'price' => trim($loginData['price']),
              'owner_id' => $userid,
              'owner_email' => $email,
              'productname_err' => '',
              'price_err' => '',
              'owner_email_err' => '',
              'owner_id_err' => '',
              'user_id_err' => '',
            ];
      
        if (empty($data['productname'])) {
          $data['productname_err'] = 'Please Enter Your productname';
        }
        if (empty($data['price'])) {
          $data['price_err'] = 'Please enter price';
         }
        $data['product_id'] = trim($loginData['product_id']);
        if (empty($data['productname_err']) && empty($data['price_err'])) {
         
          if ($this->userModel->updateproductx($data)) {
            $response = [
              'status' => 200,
              'message' => 'product updated successfully'
            ];
            print_r(json_encode($response));
          } else {
            $response = [
                'status'=>200,
              'message' => 'product update failed',
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
    public function getProducts()
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
          if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
       
            $userid = $userData->user_id ;
            $email = $userData->email;
            
            $this->userModel->getproductx($userid, $email);
       
      }else {
        $response = [
          "status" => 400,
        'message' => 'invalid method',
      ];
      print_r(json_encode($response));
      }
    }
    public function getProduct()
    {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $loginData = $this->getData();
            $data = [
              'product_id' => trim($loginData['product_id']),
              // 'userid' => $userid
            ];
            if (empty($data['product_id'])) {
              $response = [
                "status" => 300,
              'message' => 'insert product_id',
            ];
            print_r(json_encode($response));
            exit;
            }
            
            if (2 + 1 == 3) {
              $this->userModel->getproduct($data);
            }else{
              $response = [
                "status" => 400,
              'message' => 'unable to get details',
            ];
            print_r(json_encode($response));
            }
          
            
       
      }else {
        $response = [
          "status" => 400,
        'message' => 'invalid method',
      ];
      print_r(json_encode($response));
      }
    }
    public function deleteproduct()
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
        $email = $userData->email;
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $loginData = $this->getData();
            $data = [
              'product_id' => trim($loginData['product_id']),
              'userid' => $userid
            ];
            if (empty($data['product_id'])) {
              $response = [
                "status" => 300,
              'message' => 'insert product_id',
            ];
            print_r(json_encode($response));
            exit;
            }
            
            if ($this->userModel->deleteProductx($data)) {
              $response = [
                "status" => 200,
              'message' => 'delete success',
            ];
            print_r(json_encode($response));
            exit;
            }else{
              $response = [
                "status" => 400,
              'message' => 'delete failed',
            ];
            print_r(json_encode($response));
            }
       
      }else {
        $response = [
          "status" => 400,
        'message' => 'invalid method',
      ];
      print_r(json_encode($response));
      }
    }
    public function getAllProduct()
    {

          if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->userModel->getAllproductx();
       
      }else {
        $response = [
          "status" => 400,
        'message' => 'invalid method',
      ];
      print_r(json_encode($response));
      }
    }
   

  }