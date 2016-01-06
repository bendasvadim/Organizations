<?php

/**
 * Get a list of Orgs
 */
class OrgsGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'Orgs';
	public $classKey = 'Orgs';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
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
		if ($query) {
			$c->where(array(
				'name:LIKE' => "%{$query}%",
				'OR:description:LIKE' => "%{$query}%",
			));
		}

		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		$array['actions'] = array();

		// Edit
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-edit',
			'title' => $this->modx->lexicon('organizations_org_update'),
			//'multiple' => $this->modx->lexicon('organizations_orgs_update'),
			'action' => 'updateOrg',
			'button' => true,
			'menu' => true,
		);
		
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-user',
			'title' => $this->modx->lexicon('organizations_org_users'),
			//'multiple' => $this->modx->lexicon('organizations_orgs_update'),
			'action' => 'updateUsers',
			'button' => true,
			'menu' => true,
		);
		
		if (!$array['active']) {
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-power-off action-green',
				'title' => $this->modx->lexicon('organizations_org_enable'),
				'multiple' => $this->modx->lexicon('organizations_orgs_enable'),
				'action' => 'enableOrg',
				'button' => true,
				'menu' => true,
			);
		}
		
		else {
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-power-off action-gray',
				'title' => $this->modx->lexicon('organizations_org_disable'),
				'multiple' => $this->modx->lexicon('organizations_orgs_disable'),
				'action' => 'disableOrg',
				'button' => true,
				'menu' => true,
			);
		}

		// Remove
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-trash-o action-red',
			'title' => $this->modx->lexicon('organizations_org_remove'),
			'multiple' => $this->modx->lexicon('organizations_orgs_remove'),
			'action' => 'removeOrg',
			'button' => true,
			'menu' => true,
		);

		return $array;
	}

}

return 'OrgsGetListProcessor';