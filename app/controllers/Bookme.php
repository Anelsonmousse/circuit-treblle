<?php
  class Bookme extends Controller{
    public function __construct(){
         $this->bookmeModel = $this->model('Boookme');
         $this->serverKey  = 'secret_server_key'.date("H");
         $this->userModel = $this->model('User');
    }
   
    public function ADDtoCart()
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
          'product_id' => trim($loginData['product_id']),
          'user_id' => $userid,
          'token' => $token,
          'full_name_err' => '',
          'product_id_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
          'user_id_err' => '',
        ];
       
        if (empty($data['product_id'])) {
          $data['product_id_err'] = 'Please enter product id';
        } else {
          if ($this->bookmeModel->findUserByprodid($data['product_id'])) {
           $productData = $this->bookmeModel->findUserByprodidx($data['product_id']);
           $data['productname'] = $productData->productname;
           $data['price'] = $productData->price;
          }else {
            $data['product_id_err'] = 'product is not available';
          }
        }
        $data['order_id'] = $this->generateSecureUuid();
        if (empty($data['product_id_err'])) {
          if ($this->bookmeModel->updateCart($data)) {
            $response = [
              'status' => 200,
              'message' => 'cart update successful'
            ];
            print_r(json_encode($response));
          } else {
            $response = [
                'status'=>200,
              'message' => 'cart update failed',
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
    public function getOrders()
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
            
            $this->bookmeModel->getOrderz($userid);
       
      }else {
        $response = [
          "status" => 400,
        'message' => 'invalid method',
      ];
      print_r(json_encode($response));
      }
    }
    public function deleteOrder()
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
              'order_id' => trim($loginData['order_id']),
              'userid' => $userid
            ];
            if (empty($data['order_id'])) {
              $response = [
                "status" => 300,
              'message' => 'insert order id',
            ];
            print_r(json_encode($response));
            exit;
            }
            
            if ($this->bookmeModel->deleteOrder($data)) {
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
    public function getsingleOrder()
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
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $loginData = $this->getData();
            $data = [
              'order_id' => trim($loginData['order_id']),
               'user_id' => $userid
            ];
            if (empty($data['order_id'])) {
              $response = [
                "status" => 300,
              'message' => 'insert order id',
            ];
            print_r(json_encode($response));
            exit;
            }
            
            if (2 + 1 == 3) {
              $this->bookmeModel->getoneOrder($data);
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
  }