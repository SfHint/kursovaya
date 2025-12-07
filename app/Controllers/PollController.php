<?php
require_once __DIR__ . '/../Models/Poll.php';
require_once __DIR__ . '/../Models/Vote.php';

class PollController {
    private $pdo;
    private $config;
    public function __construct($pdo, $config){ $this->pdo=$pdo; $this->config=$config; }

    private function getPollStatus($poll) {
        $now = new DateTime();
        $start = $poll['start_time'] ? new DateTime($poll['start_time']) : null;
        $end = $poll['end_time'] ? new DateTime($poll['end_time']) : null;
        
        if ($start && $now < $start) return 'pending';
        if ($end && $now > $end) return 'finished';
        return 'active';
    }

public function index(){
    $m = new Poll($this->pdo);
    $polls = $m->all();
    foreach($polls as &$p) {
        $p['status'] = $this->getPollStatus($p);
    }
    unset($p); 
    $config = $this->config;
    include __DIR__ . '/../../views/index.php';
}

    public function show($id){
        $m = new Poll($this->pdo);
        $v = new Vote($this->pdo);
        $poll = $m->find($id);
        if(!$poll){ header('HTTP/1.0 404 Not Found'); echo 'Poll not found'; exit; }
        
        $poll['status'] = $this->getPollStatus($poll);
        $options = json_decode($poll['options'], true);
        $counts = $v->counts($poll['id']);
        $config = $this->config;
        include __DIR__ . '/../../views/show.php';
    }

    public function vote($id){
        $m = new Poll($this->pdo);
        $v = new Vote($this->pdo);
        $poll = $m->find($id);
        if(!$poll){ header('HTTP/1.0 404 Not Found'); echo 'Poll not found'; exit; }
        
        $status = $this->getPollStatus($poll);
        if($status === 'pending') die('Опрос еще не начался');
        if($status === 'finished') die('Опрос завершен');
        
        if($this->config['recaptcha_secret_key']){
            $token = $_POST['g-recaptcha-response'] ?? '';
            $resp = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$this->config['recaptcha_secret_key'].'&response='.urlencode($token));
            $j = json_decode($resp, true);
            if(empty($j['success'])){ die('CAPTCHA verification failed'); }
        }

        $option_id = isset($_POST['option']) ? (int)$_POST['option'] : 0;
        if(!$option_id) { die('Invalid option'); }
        $v->add($id, $option_id);
        header('Location: '.$this->config['base_url'].'/index.php?action=show&id='.$id.'&voted=1');
    }
}