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
    $uploadfile = "./csvfile/".$_FILES['csv']['name'];
    if (move_uploaded_file($_FILES['csv']['tmp_name'], $uploadfile))
    {
      echo "「".$_FILES['csv']['name']."」のアップロード完了";
    }
    else
    {
      echo "アップロード失敗";
    }
  }
  else
  {
    echo "ファイル未選択";
  }
}

echo "<br>"."<br>";

$csvFile="./csvfile/".$_FILES['csv']['name'];
if (!file_exists($csvFile))
{
  echo ('ファイルが存在しません。');
}
$tempCSV = file_get_contents($csvFile);
$tempCSV = mb_convert_encoding($tempCSV, 'utf-8');
$fp = tmpfile();
fwrite($fp, $tempCSV);
rewind($fp);
setlocale(LC_ALL, 'ja_JP.UTF-8');//あとで調べる
$html ='<table>';
$names = array();
$sales = array();
while ($arr = fgetcsv($fp))
{
  if (!array_diff($arr, array('')))
  {
    continue;
  }
  list($name, $sale) = $arr;
  $names[] = $name;
  $sales[] = $sale;
}
  // var_dump($names);
  // var_dump($sales);
  $numbers = count($names)-1;
  $total_sales = array_sum($sales);
  $average = $total_sales/$numbers;


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CSVファイルの読み込みと出力</title>
  </head>
  <body>
    <form enctype="multipart/form-data" action="" method="post">
      <input type="file" name="csv" accept="text/comma-separated-values">
      <input type="submit" value="アップロード"><br>
      <計算数値><br>
        <?php echo "社員数: ".$numbers."人<br>";?>
        <?php echo "売上合計: ".$total_sales."円<br>";?>
        <?php echo "売上平均: ".$average."円<br>";?>

    </form>
  </body>
</html>
