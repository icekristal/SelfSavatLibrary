<?php
//Обработка шаблонизатора

/**
 * Формирование запрашиваемой страницы
 *
 * @param $controllerName
 * @param string $actionName
 */
function loadPage($smarty, $controllerName, $actionName = 'index'){
    $filename = PathPrefix . $controllerName . PathPostfix;
    if (!file_exists($filename)) {
        $controllerName = 'Error';
    }

    if($controllerName == 'Catalog'){
        $actionName = 'Index';
    }

    if($controllerName == 'Blog'){
        $actionName = 'Index';
    }

    if($controllerName == 'Teachers'){
        $actionName = 'Index';
    }


    include_once PathPrefix . $controllerName . PathPostfix;
    $function = $actionName.'Action';
    $function($smarty);

}


/**
 * @param $smarty
 * @param $templateName
 */
function loadTemplate($smarty, $templateName){
    $templateName .= TemplatePostfix;
    $smarty->display($templateName);
}


/*Удобный вывод для смарти*/
/**
 * @param $rs
 */
function createSmartyRsArray($rs){

    if(!$rs) return false;

    $smartyRs = array();
    while ($row = mysqli_fetch_assoc($rs)){
        $smartyRs[] = $row;
    }
    return $smartyRs;
}
