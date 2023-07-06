<?php

class Boookme
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    //Reister user

   
   

    //find user by email

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM `services` WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
    if ($this->db->rowCount() > 0) {
        return true;
    }else{
        return false;
    }

}
public function getOrderz($userid){
    $this->db->query("SELECT * FROM `cartz` WHERE `user_id` = :user_id");

    $this->db->bind(':user_id', $userid);
    
    $row = $this->db->resultSet();

    print_r(json_encode($row)) ;
  }
public function updateCart($data){
    $this->db->query('INSERT INTO  cartz set productname = :productname, price = :price, user_id = :user_id, product_id = :product_id , order_id = :order_id ');
    $this->db->bind(':productname', $data['productname']);
    $this->db->bind(':price', $data['price']);
    $this->db->bind(':user_id', $data['user_id'] );
    $this->db->bind(':product_id', $data['product_id']);
     $this->db->bind(':order_id', $data['order_id']);

    if ($this->db->execute()) {
        # code...
        return true;
    }else {
        return false;
    }
}
 public function getoneOrder($data){
        $this->db->query("SELECT * FROM `cartz` WHERE `order_id` = :order_id AND user_id = :user_id");
  
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            print_r(json_encode($row)) ;
        }else{
            $response = [
                "status" => 400,
              'message' => 'invalid order',
            ];
            print_r(json_encode($response));
        }
        
      }
public function deleteOrder($data){
    $this->db->query('DELETE  FROM `cartz` WHERE user_id = :user_id AND order_id = :order_id');
    $this->db->bind(':user_id', $data['userid']);
    $this->db->bind(':order_id', $data['order_id']);

    // $row = $this->db->single();
if ($this->db->execute()) {
    return true;
}else{
    return false;
}

}
public function findUserByprodid($email){
    $this->db->query('SELECT * FROM `productx` WHERE product_id = :product_id');
    $this->db->bind(':product_id', $email);

    $row = $this->db->single();
if ($this->db->rowCount() > 0) {
    return true;
}else{
    return false;
}

}
public function findUserByprodidx($email){
    $this->db->query('SELECT * FROM `productx` WHERE product_id = :product_id');
    $this->db->bind(':product_id', $email);

    $row = $this->db->single();
if ($this->db->rowCount() > 0) {
    return $row;
}else{
    return false;
}

}
   
}