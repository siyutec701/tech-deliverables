<html>
<meta  charset ="utf-8">

<?php

$dsn='データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS tb1"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
	. "pass char(32)"
	.");";
$stmt = $pdo->query($sql);

	if(!empty($_POST) ){ 
		$comment = $_POST["comment"];
		$pass = $_POST["pass1"];
		$editnew = $_POST["editnew"];

		//投稿
		if($comment != "" & !empty($_POST["pass1"])){
		if(empty($editnew)){
				
				
				$sql = $pdo -> prepare("INSERT INTO tb1 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
				$sql -> bindParam(':name', $name, PDO::PARAM_STR);
				$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
				$sql -> bindParam(':date', $date,  PDO::PARAM_STR);
				$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
				$name = $_POST["name"];
				$comment = $_POST["comment"];
				$date = date("Y/m/d H:i:s");
				$pass = $_POST["pass1"];
				$sql -> execute();
		}

		elseif(!empty($editnew)){
		$id = $editnew; 
		$name = $_POST["name"];
		$comment = $_POST["comment"]; 
		$sql = 'update tb1 set name=:name,comment=:comment where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
					}
					}


		//削除
		elseif($_POST["delete"] != "" ){
			$id = $_POST["delete"];
			$pass =  $_POST["pass2"];
			$sql = 'delete from tb1 where id=:id AND pass=:pass';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
			$stmt->execute();
		}

		//編集
		elseif($_POST["edit"] != ""){
		$id = $_POST["edit"];
		$pass = $_POST["pass3"];
		$sql = 'select * from tb1 where id=:id AND pass=:pass';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
		$stmt->execute();
		$results = $stmt->fetchAll();
		foreach ($results as $row){
		$editnumber = $row['id'];
		$editname = $row['name'];
		$editcomment = $row['comment'];
		}

		}
	}
		

?>

<form action="mission_5-2.php" method="post">
	<p>お名前：<br>
	<input type ="text" name ="name" value = "<?php
						if(!empty($editname)){
						 echo $editname;
						}
						?>"><br>
	<p>コメント：<br>
	<input type ="text" name ="comment" value = "<?php
						if(!empty($editcomment)){
						 echo $editcomment;
						}
						?>"><br>
	<p>パスワード：<br>
	<input type ="text" name ="pass1" value = ""><br>

	<input type ="hidden" name ="editnew" value = "<?php
						if(!empty($editnumber)){
						 echo $editnumber;
						}
						?>"><br>
	<input type ="submit" name ="btn" value = "書き込み"><br>

	<br><p>削除対象番号:<br>
	<input type ="text" name = "delete" value = ""><br>

	<p>パスワード：<br>
	<input type ="text" name ="pass2" value = ""><br>
	<input type ="submit" name ="btn" value ="削除"><br>

	
	<br><p>編集対象番号：<br>
	<input type ="text" name = "edit" value = ""><br>

	<p>パスワード：<br>
	<input type ="text" name ="pass3" value = ""><br>
	<input type ="submit" name ="btn" value ="編集"><br>
	</form>

<?php

$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = 'SELECT * FROM tb1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	echo "<hr>";
	}
?>

