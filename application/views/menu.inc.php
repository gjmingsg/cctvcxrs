<?php
$menu = array('0' => array(
                     "首页"=>array("首页"=>"default_page/index")

                    ,"产品管理"=>array("服务产品"=>"product/servicelist"
                                        ,"产品物料"=>"product/materiallist"
                                        , "全部产品"=>"product/index"
                                    )
                    ,"客户管理" =>array(
                                        "客户列表" =>"customer/index"
                                    )
                    ,"用户管理"=>array(
                                        "代理商管理"=>"user/listagent"
                                        ,"添加代理商"=>"user/addagent"
                                        ,"第三方管理"=>"user/listthird"
                                        ,"添加第三方"=>"user/addthird"
                                        )
                    ,"交易管理"=>array(
                                        "全部交易记录"=>"transaction/index"
                                        ,"交易审批"=>"transaction/approvallist"
                                        ,"全部充值记录"=>"transaction/allrecharge"
                                        ,"全部购买记录"=>"transaction/purchase") 
                    ), 
                '1'=>array(
                    "首页"=>array("首页"=>"default_page/index")
                    ,"产品列表"=>array(
                                        "服务产品"=>"product/servicelist"
                                        ,"产品物料"=>"product/materiallist"
                                        ,"全部产品"=>"product/index"
                    )
                    ,"客户管理" =>array(
                        "客户列表" =>"customer/index"
                        ,"添加客户"=>"customer/add")
                    ,"交易记录"=>array(
                        "我的交易记录" =>"transaction/owntrans"
                        ,"我卖出的服务"=>"transaction/ownsale"
                        ,"充值记录"=>"user/rechargehistory")
                    ),
                '2'=>array(
                    "首页"=>array("首页"=>"default_page/index")
                    ,"我的代理商" =>array("代理商列表" =>"user/listagent")
                    ,"产品列表"=>array("服务产品"=>"product/servicelist"
                                        ,"产品物料"=>"product/materiallist"
                                        ,"全部产品"=>"product/index"
                                        )
                    ,"交易记录"=>array("代理商交易记录" =>"transaction/thirdlist")
                ));

$CI = &get_instance(); 
$usertype = $CI->session->userdata("usertype");
$top_menu =  $menu[$usertype];
$base_url = base_url()."index.php/";

?>
