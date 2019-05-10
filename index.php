<?php


  include "dbInfo.php";

  class Persona{


    private $name;
    private $lastname;

    public function set($name,$lastname){

      $this-> setName($name);
      $this-> setLastname($lastname);
    }

    public function setName($name){

      $this->name = $name;
      $this->lastname = $lastname;
    }

    public function getName(){

      return $this->name;
    }

    public function setLastname($lastname){

      $this->lastname = $lastname;
    }

    public function getLastname(){

      return $this->lastname;
    }
  }

  class Pagante extends Persona {

    private $address;

    public function set($name,$lastname,$address){

      parent::set($name,$lastname);
      $this->setAddress($address);

    }

    public function setAddress($address){

      $this->address =$address;

    }

    public function getAddress(){

      return $this->address;
    }

    public static function getAllPaganti($conn){

      $sql = "
              SELECT *
              FROM paganti
      ";

      $result = $conn->query($sql);

      $paganti = [];

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;

          $pagante = new Pagante();
          $pagante->set($row["name"],
                        $row["lastname"],
                        $row["address"]
          );

          $paganti[]=$pagante;

        }
      } else {
        echo "0 results";
      }

      return $paganti;
    }

    public static function getEPaganti($conn){

      $sql = "
              SELECT *
              FROM paganti
              WHERE name LIKE 'e%'
      ";

      $result = $conn->query($sql);

      $paganti = [];

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;

          $pagante = new Pagante();
          $pagante->set($row["name"],
                        $row["lastname"],
                        $row["address"]
          );

          $paganti[]=$pagante;

        }
      } else {
        echo "0 results";
      }

      return $paganti;
    }

  }

  // Connessione al Database---------------------------

  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection - controlla la connessione
  if ($conn->connect_errno) {
    echo ("Connection failed: " . $conn->connect_error);
    return;
  }

  // Get all paganti --------------------------

  $paganti = Pagante::getAllPaganti($conn);

  echo"<br><b>ALL PAGANTI</b><br><br>";

  foreach ($paganti as $pagante) {

    print_r($pagante); echo "<br>";
  }


  echo "<hr>";

  // Get paganti with  "E" ---------------------------

  echo"<br><b>ALL PAGANTI STARTING WITH 'E'</b><br><br>";

  $pagantiE = Pagante::getEPaganti($conn);

  foreach ($pagantiE as $pagante) {

    print_r($pagante); echo "<br>";
  }

  // Chiusura al Database---------------------------

  $conn->close();

 ?>
