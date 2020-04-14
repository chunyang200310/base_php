<?php
/*
 * 数据库操作接口
 */
declare(strict_types = 1);

namespace framework\dao;

error_reporting(E_ALL);

interface I_DAO
{
	public function fetchRow($sql);

	public function FetchAll($sql);

	public function fetchColumn($sql);

	public function exec($sql);

	public function quote($str);

	public function lastInsertId();
}
