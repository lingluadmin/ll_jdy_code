<?php

/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 16/6/21
 * Time: 下午4:17
 */
namespace tests\Http\Models\Invest;

use App\Http\Models\Invest\InvestModel;

class InvestModelTest extends \TestCase
{

    public function dataTest(){

        return [
            [69],
            [132519],
        ];

    }

    /**
     * @param $key
     * @param $data
     * @dataProvider dataTest
     */
    public function testDoUpdateByKey($userId)
    {

        try {

            $model = new InvestModel();

            $result = $model->checkUserIdIsBeforeRefund( $userId );

            var_dump($result);

        }catch(\Exception $e){

            dump($e->getMessage(),$e->getCode(),$e->getFile(),$e->getLine());

        }


    }


}