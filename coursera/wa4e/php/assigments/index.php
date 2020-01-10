<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php
      $dir="./";
      $files=scandir($dir);

      foreach ($files as $key => $value) {
          echo '<a href="'.$value.'">'.$value.'</a><br />';
      }
    ?>
</body>
</html>
