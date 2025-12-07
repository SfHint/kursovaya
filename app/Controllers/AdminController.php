<?php
require_once __DIR__ . '/../Models/Poll.php';
require_once __DIR__ . '/../Models/Admin.php';
require_once __DIR__ . '/../Models/Vote.php';

class AdminController {
    private $pdo;
    private $config;
    public function __construct($pdo, $config){ $this->pdo=$pdo; $this->config=$config; session_start(); }

    private function checkAuth(){
        if(empty($_SESSION['admin_logged'])){ header('Location: '.$this->config['base_url'].'/admin.php?action=login'); exit; }
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $a = new Admin($this->pdo);
            $row = $a->findByUsername($username);
            if($row && password_verify($password, $row['password_hash'])){
                $_SESSION['admin_logged'] = $row['username'];
                header('Location: '.$this->config['base_url'].'/admin.php');
                exit;
            } else {
                $error = 'Неверные данные для входа';
            }
        }
        include __DIR__ . '/../../views/admin/login.php';
    }

    public function logout(){
        session_start();
        session_destroy();
        header('Location: '.$this->config['base_url'].'/admin.php?action=login');
    }

    public function index(){
        $this->checkAuth();
        $m = new Poll($this->pdo);
        $polls = $m->all();
        $config = $this->config;
        include __DIR__ . '/../../views/admin/list.php';
    }

    public function create(){
        $this->checkAuth();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = $_POST['title'] ?? '';
            $desc = $_POST['description'] ?? '';
            $options_raw = $_POST['options'] ?? '';
            $options = array_values(array_filter(array_map('trim', explode("\n", $options_raw))));
            $options_arr = [];
            $i = 1;
            foreach($options as $opt){ $options_arr[] = ['id' => $i++, 'text' => $opt]; }
            $optsJson = json_encode($options_arr, JSON_UNESCAPED_UNICODE);
            $start = $_POST['start_time'] ?: null;
            $end = $_POST['end_time'] ?: null;
            $m = new Poll($this->pdo);
            $m->create($title, $desc, $optsJson, $start, $end);
            header('Location: '.$this->config['base_url'].'/admin.php');
            exit;
        }
        $config = $this->config;
        include __DIR__ . '/../../views/admin/create.php';
    }

    public function edit(){
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if(!$id) die('No id');
        $m = new Poll($this->pdo);
        $poll = $m->find($id);
        if(!$poll) die('Not found');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = $_POST['title'] ?? '';
            $desc = $_POST['description'] ?? '';
            $options_raw = $_POST['options'] ?? '';
            $options = array_values(array_filter(array_map('trim', explode("\n", $options_raw))));
            $options_arr = [];
            $i = 1;
            foreach($options as $opt){ $options_arr[] = ['id' => $i++, 'text' => $opt]; }
            $optsJson = json_encode($options_arr, JSON_UNESCAPED_UNICODE);
            $start = $_POST['start_time'] ?: null;
            $end = $_POST['end_time'] ?: null;

            unset($opt);
            $m->update($id, $title, $desc, $optsJson, $start, $end);
            header('Location: '.$this->config['base_url'].'/admin.php');
            exit;
        }
        $config = $this->config;
        include __DIR__ . '/../../views/admin/edit.php';
    }

    public function delete(){
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if(!$id) die('No id');
        $m = new Poll($this->pdo);
        $m->delete($id);
        header('Location: '.$this->config['base_url'].'/admin.php');
    }

    public function results(){
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if(!$id) die('No id');
        $m = new Poll($this->pdo);
        $v = new Vote($this->pdo);
        $poll = $m->find($id);
        $options = json_decode($poll['options'], true);
        $counts = $v->counts($poll['id']);
        $config = $this->config;
        include __DIR__ . '/../../views/admin/results.php';
    }
}
