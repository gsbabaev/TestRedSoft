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
                    $json['data'][$k]['cat'] = $this->_getCatsId($Id);

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

                $json = $this->_addCatInProducts($json,$products);
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

    protected function manuf($data){
        // Получение информации о товаре
        // GET /product/manuf/{substr}/../{substr}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{
                $products = $this->db->getAll('SELECT * FROM test_taxonomy_product WHERE manuf IN (?a) ',$data);

                $json = $this->_addCatInProducts($json,$products);
            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();
            }
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

    protected function cat($data){
        // Получение информации о товаре
        // GET /product/cat/{cat}/../{cat}
        $json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        if ( is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';
            try{
                $products = $this->_getProdId($data);
                $json = $this->_addCatInProducts($json,$products);
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

                require_once __DIR__."/../../lib/DbTreeExt.class.php";
                $tree_params = array(
                    'table' => 'test_taxonomy_category',
                    'id' => 'id',
                    'left' => 'tleft',
                    'right' => 'tright',
                    'level' => 'level'
                );
                $dbtree = new DbTreeExt($tree_params, $this->db);

                $products = $this->_getProdId(array_keys($dbtree->Branch($cats)));
                $json = $this->_addCatInProducts($json,$products);

                //echo $dbtree->MakeUlList($dbtree->Full(),'name');

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