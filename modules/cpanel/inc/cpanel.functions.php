<?php
/**
 * Cpanel Module
 *
 * @package Cotonti
 * @subpackage  Admin
 * @author Alex - Studio Portal30
 * @copyright Portal30 2014 http://portal30.ru
 */
defined('COT_CODE') or die('Wrong URL.');

function cot_renderMenu($tpl, $menu, $level){

    if(empty($menu)) return '';

    $t = new XTemplate(cot_tplfile($tpl, 'core'));

    foreach($menu as $key => $item){
        $item['active'] = !empty($item['active']) ? 1 : 0;
        $item['url'] = (isset($item['url']) && $item['url'] != '') ? $item['url'] : '#';
        $t->assign(array(
            'MENU_LEVEL' => $level,
            'MENU_URL'   => $item['url'],
            'MENU_DESC'  => isset($item['desc']) ? htmlspecialchars($item['desc']) : '',
            'MENU_CLASS' => isset($item['class']) ? $item['class'] : '',
            'MENU_ICON_CLASS' => isset($item['icon_class']) ? $item['icon_class'] : '',
            'MENU_TITLE' => htmlspecialchars($item['title']),
            'MENU_ID'    => $key,
            'MENU_ACTIVE'=> (isset($item['active']) && $item['active']) ? 1 : 0,
        ));
        if(!empty($item['items'])){
            $t->assign(array(
                'MENU_SUBMENU' => cot_renderMenu($tpl, $item['items'], $level + 1)
            ));
        }else{
            $t->assign(array(
                'MENU_SUBMENU' => '',
            ));
        }
        $t->parse('MAIN.ITEM');
    }
    $t->parse();
    return $t->text();
}