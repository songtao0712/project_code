<style>
    h3{
    color:#4f9fcf;
        font-family: 微软雅黑;
    }
    span{
        color: #1a1a1a;
        font-family: 微软雅黑;
    }
</style>
<h1 class="text-center">商品详情</h1>

<h3><?=$goods->name;?></h3>
<hr/>
<span>上架时间：<?=date('Y/m/d H:i:s',$goods->create_time)?></span>
<br/>
<span>本店售价：<?=$goods->shop_price?></span>
<br/>
<span>市场价格：<?=$goods->market_price?></span>
<br/>
<span>商品LOGO：<br/><img src="<?=$goods->logo;?>" height="100px"/></span>
<hr/>
<span>简介：</span>
<span><?=$intro->intro;?></span>
