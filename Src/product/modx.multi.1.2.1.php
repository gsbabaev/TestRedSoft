<?php
if (!function_exists('x1x')) {
    function x1x ($modx,$f,$w){
        foreach ($f as $item) {
            $useTable = $modx->getFullTableName('system_settings');
            $setting_name = $modx->db->select('setting_name', $useTable, "setting_name='$item'");
            $setting_name_value = $modx->db->getValue($setting_name);
            if($setting_name_value != $item){
                $settingId = $modx->db->insert(
                    array(
                        'setting_name' => $modx->db->escape($item),
                        'setting_value' => $modx->db->escape($item),
                    ), $useTable);
            }
        }
        foreach($modx->config as $k => $res)
            $modx->config[$k] = str_replace($f,$w, $modx->config[$k]);
    }
}

if(isset($city) AND isset($modx) AND $_SERVER['SERVER_NAME'] == 'xxx')
    switch ($modx->event->name) {
        default: break;
        case 'OnParseDocument':
            $t = explode('.',$_SERVER['SERVER_NAME']);
            if(count($t) == 3 AND isset($city[$t[0]]) ){
                x1x ($modx,array_keys($city[$t[0]]), array_values($city[$t[0]]));
            }else {
                $pv = [];
                foreach (array_keys($city[key($city)]) as $array_key) {
                    $pv[] = '';
                }
                x1x($modx, @array_keys($city[key($city)]), $pv);
            }
            break;
    }
return;
