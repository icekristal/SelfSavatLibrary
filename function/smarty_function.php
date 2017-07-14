<?php
//Обработка шаблонизатора

/**
 * Формирование запрашиваемой страницы
 *
 * @param $controllerName
 * @param string $actionName
 */
function loadPage($smarty, $controllerName, $actionName = 'index',$besides=array()){
    $filename = PathPrefix . $controllerName . PathPostfix;
    if (!file_exists($filename)) {
        $controllerName = 'Error';
    }

    //Свойство besides - помимо этих контроллеров, для них сразу ставим Index
    foreach ($besides as $beside) {
        if($beside==$controllerName){
            $actionName = 'Index';
        }
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
