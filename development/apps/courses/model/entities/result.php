<?php

namespace Model\Entities;

class Result
{

	use \Library\Shared;
	use \Library\Entity;

	public static function search(?Int $discipline = 0, ?String $description = '', Int $limit = 0):self|array|null {
		$result = [];
		foreach (['discipline', 'description'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$results = $db -> select(['Results' => []]);
		if(!empty($filters))
			$results->where(['Results' => $filters]);
		foreach ($results->many($limit) as $res) {
				$class = __CLASS__;
				$result[] = new $class($res['discipline'], $res['description']);
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}
	
	public static function loadResult(int $limit = 0): ?array {
		$result = [];
		$db = self::getDB();
		foreach ($db -> select([
			'Results' => []
		  ])->where([
			'Results' => []
		  ])->many($limit) as $results) {
					$class = __CLASS__;
					$result[] = new $class($results['discipline'], $results['description']);
		  }
		  return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;
	}

	public function edit(array $data){
		$db = $this->db;
		$db -> update('Results', $data)
			-> where(['Results'=> ['discipline' => $this->discipline]])
			-> run();
	  }

	public function __construct(public ?int $discipline = 0, public ?String $description = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}