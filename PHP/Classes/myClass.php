 <?php
 class DBLink {
  private $link;
  public $count = 0;
  public function __construct ($database_name) {
	$lines = file('/home/int322_163c17/secret/topsecret.txt');
	$dbserver = trim($lines[0]);
	$uid = trim($lines[1]);
	$pw = trim($lines[2]);
	$link = mysqli_connect($dbserver, $uid, $pw, $database_name) or die('Could not connect: ' . mysqli_error($link));
	$this->link = $link;
   }
  function query ($sql_query) {
   $result = mysqli_query($this->link, $sql_query) or die('Query failed '. mysqli_error($link));
   return $result;
   }
  function row ($sql_query) {
	$result = mysqli_num_rows($sql_query);
	return $result;
  }
  function __destruct() {
   mysqli_close($this->link);
   }
  function emptyResult($sql_query) {
	$r = mysqli_num_rows($sql_query);
	if ($r == 0) return true;
	else {
		$this->count = $r;
		return false;
	}
  }
 }
 
 class Validation {
	 
	 private $error;
	 function emptyCheck ($str) {
		 
		 $msg = "";
		 
		 if ($str == "") {
			 
			$msg = "Must put in a value";
			$this->error = $msg;
			return true;
			
		 }
		 else return false;
		 
	 }
	 
	 function get() {
		 
		 return $this->error;
		 
	 }
	 
 }
 
 class Menu {
  public $val;
  public function __construct ($str) {
	$this->val = $str;
  }
 }
 ?>