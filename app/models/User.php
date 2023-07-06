<?php

class User
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    //Reister user

    public function register_Veluxite($data){
        $this->db->query('INSERT INTO initkey set full_name = :full_name, email = :email, user_id = :user_id, password = :password ');
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':user_id', $data['user_id'] );
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            # code...
            return true;
        }else {
            return false;
        }
    }
    public function profileUpdate($data, $tk){
        $this->db->query('UPDATE initkey set full_name = :full_name, email = :email, password = :password  WHERE  user_id = :user_id and bearer_token = :bearer_token');
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':user_id', $data['user_id'] );
        $this->db->bind(':bearer_token', $tk );
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            # code...
            return true;
        }else {
            return false;
        }
    }
    public function getUserByidx($id)
    {
        $this->db->query("SELECT * FROM initkey WHERE  user_id = :user_id");

        // Bind Values
        $this->db->bind(':user_id', $id);

        $row = $this->db->single();

        // Check roow
        return $row;
    }
    public function addproductx($data){
        $this->db->query('INSERT INTO productx set productname = :productname, price = :price, owner_id = :owner_id, product_id = :product_id, owner_email = :owner_email ');
        $this->db->bind(':productname', $data['productname']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':owner_id', $data['owner_id'] );
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':owner_email', $data['owner_email']);

        if ($this->db->execute()) {
            # code...
            return true;
        }else {
            return false;
        }
    }
    public function updateproductx($data){
        $this->db->query('UPDATE  productx set productname = :productname, price = :price WHERE  owner_id = :owner_id AND  product_id = :product_id ');
        $this->db->bind(':productname', $data['productname']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':owner_id', $data['owner_id'] );
        $this->db->bind(':product_id', $data['product_id']);
        // $this->db->bind(':owner_email', $data['owner_email']);

        if ($this->db->execute()) {
            # code...
            return true;
        }else {
            return false;
        }
    }
    public function getUserById($id){
        $this->db->query("SELECT * FROM `initkey` WHERE `id` = :id");
  
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
  
        return $row;
      }
    public function getproductx($userid, $email){
        $this->db->query("SELECT * FROM `productx` WHERE `owner_id` = :owner_id AND owner_email = :owner_email");
  
        $this->db->bind(':owner_id', $userid);
        $this->db->bind(':owner_email', $email);
        $row = $this->db->resultSet();
  
        print_r(json_encode($row)) ;
      }
  
    public function getproduct($data){
        $this->db->query("SELECT * FROM `productx` WHERE `product_id` = :product_id");
  
        $this->db->bind(':product_id', $data['product_id']);
        // $this->db->bind(':owner_email', $email);
        $row = $this->db->single();
  
        print_r(json_encode($row)) ;
      }
   
    public function getAllproductx(){
        $this->db->query("SELECT * FROM `productx` ");
  
       
        $row = $this->db->resultSet();
  
        print_r(json_encode($row)) ;
      }
   

    //find user by email

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM `initkey` WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
    if ($this->db->rowCount() > 0) {
        return true;
    }else{
        return false;
    }

}

    public function deleteProductx($data){
        $this->db->query('DELETE  FROM `productx` WHERE owner_id = :owner_id AND product_id = :product_id');
        $this->db->bind(':owner_id', $data['userid']);
        $this->db->bind(':product_id', $data['product_id']);

        // $row = $this->db->single();
    if ($this->db->execute()) {
        return true;
    }else{
        return false;
    }

}
    
public function updateToken($user_id, $token, $email)
{
    $this->db->query('UPDATE  initkey SET bearer_token = :bearer_token WHERE user_id= :user_id and email = :email');
    $this->db->bind(':user_id', $user_id);
    $this->db->bind(':bearer_token', $token);
    $this->db->bind(':email', $email);
    // Execute
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}
public function findLoginByToken($token)
{
    $this->db->query('SELECT * FROM initkey WHERE bearer_token= :bearer_token');
    $this->db->bind(':bearer_token', $token);

    $row = $this->db->single();
    return $row;


}
public function findUserByEmail_det($email)
{
    $this->db->query("SELECT * FROM initkey WHERE  email = :email");

    // Bind Values
    $this->db->bind(':email', $email);

    $row = $this->db->single();


    return $row;

}
public function loginUser($email, $password){
    $this->db->query('SELECT * FROM initkey WHERE email = :email');
    $this->db->bind(':email', $email);
    $row = $this->db->single();
    $hashed_password = $row->password;
    if (password_verify($password, $hashed_password)) {
        # code...
        return $row;
    }else {
        return false;
    }
}
public function updatepass($data){
    $this->db->query('UPDATE  `initkey` SET password = :password WHERE ');
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':email', $data['password']);
    $row = $this->db->single();
    if ($this->db->rowCount() > 0) {
        # code...
        return $row;
    }else {
        return false;
    }
}
}