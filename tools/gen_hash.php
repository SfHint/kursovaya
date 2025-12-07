<?php
if(PHP_SAPI === 'cli'){
    $pw = $argv[1] ?? null;
    if(!$pw){ echo "Usage: php gen_hash.php your_password\n"; exit; }
    echo password_hash($pw, PASSWORD_DEFAULT) . "\n";
} else {
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $pw = $_POST['pw'] ?? '';
        echo password_hash($pw, PASSWORD_DEFAULT);
        exit;
    }
?>
<form method="post">
<input name="pw" placeholder="password"/><button>Gen</button>
</form>
<?php } ?>