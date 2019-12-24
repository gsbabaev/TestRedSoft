<?php


class post
{
    protected $json;
    protected $db;
    protected $config;

    public function __construct($task, $data)
    {
        $config = [];
        include __DIR__ . '/../../config.php';
        $this->config = $config;

        $this->db = new SafeMySQL($this->config);
        $this->json = $this->{$task}($data);
    }

    public function json(){
        return $this->json;
    }

    protected function create($data)
    {
        //session_id(YOUR_SESSION_ID);
        //session_start();
        // создание задачи
        // POST /work/create
        $json = ['success' => FALSE, 'message' => 'Запрет на выполнение операции.', 'data' => null]; //Ошибка

        if (is_array($data) AND count($data) ) {
            $json['method'] = 'POST';

            try {

                $sec = $this->db->getOne('
                    SELECT TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP , create_work  )) 
                    FROM ?n 
                    WHERE name = ?s AND 
                    email = ?s AND 
                    work = ?s  
                    ','test_bee_user', $data['recipient-name'],$data['recipient-email'],$data['message-text']);

                if(!$sec){
                    $id = $this->db->query("
                        INSERT INTO ?n (`id`, `status_id`, `name`, `email`, `create_work`, `work`, `editWork`, `result`, `finish_status`) VALUES
                        (null, 1, ?s, ?s, CURRENT_TIMESTAMP, ?s, 0, '', '0000-00-00 00:00:00');
                    ", 'test_bee_user', $data['recipient-name'],$data['recipient-email'],$data['message-text']);

                    $json = ['success' => TRUE, 'message' => 'Задача добавлена '.$id, 'data' => null];
                }else{
                    $json = ['success' => FALSE, 'message' => 'Подобная задача уже была добавлена более '.$this->hinterval($sec) .' назад', 'data' => null];
                }

            } catch (Exception $exception) {
                $json['message'] = $exception->getMessage();

            }

        } else {
            if (isset($_SESSION['ip'])) unset($_SESSION['ip']); //session_destroy();
        }
        //session_write_close();
        return $json;
    }


    protected function update($data)
    {
        session_id(YOUR_SESSION_ID);
        session_start();
        // update задачи
        // POST /work/update
        $json = ['success' => FALSE, 'message' => 'Запрет на выполнение операции не авторизированным пользователям.', 'data' => null]; //Ошибка

        if (is_array($data) AND count($data) AND
            isset($data['recipient-id'])
            AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) {
            $json['method'] = 'POST';

            try {

                $work = $this->db->getOne('
                    SELECT work 
                    FROM ?n 
                    WHERE id = ?i   
                    ','test_bee_user', $data['recipient-id']);

                $data_update = [
                    'status_id' => $data['wstatus'],
                    'name' => $data['recipient-name'],
                    'email' => $data['recipient-email'],
                    'work' => $data['message-text'],
                    'result' => $data['text-result'],
                    'finish_status' => date("Y-m-d H:i:s")
                ];

                if($work){
                    if($work != $data['message-text']) {
                        $data_update['editWork'] = 1;
                    }
                    $id = $this->db->query(
                        " UPDATE ?n SET ?u WHERE id = ?i", 'test_bee_user', $data_update, $data['recipient-id']);
                    if($work != $data['message-text']) {
                        $json = ['success' => TRUE, 'message' => 'Задача обновлена. + Обновление условий задачи', 'data' => null,'update' => true];
                    }else{
                        $json = ['success' => TRUE, 'message' => 'Задача обновлена.', 'data' => null];
                    }
                }else{
                    $json['message'] = 'Подобной записи не существует. Запрещённая операция.';
                }


            } catch (Exception $exception) {
                $json['message'] = $exception->getMessage();

            }

        }
        session_write_close();
        return $json;
    }

    protected function hinterval($sec){
        $str = $sec.' секунд';
        switch ($sec){
            default: break;
            //case $sec < 60: $str = round($sec,0).' секунд';
            //    break;
            case $sec < 60*60: $str = round($sec/60,0).' минут';
                break;
            case $sec < 60*60*24: $str = round($sec/60/60,0).' часов';
                break;
            case $sec < 60*60*24*7: $str = round($sec/60/60/24,0).' дней(суток)';
                break;
            case $sec < 60*60*24*365: $str = round($sec/60/60/24/7,0).' недель';
                break;
        }
        return $str;
    }
}