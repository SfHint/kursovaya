<!doctype html>
<html><head><meta charset="utf-8"><title>Результаты</title><link rel="stylesheet" href="../styles.css"></head><body>
<div class="container"><h1>Results for <?=htmlspecialchars($poll['title'])?></h1>
<?php
$total = array_sum($counts);
foreach($options as $opt):
  $c = $counts[$opt['id']] ?? 0;
  $pct = $total ? round($c / $total * 100, 1) : 0;
?>
  <div class="result-row"><div class="label"><?=htmlspecialchars($opt['text'])?></div>
  <div class="bar"><div class="bar-inner" style="width:<?=$pct?>%"></div></div>
  <div class="count"><?=$c?> (<?=$pct?>%)</div></div>
<?php endforeach; ?>
<p><a href="admin.php" class="button button-gray">Назад</a></p>
</div></body></html>
