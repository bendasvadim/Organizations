<?php

/**
 * Get a combo of Users
 */
class UsersComboProcessor extends modObjectGetListProcessor {
	public $objectType = 'modUser';
	public $classKey = 'modUser';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'ASC';
	//public $permission = 'list';


	/**
	 * * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return boolean|string
	 */
	public function beforeQuery() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}
		return true;
	}


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$query = trim($this->getProperty('query'));
		$c->leftJoin('modUserProfile','modUserProfile', '`'.$this->classKey.'`.`id` = `modUserProfile`.`internalKey`');
		$c->select('`modUser`.`id`, `modUser`.`username`, `modUserProfile`.`fullname` as `fullname`');
		if ($query) {
			$c->where(array(
				'`modUser`.`username`:LIKE' => "%{$query}%",
				'OR:`modUserProfile`.`fullname`:LIKE' => "%{$query}%",
			));
		}
		/* $c->prepare();
		echo $c->toSql();
		die; */
		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		$user = array(
			'id' => $array['id'],
			'search' => $array['username'].' '.$array['fullname'],
			'username' => $array['username']
		);
		
		return $user;
	}

}

return 'UsersComboProcessor';