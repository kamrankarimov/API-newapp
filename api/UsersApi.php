<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../conf.class.php';

class API
{
    private const DBNAME = 'newapp';
    private $requestMethod;
    private $userId;

  //  public function __construct($collection, $requestMethod, $userId = null, $datas = null)
   public function __construct($paramAPI)
    {
        $this->requestMethod  = $paramAPI['RequestMethod']; //CollectionName
        $this->userId         = $paramAPI['dataGET_Method'];
        $this->getRequest($paramAPI['CollectionName'], $paramAPI['DataUI']);
    }

    public function getUser($coll, $find){
        $db = data::db(self::DBNAME);
        return $db->$coll->find(array(key($find) => $find[key($find)]));
    }

    public function getAllUsers($coll){
        $db = data::db(self::DBNAME);
        return $db->$coll;
    }

    public function addUser($coll,$data){
        $db = data::db(self::DBNAME);
        $db->$coll->insertOne($data);
        return true;
    }

    public function getResponseJSON($response){
      $arr = array();
      foreach ($response as $user) {
        array_push($arr, $user);
      };
      echo json_encode($arr);
    }

    public function getRequest($coll, $data){
      switch ($this->requestMethod) {

          case 'GET':
              if ($this->userId) {
                  $response = $this->getUser($coll, $this->userId);
                  $this->getResponseJSON($response);
              } else {
                  $response = $this->getAllUsers($coll);
                  $this->getResponseJSON($response->find());
              }
              break;

          case 'POST':
                  $this->AddUser($coll, $data);
                  return true;
              break;

          default:
              //$response = $this->notFoundResponse();
              echo 'Wrong Parameter';
              break;
      }
    }

}

// $datas = array(
//     "id"        => 5,
//     "fullname"  => "Kamran Karimov",
//     "username"  => "kamrankarimov",
//     "mail"      => "kamran.vecsiz@gmail.com"
// );

$POST_DATA = json_decode(file_get_contents("php://input"),true);

//@$_GET['id'] ? $get_id  = (int) @$_GET['id'] : $get_id = null;

$paramAPI = array(
  "CollectionName"  => "users",
  "RequestMethod"   => $_SERVER['REQUEST_METHOD'],
  "dataGET_Method"  => $_GET,
  "DataUI"          => $POST_DATA
);


//$api = new API ('users', $_SERVER['REQUEST_METHOD'], $_GET, $data);

new API ($paramAPI);




?>
