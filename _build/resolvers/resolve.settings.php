<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;
    /** @var array $options */
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('organizations.core_path', null,
                    $modx->getOption('core_path') . 'components/organizations/') . 'model/';
            $modx->addPackage('organizations', $modelPath);
            $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
			$modx->log(modX::LOG_LEVEL_INFO, 'Updated settings start');
			$val1 =array (
					  0 => 
					  array (
						'id' => 1,
						'name' => 'shortname',
						'label' => 'Имя организации',
						'rank' => '0',
						'xtype' => 'org-combo-dadata',
						'column' => '0',
						'active' => true,
					  ),
					  1 => 
					  array (
						'id' => 25,
						'name' => 'manager_id',
						'label' => 'Менеджер',
						'rank' => '1',
						'xtype' => 'manager-combo',
						'column' => '1',
						'active' => true,
					  ),
					  2 => 
					  array (
						'id' => 24,
						'name' => 'discount',
						'label' => 'Скидка',
						'rank' => 2,
						'xtype' => 'textfield',
						'column' => '1',
						'active' => true,
					  ),
					  3 => 
					  array (
						'id' => 26,
						'name' => 'active',
						'label' => 'Включена',
						'rank' => '3',
						'xtype' => 'xcheckbox',
						'active' => true,
						'column' => '1',
					  ),
					  4 => 
					  array (
						'id' => 2,
						'name' => 'longname',
						'label' => 'Полное имя',
						'rank' => '4',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => true,
					  ),
					  5 => 
					  array (
						'id' => 19,
						'name' => 'email',
						'label' => 'Электронная почта',
						'rank' => '7',
						'xtype' => 'email-combo-dadata',
						'column' => '1',
						'active' => false,
					  ),
					  6 => 
					  array (
						'id' => 20,
						'name' => 'site',
						'label' => 'Сайт',
						'rank' => '8',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  7 => 
					  array (
						'id' => 15,
						'name' => 'logotip',
						'label' => 'Логотип',
						'rank' => '9',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  8 => 
					  array (
						'id' => 23,
						'name' => 'fax',
						'label' => 'Факс',
						'rank' => '10',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  9 => 
					  array (
						'id' => 3,
						'name' => 'description',
						'label' => 'Описание',
						'rank' => '11',
						'xtype' => 'textarea',
						'column' => '1',
						'active' => false,
					  ),
					  10 => 
					  array (
						'id' => 22,
						'name' => 'phone_add',
						'label' => 'Доп. телефоны ',
						'rank' => '12',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  11 => 
					  array (
						'id' => 21,
						'name' => 'phone',
						'label' => 'Телефон',
						'rank' => '13',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  12 => 
					  array (
						'id' => 4,
						'name' => 'inn',
						'label' => 'ИНН',
						'rank' => '15',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  13 => 
					  array (
						'id' => 5,
						'name' => 'kpp',
						'label' => 'КПП',
						'rank' => '16',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  14 => 
					  array (
						'id' => 6,
						'name' => 'ogrn',
						'label' => 'ОГРН',
						'rank' => '16',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  15 => 
					  array (
						'id' => 7,
						'name' => 'okpo',
						'label' => 'ОКПО',
						'rank' => '17',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  16 => 
					  array (
						'id' => 8,
						'name' => 'ur_address',
						'label' => 'Юридический адрес',
						'rank' => '18',
						'xtype' => 'addr-combo-dadata',
						'column' => '2',
						'active' => true,
					  ),
					  17 => 
					  array (
						'id' => 9,
						'name' => 'postal_address',
						'label' => 'Почтовый адресс',
						'rank' => '19',
						'xtype' => 'addr-combo-dadata',
						'column' => '2',
						'active' => false,
					  ),
					  18 => 
					  array (
						'id' => 10,
						'name' => 'bank_name',
						'label' => 'Имя банка',
						'rank' => '23',
						'xtype' => 'bank-combo-dadata',
						'column' => '3',
						'active' => true,
					  ),
					  19 => 
					  array (
						'id' => 12,
						'name' => 'bank_sity',
						'label' => 'Город банка',
						'rank' => '24',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  20 => 
					  array (
						'id' => 11,
						'name' => 'bank_bik',
						'label' => 'БИК',
						'rank' => '25',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  21 => 
					  array (
						'id' => 13,
						'name' => 'bank_rasch_acc',
						'label' => 'Расчетный счет',
						'rank' => '26',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  22 => 
					  array (
						'id' => 14,
						'name' => 'bank_kor_acc',
						'label' => 'Кореспонд. счет',
						'rank' => '27',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  23 => 
					  array (
						'id' => 16,
						'name' => 'director',
						'label' => 'Директор',
						'rank' => '28',
						'xtype' => 'fio-combo-dadata',
						'column' => '2',
						'active' => true,
					  ),
					  24 => 
					  array (
						'id' => 17,
						'name' => 'glav_buh',
						'label' => 'Главный бухгалтер',
						'rank' => '29',
						'xtype' => 'fio-combo-dadata',
						'column' => '2',
						'active' => false,
					  ),
					  25 => 
					  array (
						'id' => 18,
						'name' => 'kontragent',
						'label' => 'Имя контрагента',
						'rank' => '30',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					);
			$val2 = array (
				  0 => 
				  array (
					'name' => 'edit_org_data',
					'label' => 'Редактирование данных организации',
					'id' => 7,
				  ),
				  1 => 
				  array (
					'name' => 'view_price',
					'label' => 'Просмотр цен в расчетах',
					'id' => 8,
				  ),
				  2 => 
				  array (
					'name' => 'order_send',
					'label' => 'Право на оформление и отправку заказов',
					'id' => 9,
				  ),
				  3 => 
				  array (
					'name' => 'order_view',
					'label' => 'Право на просмотр заказов',
					'id' => 10,
				  ),
				  4 => 
				  array (
					'name' => 'view_owner_raschet',
					'label' => 'Право на просмотр и редактирование собственных расчетов',
					'id' => 11,
				  ),
				  5 => 
				  array (
					'name' => 'view_all_raschet',
					'label' => 'Право на просмотр и редактирование всех расчетов',
					'id' => 12,
				  ),
				  6 => 
				  array (
					'name' => 'raschet_new',
					'label' => 'Создание нового расчета',
					'id' => 13,
				  ),
				  7 => 
				  array (
					'name' => 'list_org_users',
					'label' => 'Права на просмотр списка пользователей',
					'id' => 14,
				  ),
				);
				
            $configs = array(
                '2' => array(
                    //'name' => !$lang ? 'Новый' : 'New',
                    'setting' => 'org_fields',
					'value' => json_encode($val1),
					'xtype' => 'array',
                ),
				'3' => array(
                    'setting' => 'org_access',
					'value' => json_encode($val2),
					'xtype' => 'array',
                ),
            );
            foreach ($configs as $id => $properties) {
                if (!$config = $modx->getCount('OrgsConfig', array('id' => $id))) {
                    $config = $modx->newObject('OrgsConfig', $properties);
                    $config->set('id', $id);
                    $config->save();
					$modx->log(modX::LOG_LEVEL_INFO, 'Updated OrgsConfig "<b>' . $id . '</b>"');
                }
            }
			$groups = array (
				1 => array (
						  'name' => 'Администраторы',
						  'description' => '',
						  'data' => '{"edit_org_data":true,"view_price":true,"order_send":true,"order_view":true,"view_owner_raschet":true,"view_all_raschet":true,"raschet_new":true,"list_org_users":true}',
						),
				3 => array (
						  'name' => 'Менеджеры',
						  'description' => '',
						  'data' => '{"view_price":true,"order_send":true,"order_view":true,"view_owner_raschet":true,"view_all_raschet":true,"raschet_new":true}',
						),
				4 => array (
						  'name' => 'Инженеры',
						  'description' => '',
						  'data' => '{"view_owner_raschet":true,"raschet_new":true}',
						)
			);
			foreach ($groups as $id => $properties) {
                if (!$config = $modx->getCount('OrgsUsersGroups', array('id' => $id))) {
                    $config = $modx->newObject('OrgsUsersGroups', $properties);
                    $config->set('id', $id);
                    $config->save();
					$modx->log(modX::LOG_LEVEL_INFO, 'Updated OrgsUsersGroups "<b>' . $id . '</b>"');
                }
            }
			$modx->log(modX::LOG_LEVEL_INFO, 'Updated settings end');
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;