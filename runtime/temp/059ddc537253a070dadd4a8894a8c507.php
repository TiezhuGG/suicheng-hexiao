<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"/www/hexiao/public/../application/admin/view/signlist/edit.html";i:1568101701;s:54:"/www/hexiao/application/admin/view/layout/default.html";i:1562338656;s:51:"/www/hexiao/application/admin/view/common/meta.html";i:1562338656;s:53:"/www/hexiao/application/admin/view/common/script.html";i:1562338656;}*/ ?>
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
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Activity_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select id="c-signingman" data-rule="" class="form-control selectpicker" name="row[activity_id]">
                <?php if(is_array($nametypelist) || $nametypelist instanceof \think\Collection || $nametypelist instanceof \think\Paginator): if( count($nametypelist)==0 ) : echo "" ;else: foreach($nametypelist as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['activity_id'])?$row['activity_id']:explode(',',$row['activity_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Qrcode'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-qrcode" class="form-control" name="row[qrcode]" type="text" value="<?php echo htmlentities($row['qrcode']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Username'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select id="c-vip_id" data-rule="" class="form-control selectpicker" name="row[vip_id]">
                <?php if(is_array($vipname) || $vipname instanceof \think\Collection || $vipname instanceof \think\Paginator): if( count($vipname)==0 ) : echo "" ;else: foreach($vipname as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['vip_id'])?$row['vip_id']:explode(',',$row['vip_id']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Signtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-signtime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[signtime]" type="text" value="<?php echo $row['signtime']?datetime($row['signtime']):''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Audit_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select id="c-aduit_id" data-rule="" class="form-control selectpicker" name="row[audit_id]">
                <?php if(is_array($hexiao) || $hexiao instanceof \think\Collection || $hexiao instanceof \think\Paginator): if( count($hexiao)==0 ) : echo "" ;else: foreach($hexiao as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',""))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Aduit'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <?php if(is_array($aduitList) || $aduitList instanceof \think\Collection || $aduitList instanceof \think\Paginator): if( count($aduitList)==0 ) : echo "" ;else: foreach($aduitList as $key=>$vo): ?>
                <label for="row[aduit]-<?php echo $key; ?>"><input id="row[aduit]-<?php echo $key; ?>" name="row[aduit]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['aduit'])?$row['aduit']:explode(',',$row['aduit']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('最终核销时间'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-updatetime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[updatetime]" type="text" value="<?php echo $row['updatetime']?datetime($row['updatetime']):''; ?>">
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>