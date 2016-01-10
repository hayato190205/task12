<?php
//####基本要件(必須)
//下記のようなCSV形式の売上データが与えられている。
//このCSVファイルを読み込んで、社員数、売上合計、売上平均を出力せよ。

//####応用要件
//上記の出力結果を"report.csv"というファイル名で出力せよ。

//```csv:sales.csv
//社員名,売上
//Kashiwagi,1000
//Hidaka,500
//Ohira,300
//```

//```実行結果
//画面表示結果
//社員数:3
//売上合計:1800
//売上平均:600
//```

//```csv:report.csv
//社員数,売上合計,売上平均
//3,1800,600
//```

require_once('functions.php');
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if(isset($_FILES['csv']) && is_uploaded_file($_FILES['csv']['tmp_name']))
  {
    $uploadfile = "./csvfile/".$_FILE['csv']['name'];
    if (move_uploaded_file($_FILES['csv']['tmp_name'], $uploadfile))
    {
      echo $FILES['csv']['name']."のアップロード完了";
    }
    else
    {
      echo $_FILES['csv']['name']."のアップロード完了";
    }
  }
  else
  {
    echo "ファイル未選択";
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CSVファイルの読み込みと出力</title>
  </head>
  <body>
    <form action="" method="POST" name="csv">
    <input type="file" accept="text/comma-separated-values">
    <input type="submit" value="アップロード">
  </body>
</html>
