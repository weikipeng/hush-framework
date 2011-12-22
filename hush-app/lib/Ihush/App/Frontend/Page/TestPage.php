<?php
/**
 * Ihush App
 *
 * @category   Ihush
 * @package    Ihush_App_Frontend
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
require_once 'Ihush/App/Frontend/Page.php';
require_once 'Ihush/Paging.php';

/**
 * @package Ihush_App_Frontend
 */
class TestPage extends Ihush_App_Frontend_Page
{
	
	public function indexAction () 
	{
		echo 'This is index action'; 
	}
	
	public function mappingAction () 
	{
		echo 'This is mapping action'; 
	}
	
	public function pagingAction () 
	{
		echo 'Paging object : ';
		$this->pagingDemo();
		
	}
	
	/*
	 * 分页使用“特别说明”：
	 * 
	 * 本框架的分页支持两种方式：
	 * 1、第一个参数是数组：针对普通数组的分页，也就是本例，如果需要分页的数据是现成的数据建议使用这种简单方式
	 * 2、第一个参数是数字：常在 DAO 类中使用，参数表示查询出的总数，然后可使用分页类中的 frNum 和 toNum 数
	 * 值结合 MySQL 的 limit 使用。举例如下：
	 * ...
	 * $sql = $this->dbr()->select()... // 查找语句
	 * $page = new Ihush_Paging($totalNumber, $eachPageNumber, $thisPageNumber, array(...));
	 * $sql->limit($page['frNum'], $page['toNum']); // 结合 Limit 分页
	 * ...
	 * 当然如果你要使用 Zend Db 自带的 limitPage 方法也是可以的，具体的实例见：
	 * hush-app/lib/Ihush/Dao/Core/BpmRequest.php 中的 getDetails() 方法的用法
	 */
	private function pagingDemo ()
	{
		$data = array();
		for ($i = 0; $i < 100; $i++) {
			$data[$i]['id'] = $i;
			$data[$i]['name'] = 'Test' . $i;
		}
		
		/*
		 * 分页类使用说明：
		 * 
		 * 参数1：具体用法见本方法前面的“特别说明”
		 * 参数2：每页包含的数据项个数
		 * 参数3：页码数，空则表示首页
		 * 参数4：分页模式，目前支持的 Mode 有三种，分别是 Google、Common、JavaEye 的分页模式
		 * 
		 * 更多使用方法请参考 hush-lib/Hush/Paging.php 类中的使用说明
		 */
		$page = new Ihush_Paging($data, 5, null, array(
			'Href' => '/test/p/{page}?debug=time',
			'Mode' => 3,
		));
		
//		$page->setTotalPage(5); // only if have no total count
		
		Hush_Util::dump($page->paging());
	}
}
