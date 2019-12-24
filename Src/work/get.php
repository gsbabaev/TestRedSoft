<?php

//namespace RESTfulPHPtpl;


class get
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

    protected function gets($data){
        // Получение информации
        // GET /work/gets
        //$json = ['success' => FALSE, 'message' => 'product get Error', 'data' => null]; //Ошибка
        //if (1 OR  is_array($data) AND count($data) ) {
            $json['method'] = 'GET';
            $json['success'] = true;
            $json['message'] = 'ok';

            try{
                $data = $this->db->getAll("
                    SELECT bu.id, bu.name, bu.email, bu.work, bu.result, bs.name as status, bu.editWork
                    FROM ?n as bu 
                    LEFT JOIN ?n as bs ON bs.id = bu.status_id 
                    WHERE 1",'test_bee_user','test_bee_status');
                // Вытаскиваем товар из базы...
                $json['data'] =
                    $this->_prepareRow($data)
                ;

            }catch (Exception $exception){
                $json['message'] = $exception->getMessage();

            }

        //}
        return $json;
    }

    protected function _prepareRow($row){
        $r = [];
        foreach ($row as $item) {
            $r[] = array_values($item);
        }
        return $r;
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