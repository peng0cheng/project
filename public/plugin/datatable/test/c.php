<?php


$input = $_REQUEST['input'];
//var_dump($input);

$info = array();
$info[] = array('彭程1','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程2','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程3','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程4','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程5','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程6','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程7','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程8','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程9','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程10','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程11','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程12','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程13','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程14','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程15','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程16','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程17','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程18','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程19','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程20','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程21','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程22','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程23','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程24','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程25','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程26','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程27','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程28','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程29','18618447101','男','1987-12-19','<a href="#">查看</a>');
$info[] = array('彭程30','18618447101','男','1987-12-19','<a href="#">查看</a>');

$count = count($info);

$data = array();
$data['page'] = $input['page'];//翻页信息
$data['page']['number'] = $count;//计算总数
$data['search'] = $input['search'];//页面搜索条件
$data['data'] = array_slice($info,$data['page']['from'],$data['page']['length']);//组成 data
//var_dump($data);
echo json_encode($data);