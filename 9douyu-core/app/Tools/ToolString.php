<?php
/**
 * Created by PhpStorm.
 * User: scofie
 * Date: 16/4/21
 * Time: 下午1:35
 */

namespace App\Tools;

class ToolString{


    /**
     * @params array | project
     * @return string format project_name
     * @desc format project name
     */
    public static function setProjectName($project = array())
    {
        if(empty($project)) {
            return '' ;
        }
        $projectId  =   isset($project['project_id'] ) ? $project['project_id'] : $project['id'] ;

        $createTime    =   isset($project['project_time']) ? $project['project_time'] : $project['created_at'];

        $serial_number   = isset($project['serial_number']) && $project['serial_number'] >0 ? $project['serial_number'] : substr ($projectId,strlen($projectId)-1 ,1 ) ;

        return date('ymd' ,strtotime($createTime )) . '-' . $serial_number ;
    }

    /**
     * @desc 筛选字符串中的数字
     * @param $str string
     * @return string
     */
    public static function findNum($str='')
    {
        $str=trim($str);
        if(empty($str)){return '';}
        $result='';

        for($i=0;$i<strlen($str);$i++){

            if(is_numeric($str[$i])){

                $result.=$str[$i];
            }

        }

        return $result;
    }


}
