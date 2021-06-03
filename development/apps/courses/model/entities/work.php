<?php

namespace Model\Entities;

class Work
{

	use \Library\Shared;
	use \Library\Entity;

	public function save():self {
		$db = $this->db;
		$db -> insert([
			'Work' => [
				'discipline' => $this->discipline,
				'type' => $this->type,
				'title' => $this->title,
                'goal' => $this->goal,
				'mark' => $this->mark,
                'week' => $this->week,
                'criteria' => $this->criteria]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('Work', $this->_changed )
				-> where(['Work'=> ['id' => $this->id]])
				-> run();
		return $this;
	}

	public static function search(?int $id = 0, ?Int $discipline = 0, ?String $title = '', ?String $type = '', ?int $week = 0, Int $limit = 0):self|array|null {
		$result = [];
		foreach (['id', 'discipline', 'title', 'type', 'week'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$works = $db -> select(['Work' => []]);
		if(!empty($filters))
			$works->where(['Work' => $filters]);
		foreach ($works->many($limit) as $work) {
				$class = __CLASS__;
				$result[] = new $class($work['id'], $work['discipline'], $work['type'], $work['title'], $work['goal'], $work['mark'], $work['week'], $work['criteria']);
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}


	public function delete() {
		$db = $this->db;
			$db -> delete('Work')
			-> where(['Work'=> ['id' => $this->id]])
			-> run();
	}

	public function edit(array $data){
		$db = $this->db;
		$db -> update('Work', $data)
			-> where(['Work'=> ['id' => $this->id]])
			-> run();
	  }

	public function __construct(public ?int $id = 0, public ?int $discipline = 0, public ?String $type = '', public ?String $title = '', public ?String $goal = '', public ?int $mark = 0, public ?int $week = 0, public ?String $criteria = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}