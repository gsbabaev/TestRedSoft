<?php


namespace TestRedSotf;

class get
{
    public function __construct($task, $data)
    {
        $this->task = $task;
    }

    public function json(){
        // Получение информации о товаре
        // GET /p/{goodId}
        /*
            if ( count($urlData) === 1) {
                // Получаем id товара
                $goodId = $urlData[0];

                // Вытаскиваем товар из базы...

                // Выводим ответ клиенту
                return json_encode(array(
                    'method' => 'GET',
                    'id' => $goodId,
                    'good' => 'phone',
                    'price' => 10000
                ));

            }
    */
    }
}