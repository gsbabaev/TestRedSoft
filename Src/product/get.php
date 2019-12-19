<?php

//namespace TestRedSotf;


class get
{
    protected $json;
    protected $db;

    public function __construct($task, $data)
    {
        include 'config.php';

        $this->config = $config;

        $this->db = new SafeMySQL($this->config);
        $this->json = $this->{$task}( $data);
    }

    protected function get($data){
        // Получение информации о товаре
        // GET /product/get/{Id}/../{Id}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            foreach ($data as $k => $Id) {
                try{
                    // Вытаскиваем товар из базы...
                    $product = $this->db->getAll('SELECT * FROM test_taxonomy_product WHERE id = ?i',$Id);
                    $json['data'][$k] = $product[0];
                    $cat = $this->db->getCol('SELECT name FROM test_taxonomy_category 
                        WHERE id IN (
                            select idc from test_taxonomy_xref where idp = ?i
                        )
                        ',$Id);
                    $json['data'][$k]['cat'] = $cat;

                }catch (Exception $exception){
                    $json['message'] = $exception->getMessage();
                    break;
                }
            }
        }
        return $json;
    }

    protected function find($data){
        // Получение информации о товаре
        // GET /product/find/{substr}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{
                // Вытаскиваем товар из базы...
                $products = $this->db->getAll('SELECT * FROM test_taxonomy_product WHERE name like ?s ','%'.$data[0].'%');

                foreach ($products as $k => $product) {
                    $cat = $this->db->getCol('SELECT name FROM test_taxonomy_category 
                        WHERE id IN (
                            select idc from test_taxonomy_xref where idp = ?i
                        )
                        ',$product['id']);
                    $json['data'][$k] = $product;
                    $json['data'][$k]['cat'] = $cat;
                }
            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
        }
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
                // Вытаскиваем товар из базы...
                $products = $this->db->getAll('SELECT * FROM test_taxonomy_product WHERE manuf IN (?a) ',$data);

                foreach ($products as $k => $product) {
                    $cat = $this->db->getCol('SELECT name FROM test_taxonomy_category 
                        WHERE id IN (
                            select idc from test_taxonomy_xref where idp = ?i
                        )
                        ',$product['id']);
                    $json['data'][$k] = $product;
                    $json['data'][$k]['cat'] = $cat;
                }
            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
        }
        return $json;
    }

    protected function cat($data){
        // Получение информации о товаре
        // GET /product/cat/{cat}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{
                $cat = $data[0];

                $cat_name = $this->db->getOne('SELECT name FROM test_taxonomy_category WHERE id = ?i ',$cat);
                // Вытаскиваем товар из базы...
                $products = $this->db->getAll('SELECT * , "'.$cat_name.'" as cat FROM test_taxonomy_product 
                        WHERE id IN (
                            select idp from test_taxonomy_xref where idc = ?i
                        )
                        ',$cat);
                $json['data']= $products;

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
                $cats = $data[0];
                $db['dsn'] = 'mysql:dbname='.$this->config['db'].';host=localhost;port=3306;charset=UTF8';
                $db['username'] = $this->config['user'];
                $db['password'] = $this->config['pass'];
                $db['options'] = [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // throws PDOException.
                ];
                $db['tablename'] = 'test_taxonomy_category';

                $this->config;

                $NestedSet = new \Rundiz\NestedSet\NestedSet(['pdoconfig' => $db, 'tablename' => $db['tablename']]);

            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
        }
        return $json;
    }

    public function json(){
        return $this->json;
    }
}