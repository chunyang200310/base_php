<?php
/* Model.class.php
 * 基础模型类, 每个模型类都会用到的公共代码
 */
declare(strict_types = 1);

namespace framework\core;

use framework\dao\DAOPDO;

error_reporting(E_ALL);

class Model
{
	protected $dao;

	// primary key
	protected $pk;

	protected string $true_table;

	public function __construct()
	{
		/* 为了代码的整洁以及多个方法的管理,建议所有独立的功能都封装成方法
		 * 构造函数里只调用方法,不写具体的方法
		 */

		/*
		$option = [ 
            'host'      =>  'localhost',
            'user'      =>  'root',
            'pass'      =>  'vxvd828q',
            'dbname'    =>  'php_7',
            'port'      =>  3306,
            'charset'   =>  'utf8'
		];
		 */
		/*
		// use globals config
		$option = $GLOBALS['config'];

		$this->dao = DAOPDO::getsingleton($option);
		 */

		$this->initDAO();
		$this->initTrueTable();
		$this->initField();
	}

	private function initField()
	{
		$sql = "DESC $this->true_table";
		$result = $this->dao->fetchAll($sql);

		foreach ($result as $k=>$v) {
			if ('PRI' == $v['Key']) {
				$this->pk = $v['Field'];
				break;
			}
		}
	}

	private function initDao()
	{
		$option = $GLOBALS['config'];

		$this->dao = DAOPDO::getSingleton($option);
	}

	private function initTrueTable()
	{
		$this->true_table = '`' . $GLOBALS['config']['table_prefix'] .
			$this->logic_table . '`';
		// var_dump($this->true_table);
	}

	//automatic insert
	public function insert($data)
	{
		// origin sql: INSERT INTO `goods` (`goods_name`) values ('Handys');
		$sql = "INSERT INTO $this->true_table";
		// die($sql);

		// combine fields list
		$fields = array_keys($data);
		$fields_list = array_map(function ($v) {
			return '`' . $v . '`';
		}, $fields);
		$fields_list = '(' . implode(',', $fields_list) . ')';
		$sql .= $fields_list;

		// combine Values
		$values = array_values($data);
		$values = array_map([$this->dao,'quote'], $values);
		$values = ' VALUES(' . implode(',', $values) . ')';
		$sql .= $values;
		// var_dump($sql);

		// execute sql and return Primary key
		$this->dao->exec($sql);
		return $this->dao->lastInsertId();
	}

	// automatic delete
	// $model->delete(primary key);
	public function delete($id)
	{
		$sql = "DELETE FROM $this->true_table WHERE $this->pk=$id";
		die($sql);
		//return $this->dao->exec($sql);
	}

	// automatic update
	public function update(array $data, array $where = null)
	{
		if (!$where) {
			echo 'Where condition is necessary. <br />';
			return false;
		} else {
			foreach ($where as $k=>$v) {
				$where_str = " WHERE `$k`='$v'";
			}
		}
		$sql = "UPDATE $this->true_table SET ";
		$fields = array_keys($data);
		$fields = array_map(function ($v) {
			return '`' . $v . '`';
		}, $fields);

		$field_values = array_values($data);
		$field_values = array_map([$this->dao, 'quote'], $field_values);

		$str = '';

		foreach ($fields as $k=>$v) {
			$str .= $v . '=' . $field_values[$k] . ',';
		}

		// delete the last comma
		$str = substr($str, 0, -1);

		// combine sql statement
		$sql .= $str . $where_str;
		//var_dump($sql);

		// excute SQL and return affected rows
		return $this->dao->exec($sql);
	}

	// automatic find
	public function find($data = [], $where = [])
	{
		// 如果没有指定字段,则表示所有字段
		if (!$data) {
			$fields = '*';
		} else {
			// combine fields
			$fields = array_map(function ($v) {
				return '`' . $v . '`';
			}, $data);
			$fields = implode(',', $fields);
		}
		if (!$where) {
			$sql = "SELECT $fields FROM $this->true_table";
		} else {
			foreach ($where as $k=>$v) {
				$where_str = '`' . $k . '`=' . "'$v'";
			}
			$sql = "SELECT $fields FROM $this->true_table WHERE $where_str";
		}
		// die($sql);
		return $this->dao->fetchRow($sql);
	}
}
