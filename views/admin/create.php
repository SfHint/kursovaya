<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Создание опроса</title>
  <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="container">
  <h1>Создать опрос</h1>
  <form method="post">
    <input type="text" name="title" placeholder="Название" required><br>
    <textarea name="description" placeholder="Описание"></textarea><br>
    <textarea name="options" placeholder="Варианты, один на строку" required></textarea><br>
    
    Время начала (YYYY-MM-DD HH:MM:SS): <input type="text" name="start_time" placeholder="2025-12-12 10:00:00"><br>
    Время конца (YYYY-MM-DD HH:MM:SS): <input type="text" name="end_time" placeholder="2025-12-13 18:00:00"><br>
    
    <button>Создать опрос</button>
  </form>
  <p><a href="admin.php" class="button button-gray">Назад</a></p>
</div>
</body>
</html>