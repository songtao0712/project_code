<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/22
 * Time: 16:00
 */
namespace frontend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsPhoto;
use backend\models\GoodsSearchForm;
use frontend\components\SphinxClient;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ListController extends Controller{
    public $layout = 'list';
    //商品列表
    public function actionList($id){
        $model = Goods::findAll(['goods_category_id'=>$id]);
        //获取品牌
        $brand = Brand::find()->all();
//        var_dump($brand);
//        var_dump($model);
        return $this->render('list',['model'=>$model,'brand'=>$brand]);
    }

    //搜索功能
    public function actionSearch(){
        $model = new GoodsSearchForm();
        $query = Goods::find();
        if($keyword = \Yii::$app->request->post('search')){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');//shopstore_search
            if(!isset($res['matches'])){
                //如果没有搜索到商品就返回ID为0
                $query->where(['id'=>0]);
            }else{
                $ids = ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }

            $pager = new Pagination([
                'totalCount'=>$query->count(),
                'pageSize'=>5
            ]);

            $models = $query->limit($pager->limit)->offset($pager->offset)->all();
            $keyword = array_keys($res['words']);
            $options = array(
                'before_match'=>'<span style="color: red">',
                'after_match'=>'</span>',
                'limit'=>80
            );



            //关键字高亮显示
            foreach ($models as $index => $item) {
                $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keyword), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
                $models[$index]->name = $name[0];

            }

            //获取品牌
            $brand = Brand::find()->all();
            return $this->render('list',['model'=>$model,'pager'=>$pager,'models'=>$models,'brand'=>$brand]);

        }
    }

    //商品详情
    public function actionCheck($id){
        $goods = Goods::findOne(['id'=>$id]);
        $photo = GoodsPhoto::find(['goods_id'=>$id])->all();
        return $this->render('check',['goods'=>$goods,'photo'=>$photo]);
    }


}