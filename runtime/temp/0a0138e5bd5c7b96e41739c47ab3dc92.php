<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"/www/hexiao/public/../application/admin/view/activity/form.html";i:1567157364;s:54:"/www/hexiao/application/admin/view/layout/default.html";i:1562338656;s:51:"/www/hexiao/application/admin/view/common/meta.html";i:1562338656;s:53:"/www/hexiao/application/admin/view/common/script.html";i:1562338656;}*/ ?>
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
                                <style>
    .form-control {
        width: 80%;
        display: inline-block;
    }

    .btn-danger {
        margin-left: 10px;
    }
</style>
<form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">活动名:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name"  class="form-control" name="row[activityname]" type="text"
                   value="<?php echo htmlentities($row['activityname']); ?>" readonly>
        </div>
    </div>
    <div>
        <p>------------------------------------------------表单设置
            -----------------------------------------------&nbsp;
            <a href="javascript:;" class="btn btn-success btn-add" title="<?php echo __('Add'); ?>"><i class="fa fa-plus"></i><?php echo __('Add'); ?></a>
        </p>
        <?php if($row['custom']): foreach($row['custom'] as $item): ?>
        <div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2">标题:</label>
                <div class="col-xs-12 col-sm-8">
                    <input  class="form-control" name="row[title][]" type="text"
                           value="<?php echo (isset($item['title']) && ($item['title'] !== '')?$item['title']:''); ?>"><a href="javascript:void(0);" class="btn btn-danger btn-del"><i
                        class="fa fa-trash"></i>删除</a>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2">副标题:</label>
                <div class="col-xs-12 col-sm-8">
                    <input  class="form-control" name="row[futitle][]" type="text"
                           value="<?php echo (isset($item['futitle']) && ($item['futitle'] !== '')?$item['futitle']:''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2">文本类型:</label>
                <div class="col-xs-12 col-sm-8">
                    <select  name="row[type][]" data-source="category/selectpage" class="form-control selectpage">
                            <?php if($item['type'] == 1): ?>
                                <option selected="selected" value="1">图片</option>
                                <option  value="0">文本</option>
                            <?php else: ?>
                                <option selected="selected" value="0">文本</option>
                                <option  value="1">图片</option>
                            <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2">标题:</label>
                <div class="col-xs-12 col-sm-8">
                    <input  class="form-control" name="row[title][]" type="text">
                    <a href="javascript:void(0);" class="btn btn-danger btn-del"><i
                        class="fa fa-trash"></i>删除</a>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2">副标题:</label>
                <div class="col-xs-12 col-sm-8">
                    <input  class="form-control" name="row[futitle][]" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-2">类型:</label>
                <div class="col-xs-12 col-sm-8">
                    <select name="row[type][]" data-source="category/selectpage" class="form-control selectpage">
                        <option selected="selected" >请选择类型</option>
                        <option value="0" >文本</option>
                        <option value="1">图片上传</option>
                    </select>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<script src="/assets/js/jquery-3.3.1.js" ></script>
<script>
    $(function () {
        $('.btn-add').click(function () {
            var _this = $(this);
            var html = '<div><p style="padding: 3px;"></p>';
            html += _this.parent().next().html();
            html += '</div>';
            _this.parent().parent().append($(html));
        });
        $('#edit-form').on('click', '.btn-del', function () {
            var divs = $(this).parent().parent().parent();
            if (divs.siblings('div').size() < 1) {
                return false;
            }
            divs.remove();
        })
    })
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