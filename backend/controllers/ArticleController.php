<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/9
 * Time: 19:53
 */
namespace backend\controllers;


use backend\components\RbacFilter;
use backend\models\Article;
use backend\models\Article_detail;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller{

    //使用过滤器
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className()
            ],
        ];
    }

    public function actionAdd(){
        $model = new Article();
        $content = new Article_detail();
        $cate = $model->cate();
//        var_dump($content);
//        var_dump($cate);exit;
        //接收数据
        $request = new Request();
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            $content->load($request->post());
//            var_dump($model->id);
            if($model->validate() && $content->validate()){
                //保存数据

                $model->create_time = time();
                $model->save();
                $content->article_id = $model->id;
//                $content->content = $model->content;
                $content->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
//                var_dump($content);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('add',['model'=>$model,'cate'=>$cate,'content'=>$content]);
    }

    //展示文章列表
    public function actionIndex(){
        $model = Article::find()->where(['status'=>1]);
        $total = $model->count();
        $page = new Pagination(
            [
                'totalCount'=>$total,//总条数
                'defaultPageSize'=>10,//每页显示多少条数据
            ]
        );

        $article = $model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['article'=>$article,'page'=>$page]);

    }

    //百度编辑器
    public function actions()
    {
        return [

            'ueditor' => [
                'class' => 'crazyfd\ueditor\Upload',
                'config'=>[
                    'uploadDir'=>date('Y/m/d')
                ]

            ],
        ];
    }

    //修改文章

    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        $content = Article_detail::findOne(['article_id'=>$id]);
        $cate = $model->cate();
//        var_dump($content);
//        var_dump($cate);exit;
        //接收数据
        $request = new Request();
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            $content->load($request->post());
//            var_dump($model->id);
            if($model->validate() && $content->validate()){
                //保存数据

                $model->create_time = time();
                $model->save();
//                $content->article_id = $model->id;
//                $content->content = $model->content;
                $content->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
//                var_dump($content);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }

        return $this->render('add',['model'=>$model,'cate'=>$cate,'content'=>$content]);
    }

    //查看文章
    public function actionCheck($id){
        $model = Article_detail::findOne(['article_id'=>$id]);
        $artile = Article::findOne(['id'=>$id]);
        return $this->render('check',['model'=>$model,'article'=>$artile]);
    }

    //假删除
    public function actionDel($id){
        $model = Article::findOne(['id'=>$id]);
        $model->status = '0';
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['index']);
    }

}