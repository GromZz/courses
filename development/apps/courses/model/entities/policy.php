<?php

namespace Model\Entities;

class Policy
{

	use \Library\Shared;
	use \Library\Entity;

	public static function search(?Int $discipline = 0, ?String $description = '', Int $limit = 0):self|array|null {
		$result = [];
		foreach (['discipline', 'description'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$policies = $db -> select(['Education_policy' => []]);
		if(!empty($filters))
			$policies->where(['Education_policy' => $filters]);
		foreach ($policies->many($limit) as $policy) {
				$class = __CLASS__;
				$result[] = new $class($policy['discipline'], $policy['description']); 
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}

	public static function loadPolicy(int $limit = 0): ?array {
		$result = [];
		$db = self::getDB();
		foreach ($db -> select([
			'Education_policy' => []
		  ])->where([
			'Education_policy' => []
		  ])->many($limit) as $policy) {
					$class = __CLASS__;
					$result[] = new $class($policy['discipline'], $policy['description']);
		  }
	
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;
	}

	public function edit(array $data){
		$db = $this->db;
		$db -> update('Education_policy', $data)
			-> where(['Education_policy'=> ['discipline' => $this->discipline]])
			-> run();
	  }

	public function __construct(public ?int $discipline = 0, public ?String $description = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}