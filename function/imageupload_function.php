<?php

function upload_image($image,$tmp_path,$new_name,$size = null,$swidth=null,$sheight=null){
    $result = true;
    $source = null;

    // Проверка формата

    $info = new SplFileInfo($image['name']);
    $type_self_format = $info->getExtension();

    $validFormat = array('jpg' , 'jpeg' , 'png' );
    $resultFormat = checkValidFormat($image['name'], $validFormat);
    if(!$resultFormat){

        $result =false;
        return $result;
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
        $result =false;
        return $result;
    }

    if(!$source){
        $result =false;
        return $result;
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
        $result = $new_name;
    }


    return $result;
}

function checkValidFormat($file, $validFormat){
    // определяем формат файла
    $format = end(explode(".", $file));
    if(in_array(strtolower($format), $validFormat)){
        return true;
    }
    return false;
}
