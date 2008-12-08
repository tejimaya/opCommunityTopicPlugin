<?php


abstract class BaseCommunityTopicPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'community_topic';

	
	const CLASS_DEFAULT = 'plugins.opTopicPlugin.lib.model.CommunityTopic';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'community_topic.ID';

	
	const COMMUNITY_ID = 'community_topic.COMMUNITY_ID';

	
	const NAME = 'community_topic.NAME';

	
	const MEMBER_ID = 'community_topic.MEMBER_ID';

	
	const CREATED_AT = 'community_topic.CREATED_AT';

	
	const UPDATED_AT = 'community_topic.UPDATED_AT';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CommunityId', 'Name', 'MemberId', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'communityId', 'name', 'memberId', 'createdAt', 'updatedAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::COMMUNITY_ID, self::NAME, self::MEMBER_ID, self::CREATED_AT, self::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'community_id', 'name', 'member_id', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CommunityId' => 1, 'Name' => 2, 'MemberId' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'communityId' => 1, 'name' => 2, 'memberId' => 3, 'createdAt' => 4, 'updatedAt' => 5, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::COMMUNITY_ID => 1, self::NAME => 2, self::MEMBER_ID => 3, self::CREATED_AT => 4, self::UPDATED_AT => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'community_id' => 1, 'name' => 2, 'member_id' => 3, 'created_at' => 4, 'updated_at' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new CommunityTopicMapBuilder();
		}
		return self::$mapBuilder;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(CommunityTopicPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(CommunityTopicPeer::ID);

		$criteria->addSelectColumn(CommunityTopicPeer::COMMUNITY_ID);

		$criteria->addSelectColumn(CommunityTopicPeer::NAME);

		$criteria->addSelectColumn(CommunityTopicPeer::MEMBER_ID);

		$criteria->addSelectColumn(CommunityTopicPeer::CREATED_AT);

		$criteria->addSelectColumn(CommunityTopicPeer::UPDATED_AT);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}


    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


				$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}
	
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = CommunityTopicPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return CommunityTopicPeer::populateObjects(CommunityTopicPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			CommunityTopicPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(CommunityTopic $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} 			self::$instances[$key] = $obj;
		}
	}

	
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof CommunityTopic) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or CommunityTopic object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} 
	
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; 	}
	
	
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
				if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
	}

	
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
				$cls = CommunityTopicPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = CommunityTopicPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				CommunityTopicPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

	
	public static function doCountJoinCommunity(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(CommunityTopicPeer::COMMUNITY_ID,), array(CommunityPeer::ID,), $join_behavior);


    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinMember(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(CommunityTopicPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);


    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinCommunity(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doSelectJoin:doSelectJoin') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $c, $con);
    }


		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicPeer::addSelectColumns($c);
		$startcol = (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);
		CommunityPeer::addSelectColumns($c);

		$c->addJoin(array(CommunityTopicPeer::COMMUNITY_ID,), array(CommunityPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = CommunityTopicPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = CommunityPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = CommunityPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = CommunityPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					CommunityPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopic($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinMember(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicPeer::addSelectColumns($c);
		$startcol = (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);
		MemberPeer::addSelectColumns($c);

		$c->addJoin(array(CommunityTopicPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = CommunityTopicPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = MemberPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = MemberPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = MemberPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					MemberPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopic($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(CommunityTopicPeer::COMMUNITY_ID,), array(CommunityPeer::ID,), $join_behavior);
		$criteria->addJoin(array(CommunityTopicPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}

	
	public static function doSelectJoinAll(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doSelectJoinAll:doSelectJoinAll') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $c, $con);
    }


		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicPeer::addSelectColumns($c);
		$startcol2 = (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);

		CommunityPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (CommunityPeer::NUM_COLUMNS - CommunityPeer::NUM_LAZY_LOAD_COLUMNS);

		MemberPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(CommunityTopicPeer::COMMUNITY_ID,), array(CommunityPeer::ID,), $join_behavior);
		$c->addJoin(array(CommunityTopicPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = CommunityTopicPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicPeer::addInstanceToPool($obj1, $key1);
			} 
			
			$key2 = CommunityPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = CommunityPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = CommunityPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					CommunityPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopic($obj1);
			} 
			
			$key3 = MemberPeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = MemberPeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$omClass = MemberPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					MemberPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addCommunityTopic($obj1);
			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAllExceptCommunity(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(CommunityTopicPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptMember(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(CommunityTopicPeer::COMMUNITY_ID,), array(CommunityPeer::ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinAllExceptCommunity(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doSelectJoinAllExcept:doSelectJoinAllExcept') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $c, $con);
    }


		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicPeer::addSelectColumns($c);
		$startcol2 = (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(CommunityTopicPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = CommunityTopicPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = MemberPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = MemberPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = MemberPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					MemberPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopic($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptMember(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicPeer::addSelectColumns($c);
		$startcol2 = (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);

		CommunityPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (CommunityPeer::NUM_COLUMNS - CommunityPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(CommunityTopicPeer::COMMUNITY_ID,), array(CommunityPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = CommunityTopicPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = CommunityPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = CommunityPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = CommunityPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					CommunityPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopic($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


  static public function getUniqueColumnNames()
  {
    return array();
  }
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return CommunityTopicPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCommunityTopicPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(CommunityTopicPeer::ID) && $criteria->keyContainsValue(CommunityTopicPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.CommunityTopicPeer::ID.')');
		}


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCommunityTopicPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(CommunityTopicPeer::ID);
			$selectCriteria->add(CommunityTopicPeer::ID, $criteria->remove(CommunityTopicPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCommunityTopicPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(CommunityTopicPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												CommunityTopicPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof CommunityTopic) {
						CommunityTopicPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CommunityTopicPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								CommunityTopicPeer::removeInstanceFromPool($singleval);
			}
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	public static function doValidate(CommunityTopic $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CommunityTopicPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CommunityTopicPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(CommunityTopicPeer::DATABASE_NAME, CommunityTopicPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CommunityTopicPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = CommunityTopicPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);
		$criteria->add(CommunityTopicPeer::ID, $pk);

		$v = CommunityTopicPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);
			$criteria->add(CommunityTopicPeer::ID, $pks, Criteria::IN);
			$objs = CommunityTopicPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseCommunityTopicPeer::DATABASE_NAME)->addTableBuilder(BaseCommunityTopicPeer::TABLE_NAME, BaseCommunityTopicPeer::getMapBuilder());

