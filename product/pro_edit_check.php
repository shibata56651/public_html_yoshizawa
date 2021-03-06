<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>よしざわ農園</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../main.css" />
    <script src="../main.js"></script>
</head>
<body>
	<?php
		include '../session.php';
	
		$pro_code = $_POST['code'];
		$pro_name = $_POST['name'];
		$pro_price = $_POST['price'];
		$pro_gazou_name_old = $_POST['gazou_name_old'];
		$pro_gazou = $_FILES['gazou'];
		//画像名をタイムスタンプとランダム関数で自動命名
		$pro_new_gazou_name = new DateTime();
		$pro_new_gazou_name = $pro_new_gazou_name->getTimestamp().rand();

		$pro_code = htmlspecialchars($pro_code);
		$pro_name = htmlspecialchars($pro_name);
		$pro_price = htmlspecialchars($pro_price);

		if($pro_name == '') {
			print '商品名が入力されていません。<br />';
		} else {
			print '商品名:';
			print $pro_name;
			print '<br />';
		}

		if(preg_match('/^[0-9]+$/',$pro_price) == 0) {
			print '価格をきちんと入力してください。<br />';
		} else {
			print '価格:';
			print $pro_price;
			print '円<br />';
		}

		if($pro_gazou['size'] > 0) {
			if($pro_gazou['size'] > 1000000) {
				print '画像が大き過ぎます';
			} else {
				move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_new_gazou_name);
				print '<img src="./gazou/'.$pro_new_gazou_name.'">';
				print '<br />';
			}
		} else {
			//ファイルがアップロードされなかった場合edit_doneでunlink回避が必要
			$pro_new_gazou_name = $pro_gazou_name_old;
		}

		if($pro_name=='' || preg_match('/^[0-9]+$/',$pro_price)==0 || $pro_gazou['size']>1000000) {
			print '<form>';
			print '<input type="button" onclick="history.back()" value="戻る">';
			print '</form>';
		} else {
			print '上記のように変更します。<br />';
			print '<form method="post" action="pro_edit_done.php">';
			print '<input type="hidden" name="code" value="'.$pro_code.'">';
			print '<input type="hidden" name="name" value="'.$pro_name.'">';
			print '<input type="hidden" name="price" value="'.$pro_price.'">';
			print '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
			print '<input type="hidden" name="gazou_name" value="'.$pro_new_gazou_name.'">';
			print '<br />';
			print '<input type="button" onclick="history.back()" value="戻る">';
			print '<input type="submit" value="OK">';
			print '</form>';
		}
	?>
</body>
</html>