<?php
namespace app\crontab\controller;

use app\common\jiesuanmodel\Time as TimeModel;

class Time
{
	private $param;
	public function __construct(){
		$param = [];
		$this->param = array_merge($param,$_GET,$_POST);

	}
	public function index(){
		if(isset($this->param['time']))TimeModel::setTime($this->param['time']);
		$result = TimeModel::getTime();
		return json_encode(array('data'=>$result),true);
	}
}
