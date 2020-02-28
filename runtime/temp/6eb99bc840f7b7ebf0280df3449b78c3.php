<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"/www/hexiao/public/../application/admin/view/paper/edit.html";i:1567427368;s:54:"/www/hexiao/application/admin/view/layout/default.html";i:1562338656;s:51:"/www/hexiao/application/admin/view/common/meta.html";i:1562338656;s:53:"/www/hexiao/application/admin/view/common/script.html";i:1562338656;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Papername'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-papername" class="form-control" name="row[papername]" type="text" value="<?php echo htmlentities($row['papername']); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Note'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-note" class="form-control" name="row[note]" type="text" value="<?php echo htmlentities($row['note']); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Charge'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <select  id="c-charge" data-rule="required" class="form-control selectpicker" name="row[charge]">
                <?php if(is_array($chargeList) || $chargeList instanceof \think\Collection || $chargeList instanceof \think\Paginator): if( count($chargeList)==0 ) : echo "" ;else: foreach($chargeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['charge'])?$row['charge']:explode(',',$row['charge']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group" id="chargenum">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Chargenum'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-chargenum" class="form-control"  name="row[chargenum]" type="text" value="<?php echo htmlentities($row['chargenum']); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<script src="/public/assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript" >
    $(function(){
        var num=$('#c-charge').val();
        if(num==1){
            $('#chargenum').css('display','block');
        }else{
            $('#chargenum').css('display','none');
        }

        $('#c-charge').change(function(){
            var num=$('#c-charge').val();
            if(num==1){
                $('#chargenum').css('display','block');
            }else{
                $('#chargenum').css('display','none');
            }
        });

    });
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