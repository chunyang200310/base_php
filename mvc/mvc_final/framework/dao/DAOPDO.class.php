<?php
/* DAOPDO.class.php
 * 操作数据库的具体方法
 */
declare(strict_types = 1);

namespace framework\dao;

use framework\dao\I_DAO;
use \PDO;
use \PDOException;

error_reporting(E_ALL);

class DAOPDO implements I_DAO
{
	private static $instance;
	private $pdo;

	private function __construct(array $option)
	{
		$host ??= $option['host'];
		$user ??= $option['user'];
		$pass ??= $option['pass'];
		$dbname ??= $option['dbname'];
		$port ??= $option['port'];
		$charset ??= $option['charset'];

		if (!$host || !$user || !$pass || !$dbname || !$port || !$charset) {
			die('Arguments error. <br />');
		}

		$dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset";

		try {
			$this->pdo = new PDO($dsn, $user, $pass);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	private function __clone() { }
	
	public static function getSingleton(array $option): DAOPDO
	{
		if (!self::$instance instanceof self) {
			self::$instance = new self($option);
		}
		return self::$instance;
	}

	public function fetchRow($sql)
	{
		$pdo_statement = $this->pdo->query($sql);

		if (false === $pdo_statement) {
			echo 'sql error: <font color="red">' . $this->pdo->errorInfo()[2] . 
				'</font>. <br />';
			return false;
		}
		$result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
		$pdo_statement->closeCursor();
		return $result;
	}

	public function fetchAll($sql)
	{
		$pdo_statement = $this->pdo->query($sql);

		if (false === $pdo_statement) {
			echo 'sql error: <font color="red">' . $this->pdo->errorInfo()[2] . 
				'</font>. <br />';
			return false;
		}
		$result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
		$pdo_statement->closeCursor();
		return $result;
	}

	public function fetchColumn($sql)
	{
		$pdo_statement = $this->pdo->query($sql);

		if (false === $pdo_statement) {
			echo 'sql error: <font color="red">' . $this->pdo->errorInfo()[2] . 
				'</font>. <br />';
			return false;
		}
		$result = $pdo_statement->fetchColumn();
		$pdo_statement->closeCursor();
		return $result;
	}

	public function exec($sql)
	{
		$result = $this->pdo->exec($sql);

		if (false === $result) {
			echo 'Sql error: <font color="red">' . $this->pdo->errorInfo()[2] .
				'</font>. <br />';
			return false;
		}
		return $result;
	}

	public function quote($str)
	{
		return $this->pdo->quote($str);
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}
