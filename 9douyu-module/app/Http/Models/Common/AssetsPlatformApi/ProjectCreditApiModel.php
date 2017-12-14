<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 12/4/17
 * Time: 1:51 PM
 */

namespace App\Http\Models\Common\AssetsPlatformApi;

use App\Http\Models\Common\HttpQuery;
use App\Http\Models\Model;
use Config;
use Log;

class ProjectCreditApiModel extends Model
{

    /**
     * @desc 获取项目关联债权列表[分页]
     * @param array $projectCredit
     * @return array|mixed
     */
    public static function getProjectCreditRelate(array $projectCredit){

        $apiUrl = Config::get('assetsPlatformApi.project_credit.get.url');
        $apiFunc = Config::get('assetsPlatformApi.project_credit.get.functionId');

        Log::info('获取项目关联债权信息'.__METHOD__, [$apiUrl, $projectCredit, $apiFunc]);

        $return = HttpQuery::assetsPlatformPost($apiUrl, $projectCredit, $apiFunc);

        return $return;
    }

}