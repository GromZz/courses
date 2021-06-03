<?php

namespace Model\Entities;

class Competency
{

	use \Library\Shared;
	use \Library\Entity;

	public static function search(?Int $discipline = 0, ?String $description = '', Int $limit = 0):self|array|null {
		$result = [];
		foreach (['discipline','description'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$competencies = $db -> select(['Competencies' => []]);
		if(!empty($filters))
			$competencies->where(['Competencies' => $filters]);
		foreach ($competencies->many($limit) as $competency) {
				$class = __CLASS__;
				$result[] = new $class($competency['discipline'], $competency['description']);
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}

	public static function loadCompetency(int $limit = 0): ?array {
		$result = [];
		$db = self::getDB();
		foreach ($db -> select([
			'Competencies' => []
		  ])->where([
			'Competencies' => []
		  ])->many($limit) as $competency) {
					$class = __CLASS__;
					$result[] = new $class($competency['discipline'], $competency['description']);
		  }
	
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;
	}

	public function edit(array $data){
		$db = $this->db;
		$db -> update('Competencies', $data)
			-> where(['Competencies'=> ['discipline' => $this->discipline]])
			-> run();
	  }

	public function __construct(public ?int $discipline = 0, public ?String $description = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}