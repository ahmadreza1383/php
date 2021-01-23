<?php
///////////////////////توضیحات مهم و مورد نیاز قبل کد ها تعریف شده است و از تعریف کد های تکراری خودداری شده است////////////////////////
//varible database name
$local = "";
$database = "";
$username = "";
$pass = "";
//define

define("local" , "$local");
define("database" , "$database");
define("username" , "$username");
define("pass" , "$pass");
//ایجاد یک کلس
class database {
	//ساخت یک ابجکت از نوع پابلیک و ساختار استاتیک  
	public static $_mHandler;
	//ستاخت فانکشن به نام گت از نوع پابلیک و ساختار استاتیک
  	public static function get() {
    if(!isset(self::$_mHandler)){
			try{
				$MyError = array();
				//ساخت 4 اندیس و گرفتن تمامی دیفاین ها با constant
				$arr = array(constant("local"), constant("database") , constant("username"),constant("pass"));
				//خارج سازی اندیس ها
				$dbs = $arr[0];
				$db = $arr[1];
				$uname = $arr[2];
				$pass = $arr[3];
				//شرط بررسی خالی بودن یک اندیس از ارایه و ریختن ان در ارایه خطاها
				if(empty($dbs)){array_push($MyError , "لطفا لوکال خود را مشخص کنید");
				};
				if(empty($db)){array_push($MyError , "لطفا دیتابیس خود را مشخص کنید");};
				if(empty($uname)){array_push($MyError , "لطفا یوسرنیم خود را مشخص کنید");};
				//ساخت حلقه و چاپ کردن خطا ها
				foreach($MyError as $Error){

					echo $Error;

					exit();
				}
				//ساخت شی پی دی او و معرفی لوکال و یوسر نیم و دیتایس و پسورد 
				self::$_mHandler =new PDO("mysql:$dbs=localhost;dbname=$db","$uname", "$pass");
				//اگر تابع تری تلاش خود را کرد و به نتیجه نرسید تابع کش اجرا شود
	
			} catch (PDOException $e) {
				self::Close();
				trigger_error($e->getMessage(), E_USER_ERROR);
			}
		}
		//بازگردانی ابجکت
		return self::$_mHandler;
  }

  	public static function GetAll($query ,  $fetchStyle = PDO::FETCH_ASSOC) {
		//گرفتن بازگردانی فانکشن گت در کلاس دیتابیس
		$databasehandler = database::get();
		
			try{
				//گرفتن و پراپر کردن متغیر دیتابیس هندلر و ریختن ان در متغیر دیگری
			$statement_handler =$databasehandler->prepare($query);
			//execute کردن متغیر 
			$statement_handler->execute();
			//متغیر استاتمنت هندلر را فقتچ ال کرده که به معنای گرفتن تمامی ستون های داخل دیتابیس است
			$result = $statement_handler->fetchAll($fetchStyle);
			//بازگردانی متغیر result
			return $result;
					self::Close(); 

			} catch(PDOException $e){
					self::Close();
					trigger_error($e->getMessage(), E_USER_ERROR);
					return false;

		}
	  }

	  public static function Execute($query){

		$databasehandler = self::get();

		try {

			$statement_handler = $databasehandler->prepare($query);
			$statement_handler->execute();
			$result = $statement_handler->rowCount();
			return $result;

		} catch (PDOException $e) {

			self::Close();
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;

		}


	  }

	  public static function GetRow($query){

		$databasehandler = self::get();

		try {

			$statement_handler = $databasehandler->prepare($query);
			$statement_handler->execute();
			$result = $statement_handler->fetch();
			return $result;

		}
		 catch (PDOException $e) {
			self::Close();
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;		}

	  }

}
$out = new database();

//////////////////// برای گرفتن تمامی ستون ها 

//$getall = database::GetAll("SELECT * FROM `NAME_TABLE`");
//و برای چاپ کردن

/*foreach($getall as $itel){

	$item['نام سطر'];
	
}*/


///////////////////برای گرفتن یک ستون
//$getall = database::GetRow("SELECT * FROM `NAME_TABLE`");
//و برای چاپ کردن
// echo $getall['نام سطر'];



///////////////////برای انجام یک عملیات مانند اپدیت ایجاد و یا حذف
//$getall = database::Execute("UPDATE `time_number` SET `id` = '11', `link` = '12' WHERE `time`.`id` = 135; ");








 

?> 