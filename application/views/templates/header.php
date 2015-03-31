<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>轻应用直达号管理</title>
    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet" type="text/css">
    <!--    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>-->
    <script src="<?php echo base_url('assets/js/jquery.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/jquery.cookie.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/common.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/model/WdatePicker/WdatePicker.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/model/highcharts/highcharts.js') ?>"></script>
</head>
<body>
<div class="layout_header">
    <div class="header">
        <div class="h_logo">
            <a href="#" title="业务监控平台">
                <img src="<?= base_url('assets/images/qaup_logo.png') ?>" width="130" height="40" alt=""/>
            </a>
        </div>
        <div class="h_nav">
            <span class="hi">
                <img src="<?= base_url('assets/images/head_default.jpg') ?>"
                                                 alt="id"/> 欢迎你 <?= $this->session->userdata('username') ?>！
            </span>
            <span class="link">
                <a href="#" style="display: none"><i class="icon16 icon16-setting"></i> 设置</a>
                <a href="<?= base_url("login/logout") ?>"><i class="icon16 icon16-power"></i> 注销</a>
            </span>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="layout_leftnav">
    <div class="inner">
        <div class="nav-vertical">
            <ul class="accordion">
                <li><a href="#"><i class="icon20 icon20_status"></i>直达号数据过滤<span></span></a>
                    <ul class="sub-menu sub-menu-0">
                        <li><a data-order="0" data-order-parent="0" href="<?= base_url('/filter') ?>">数据过滤</a></li>
                        <li><a data-order="1" data-order-parent="0" href="<?= base_url('/#') ?>">未开放</a>
                        </li>
<!--                        <li><a data-order="2" data-order-parent="0" href="--><?//= base_url('/shop') ?><!--">商户列表</a></li>-->
<!--                        <li><a data-order="3" data-order-parent="0"-->
<!--                               href="--><?//= base_url('/shop/index/2/0') ?><!--">已通过商户列表</a></li>-->
<!--                        <li><a data-order="4" data-order-parent="0"-->
<!--                               href="--><?//= base_url('/shop/index/1/0') ?><!--">未通过商户列表</a></li>-->
<!--                        <li><a data-order="5" data-order-parent="0"-->
<!--                               href="--><?//= base_url('/shop/index/0/0') ?><!--">待审核商户列表</a></li>-->
                    </ul>
                </li>
<!--                <li><a href="#"><i class="icon20 icon20_setting"></i>个人设置<span></span></a>-->
<!--                    <ul class="sub-menu sub-menu-1">-->
<!--                        <li><a data-order="0" data-order-parent="1" href="--><?//= base_url('/account/selfInfo') ?><!--">个人信息</a>-->
<!--                        </li>-->
<!--                        <li><a data-order="1" data-order-parent="1" href="--><?//= base_url('/account/manage') ?><!--">审核人员管理</a>-->
<!--                        </li>-->
<!--                        <!--                        <li><a href="-->
<!--                        --><?// //= base_url('/account/logout')?><!--<!--">退出系统</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
            </ul>

        </div>
    </div>
</div>