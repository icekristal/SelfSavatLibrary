<?php
/**
 * Created by PhpStorm.
 * User: Savatneev Anton
 * Date: 07.08.2017
 * Time: 14:23
 */

namespace fnc;


use SplFileInfo;

class ImageUpload
{


    /**
     * @param $image - $_FILES
     * @param $tmp_path - путь к файлу
     * @param $new_name - имя
     * @param null $size - либо 1 либо 1 / нужен или нет новый размер
     * @param null $swidth / если size 1 - то это новая ширина
     * @param null $sheight / если size 1 - то это новая высота
     * @return array
     */
    public static function uploadimage($image, $tmp_path, $new_name, $size = null, $swidth=null, $sheight=null){
        $rezData = array();

        $result = true;
        $source = null;

        // Проверка формата

        $info = new SplFileInfo($image['name']);
        $type_self_format = $info->getExtension();

        $validFormat = array('jpg' , 'jpeg' , 'png' );
        $resultFormat = self::checkValidFormat($image['name'], $validFormat);
        if(!$resultFormat){
            $rezData['success']=0;
            $rezData['message']="Не верный формат изображения";
            return $rezData;
        }

        if($image["size"] > upload_max_filesize){
            $rezData['success']=0;
            $rezData['message']="Большой размер файла";
            return $rezData;
        }

        $type_n = 0;
        // Выбор формата
        if ($image['type'] == 'image/jpeg') {
            $source = imagecreatefromjpeg($image['tmp_name']);
            $type_n = 1;
        }
        elseif ($image['type'] == 'image/png'){
            $source = imagecreatefrompng ($image['tmp_name']);
            $type_n = 2;
        } elseif ($image['type'] == 'image/jpg'){
            $source = imagecreatefromjpeg ($image['tmp_name']);
            $type_n = 1;
        }
        else {
            $rezData['success']=0;
            $rezData['message']="Не верный формат изображения";
            return $rezData;
        }

        if(!$source){
            $rezData['success']=0;
            $rezData['message']="Не загружено изображение";
            return $rezData;
        }

        if($result){
            $w_src = imagesx($source);
            $h_src = imagesy($source);
            if(!$size) {
                $m_height = 200;
                $m_width = 200;
            }else{
                if($sheight==null and $swidth==null){

                    $m_height = $h_src;
                    $m_width = $w_src;
                }else{
                    $m_height = $sheight;
                    $m_width = $swidth;

                }

            }
            $new_name = $new_name.'.'.$type_self_format;
            $dest = imagecreatetruecolor($m_width, $m_height);

            imagealphablending($dest, false);
            imagesavealpha($dest, true);

            imagecopyresampled($dest, $source, 0, 0, 0, 0, $m_width, $m_height, $w_src, $h_src);

            if( $type_n == 1) {
                imagejpeg($dest, $tmp_path . $new_name);
            } else if($type_n == 2){
                imagepng($dest, $tmp_path . $new_name);
            }else{
                exit();
            }
            imagedestroy($dest);
            imagedestroy($source);
            $rezData['success']=1;
            $rezData['file_name']=$new_name;
        }


        return $rezData;
    }



    private static function checkValidFormat($file, $validFormat){
        // определяем формат файла


        $tmp = explode('.', $file);
        $file_extension = end($tmp);
        if(in_array(strtolower($file_extension), $validFormat)){
            return true;
        }
        return false;
    }



}