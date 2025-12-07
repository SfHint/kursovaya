<!doctype html>
<html><head><meta charset="utf-8"><title>Вход</title><link rel="stylesheet" href="/styles.css"></head><body>
<div class="container">
<h1>Вход в аккаунт</h1>
<a href="/index.php" class="button button-gray">← Вернуться на главную</a>
<?php if(!empty($error)): ?><p class="error"><?=htmlspecialchars($error)?></p><?php endif; ?>
<form method="post">
<input type="text" name="username" placeholder="Логин" required><br>
<input type="password" name="password" placeholder="Пароль" required><br>
<button>Войти</button>
</form>
</div></body></html>