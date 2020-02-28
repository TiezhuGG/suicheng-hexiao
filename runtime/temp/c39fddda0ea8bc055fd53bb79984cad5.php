<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"/www/hexiao/public/../application/admin/view/activity/add.html";i:1567681747;s:54:"/www/hexiao/application/admin/view/layout/default.html";i:1562338656;s:51:"/www/hexiao/application/admin/view/common/meta.html";i:1562338656;s:53:"/www/hexiao/application/admin/view/common/script.html";i:1562338656;}*/ ?>
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
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Activityname'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-activityname" data-rule="required" class="form-control" name="row[activityname]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Logo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-logo" class="form-control" size="50" name="row[logo]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-logo" class="btn btn-danger plupload" data-input-id="c-logo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-logo"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-logo" class="btn btn-primary fachoose" data-input-id="c-logo" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-logo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-logo"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Activityimages'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-activityimages" class="form-control" size="50" name="row[activityimages]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-activityimages" class="btn btn-danger plupload" data-input-id="c-activityimages" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-activityimages"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-activityimages" class="btn btn-primary fachoose" data-input-id="c-activityimages" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-activityimages"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-activityimages"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Organizers'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-organizers" class="form-control" name="row[organizers]" type="text">
        </div>
    </div>
    <div class="form-group" data-toggle="addresspicker" data-input-id="c-address" data-lat-id="c-navigation_y"  data-lng-id="c-navigation_x">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Address'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-address" class="form-control" name="row[address]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Block'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-block" class="form-control" name="row[block]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Public_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-public_name" class="form-control" name="row[public_name]" type="text">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Public_desc'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-public_desc" class="form-control" name="row[public_desc]" type="text">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Public_logo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-public_logo" class="form-control" size="50" name="row[public_logo]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-public_logo" class="btn btn-danger plupload" data-input-id="c-public_logo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-public_logo"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-public_logo" class="btn btn-primary fachoose" data-input-id="c-public_logo" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-activityimages"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-public_logo"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Rqcode'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-rqcode" class="form-control" size="50" name="row[rqcode]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-rqcode" class="btn btn-danger plupload" data-input-id="c-rqcode" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-rqcode"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-rqcode" class="btn btn-primary fachoose" data-input-id="c-rqcode" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-activityimages"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-rqcode"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Views'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-views" class="form-control" name="row[views]" type="text">
        </div>
    </div>
    <div id="x" class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Navigation_x'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-navigation_x" class="form-control" name="row[navigation_x]" type="text" >
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Navigation_y'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-navigation_y" class="form-control" name="row[navigation_y]" type="text" >
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Audit_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8" data-multiple="true">
            <select  multiple="multiple" id="c-audit_id"   class="form-control selectpicker"  name="row[audit_id][]">
                <?php if(is_array($hxlist) || $hxlist instanceof \think\Collection || $hxlist instanceof \think\Paginator): if( count($hxlist)==0 ) : echo "" ;else: foreach($hxlist as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"0"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>p
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Signuptime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-signuptime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[signuptime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Signupendtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-signupendtime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[signupendtime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Audittime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-audittime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[audittime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Auditendtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-auditendtime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[auditendtime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Statrtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-statrtime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[statrtime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Endtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-endtime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[endtime]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Signupnum'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-signupnum" class="form-control" name="row[signupnum]" type="number">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Notcharge'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-notcharge" data-rule="required" class="form-control selectpicker" name="row[notcharge]">
                <?php if(is_array($notchargeList) || $notchargeList instanceof \think\Collection || $notchargeList instanceof \think\Paginator): if( count($notchargeList)==0 ) : echo "" ;else: foreach($notchargeList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"0"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group" id="notcharge" style="display:none;">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Charge'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-charge" class="form-control" name="row[charge]" type="number">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Notaudit'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <select  id="c-notaudit" data-rule="required" class="form-control selectpicker" name="row[notaudit]">
                <?php if(is_array($notauditList) || $notauditList instanceof \think\Collection || $notauditList instanceof \think\Paginator): if( count($notauditList)==0 ) : echo "" ;else: foreach($notauditList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"0"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Signupmust'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-signupmust" class="editor " rows="5" name="row[signupmust]" cols="50"></textarea>
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
<script type="text/javascript" src="jquery.qrcode.min.js"></script>
<script src="/public/assets/js/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $(function(){
        $('#c-notcharge').change(function(){
           var value=$('#c-notcharge').val();
           if(value==1){
               $('#notcharge').css('display','block');
           }else{
               $('#notcharge').css('display','none');
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