<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"/www/hexiao/public/../application/admin/view/signlist/form.html";i:1568974728;s:54:"/www/hexiao/application/admin/view/layout/default.html";i:1562338656;s:51:"/www/hexiao/application/admin/view/common/meta.html";i:1562338656;s:53:"/www/hexiao/application/admin/view/common/script.html";i:1562338656;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="form-form" class="form-horizontal" name="iddd" role="form" data-toggle="validator" method="POST" action="">

    <?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): if( count($row)==0 ) : echo "" ;else: foreach($row as $key=>$vo): if($vo['type']==0): ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo $vo['title']; ?></label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <input id="c-signtime" class="form-control datetimepicker" data-use-current="true"  type="text" value="<?php echo $vo['content']; ?>">
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo $vo['title']; ?>：</label>
        <div class="col-xs-12 col-sm-8">
            <img onmousemove="bigImg(this)" src="<?php echo $vo['content']; ?>" style="width: 100px;height: 60px">
        </div>
    </div>
    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<script language=javascript>
    document.iddd.文本框名称.focus();
</script>
<script src="/assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript">
    function bigImg(x){
        x.style.height="300px";
        x.style.width="300px";
    }
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>