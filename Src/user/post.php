<?php

//namespace RESTfulPHPtpl;

//if( !defined('YOUR_SESSION_ID'))
//    define('YOUR_SESSION_ID','238ce8006687bb42346d5939f9f6028b');


class post
{
    protected $json;
    protected $db;
    protected $config;

    public function __construct($task, $data)
    {
        $config = [];
        include __DIR__.'/../../config.php';
        $this->config = $config;

        $this->db = new SafeMySQL($this->config);
        $this->json = $this->{$task}( $data);
    }

    protected function auth($data){
        session_id(YOUR_SESSION_ID);
        session_start();
        // Авторизация
        // POST /work/auth
        $json = ['success' => FALSE, 'message' => 'Запрет авторизации', 'data' => null]; //Ошибка
        if (  is_array($data) AND count($data) AND
            $data['recipient-name'] == 'admin' AND $data['recipient-pwd'] == '123') {
            $json['method'] = 'POST';

            try{

                if (!isset($_SESSION['ip'])) {
                    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                    $json['success'] = true;
                    $json['message'] = 'ok. You auth success';
                }else{
                    if ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
                        $json['message'] = 'Wrong ip';
                    }else{
                        $json['success'] = true;
                        $json['message'] = 'You auth last time success';
                    }
                }



            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();

            }

        }else{
            if(isset($_SESSION['ip']))unset($_SESSION['ip']); //session_destroy();
        }
        session_write_close();
        return $json;
    }


    protected function quit($data){
        session_id(YOUR_SESSION_ID);
        session_start();
        // Выход
        // GET /user/quit
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка

            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok. Good quit auth.';
            try{
                // Вытаскиваем товар из базы...
                if(isset($_SESSION['ip']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])unset($_SESSION['ip']);
            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }

        session_write_close();
        return $json;
    }



    protected function manuf($data){
        // Получение информации о товаре
        // GET /product/manuf/{substr}/../{substr}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{

            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
        }
        return $json;
    }



    protected function cat($data){
        // Получение информации о товаре
        // GET /product/cat/{cat}/../{cat}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{

            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
        }
        return $json;
    }

    protected function cats($data){
        // Получение информации о товаре
        // GET /product/cats/{cat}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{


            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
        }
        return $json;
    }

    protected function _addCatInProducts($json,$products){
        foreach ($products as $k => $product) {
            $json['data'][$k] = $product;
            $json['data'][$k]['cat'] = $this->_getCatsId($product['id']);
        }
        return $json;
    }

    protected function _getCatsId($id){
        return $this->db->getCol('SELECT name FROM test_taxonomy_category 
                        WHERE id IN (
                            select idc from test_taxonomy_xref where idp = ?i
                        )
                        ',$id);
    }

    protected function _getProdId($ids){
        return $this->db->getAll('SELECT * FROM test_taxonomy_product 
                        WHERE id IN (
                            select idp from test_taxonomy_xref where idc IN (?a)
                        )
                        ',$ids);
    }

    public function json(){
        return $this->json;
    }
}