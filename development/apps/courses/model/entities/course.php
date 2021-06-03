<?php

namespace Model\Entities;

class Course
{

	use \Library\Shared;
	use \Library\Entity;


	public function save():self {
		$db = $this->db;
		$db -> insert([
			'Courses' => [ 
				'title' => $this->title, 
				'goal' => $this->goal, 
				'control' => $this->control, 
				'teacher' => $this->teacher, 
				'department' => $this->department, 
				'retake' => $this->retake, 
				'ects' => $this->ects,
				'semester' => $this->semester,
				'hours' => $this->hours ]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('Courses', $this->_changed )
				-> where(['Courses'=> ['id' => $this->id]])
				-> run();

		$course = $db -> select(['Courses' => []])->where(['Courses'=> ['title' => $this->title]])->one();
		$this->id = $course['id'];
		//Competency
		$db -> insert([
			'Competencies' => [ 
				'discipline' => $this->id,
				'description' => $this->competency]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('Competencies', $this->_changed )
				-> where(['Competencies'=> ['discipline' => $this->id]])
				-> run();
				
		//Education policy
		$db -> insert([
			'Education_policy' => [ 
				'discipline' => $this->id,
				'description' => $this->policy]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('Education_policy', $this->_changed )
				-> where(['Education_policy'=> ['discipline' => $this->id]])
				-> run();

		//Results
		$db -> insert([
			'Results' => [ 
				'discipline' => $this->id,
				'description' => $this->res]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('Results', $this->_changed )
				-> where(['Results'=> ['discipline' => $this->id]])
				-> run();

		//RoadMap
		$db -> insert([
			'RoadMap' => [ 
				'discipline' => $this->id,
				'description' => $this->map]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('RoadMap', $this->_changed )
				-> where(['RoadMap'=> ['discipline' => $this->id]])
				-> run();

		return $this;
	}

	public static function search(?Int $id = 0, ?String $title = '', ?String $teacher = '', ?String $control = '', ?int $semester = 0, Int $limit = 0):self|array|null {
		$result = [];
		$c = new Competency();
		$competencies = $c->loadCompetency();
		$p = new Policy();
		$policies = $p->loadPolicy();
		$r = new Result();
		$results = $r->loadResult();
		$m = new Map();
		$maps = $m->loadMap();
		foreach (['id', 'title','teacher', 'control', 'semester'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$courses = $db -> select(['Courses' => []]);
		if(!empty($filters))
			$courses->where(['Courses' => $filters]);
		foreach ($courses->many($limit) as $course) {
				$class = __CLASS__;
				$competency = '';
				$policy = '';
				$res = '';
				$map = '';
				//Для кометенцій
				foreach($competencies as $key => $value) {
					if($value->discipline == $course['id']) {
					  $competency = $value->description;
					}
				}
				//Для політики навчання
				foreach($policies as $key => $value) {
					if($value->discipline == $course['id']) {
					  $policy = $value->description;
					}
				}
				//Для результатів навчання
				foreach($results as $key => $value) {
					if($value->discipline == $course['id']) {
					  $res = $value->description;
					}
				}
				//Для "дорожної карти"
				foreach($maps as $key => $value) {
					if($value->discipline == $course['id']) {
					  $map = $value->description;
					}
				}
		$result[] = new $class($course['id'], $course['title'], $course['teacher'], $course['goal'], $course['control'], $course['department'], $course['retake'], $course['ects'], $course['semester'], $course['hours'], $competency, $policy, $res, $map);
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}

	public function delete() {
		$db = $this->db;
			$db -> delete('Eduaction_policy')
			-> where(['Eduaction_policy'=> ['discipline' => $this->id]])
			-> run();
			$db -> delete('Competecies')
			-> where(['Competecies'=> ['discipline' => $this->id]])
			-> run();
			$db -> delete('Results')
			-> where(['Results'=> ['discipline' => $this->id]])
			-> run();
			$db -> delete('RoadMap')
			-> where(['RoadMap'=> ['discipline' => $this->id]])
			-> run();
			$db -> delete('Software')
			-> where(['Software'=> ['discipline' => $this->id]])
			-> run();
			$db -> delete('Work')
			-> where(['Work'=> ['discipline' => $this->id]])
			-> run();
			$db -> delete('Courses')
			-> where(['Courses'=> ['id' => $this->id]])
			-> run();
	}

	public function edit(array $data){
		$db = $this->db;
		$db -> update('Courses', $data)
			-> where(['Courses'=> ['id' => $this->id]])
			-> run();
	  }

	public function __construct(public ?int $id = 0, public ?String $title = '', public ?String $teacher = '', public ?String $goal = '', public ?String $control = '', public ?String $department = '', public ?String $retake = '', public ?float $ects = 0, public ?int $semester = 0, public ?int $hours = 0, public ?String $competency = '', public ?String $policy = '', public ?String $res = '', public ?String $map = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}