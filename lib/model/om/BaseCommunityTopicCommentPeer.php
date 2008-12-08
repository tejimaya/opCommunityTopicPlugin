<?php


abstract class BaseCommunityTopicCommentPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'community_topic_comment';

	
	const CLASS_DEFAULT = 'plugins.opTopicPlugin.lib.model.CommunityTopicComment';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'community_topic_comment.ID';

	
	const COMMUNITY_TOPIC_ID = 'community_topic_comment.COMMUNITY_TOPIC_ID';

	
	const MEMBER_ID = 'community_topic_comment.MEMBER_ID';

	
	const BODY = 'community_topic_comment.BODY';

	
	const CREATED_AT = 'community_topic_comment.CREATED_AT';

	
	const UPDATED_AT = 'community_topic_comment.UPDATED_AT';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CommunityTopicId', 'MemberId', 'Body', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'communityTopicId', 'memberId', 'body', 'createdAt', 'updatedAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::COMMUNITY_TOPIC_ID, self::MEMBER_ID, self::BODY, self::CREATED_AT, self::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'community_topic_id', 'member_id', 'body', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CommunityTopicId' => 1, 'MemberId' => 2, 'Body' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'communityTopicId' => 1, 'memberId' => 2, 'body' => 3, 'createdAt' => 4, 'updatedAt' => 5, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::COMMUNITY_TOPIC_ID => 1, self::MEMBER_ID => 2, self::BODY => 3, self::CREATED_AT => 4, self::UPDATED_AT => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'community_topic_id' => 1, 'member_id' => 2, 'body' => 3, 'created_at' => 4, 'updated_at' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new CommunityTopicCommentMapBuilder();
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
		return str_replace(CommunityTopicCommentPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(CommunityTopicCommentPeer::ID);

		$criteria->addSelectColumn(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID);

		$criteria->addSelectColumn(CommunityTopicCommentPeer::MEMBER_ID);

		$criteria->addSelectColumn(CommunityTopicCommentPeer::BODY);

		$criteria->addSelectColumn(CommunityTopicCommentPeer::CREATED_AT);

		$criteria->addSelectColumn(CommunityTopicCommentPeer::UPDATED_AT);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicCommentPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}


    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
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
		$objects = CommunityTopicCommentPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return CommunityTopicCommentPeer::populateObjects(CommunityTopicCommentPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(CommunityTopicComment $obj, $key = null)
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
			if (is_object($value) && $value instanceof CommunityTopicComment) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or CommunityTopicComment object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	
				$cls = CommunityTopicCommentPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = CommunityTopicCommentPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = CommunityTopicCommentPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				CommunityTopicCommentPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

	
	public static function doCountJoinCommunityTopic(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicCommentPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID,), array(CommunityTopicPeer::ID,), $join_behavior);


    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
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

								$criteria->setPrimaryTableName(CommunityTopicCommentPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(CommunityTopicCommentPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);


    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinCommunityTopic(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doSelectJoin:doSelectJoin') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $c, $con);
    }


		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicCommentPeer::addSelectColumns($c);
		$startcol = (CommunityTopicCommentPeer::NUM_COLUMNS - CommunityTopicCommentPeer::NUM_LAZY_LOAD_COLUMNS);
		CommunityTopicPeer::addSelectColumns($c);

		$c->addJoin(array(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID,), array(CommunityTopicPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicCommentPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicCommentPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = CommunityTopicCommentPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicCommentPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = CommunityTopicPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = CommunityTopicPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					CommunityTopicPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopicComment($obj1);

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

		CommunityTopicCommentPeer::addSelectColumns($c);
		$startcol = (CommunityTopicCommentPeer::NUM_COLUMNS - CommunityTopicCommentPeer::NUM_LAZY_LOAD_COLUMNS);
		MemberPeer::addSelectColumns($c);

		$c->addJoin(array(CommunityTopicCommentPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicCommentPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicCommentPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = CommunityTopicCommentPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicCommentPeer::addInstanceToPool($obj1, $key1);
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
								$obj2->addCommunityTopicComment($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CommunityTopicCommentPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID,), array(CommunityTopicPeer::ID,), $join_behavior);
		$criteria->addJoin(array(CommunityTopicCommentPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
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

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doSelectJoinAll:doSelectJoinAll') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $c, $con);
    }


		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicCommentPeer::addSelectColumns($c);
		$startcol2 = (CommunityTopicCommentPeer::NUM_COLUMNS - CommunityTopicCommentPeer::NUM_LAZY_LOAD_COLUMNS);

		CommunityTopicPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);

		MemberPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID,), array(CommunityTopicPeer::ID,), $join_behavior);
		$c->addJoin(array(CommunityTopicCommentPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicCommentPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicCommentPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = CommunityTopicCommentPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicCommentPeer::addInstanceToPool($obj1, $key1);
			} 
			
			$key2 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = CommunityTopicPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = CommunityTopicPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					CommunityTopicPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopicComment($obj1);
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
								$obj3->addCommunityTopicComment($obj1);
			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAllExceptCommunityTopic(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(CommunityTopicCommentPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
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
			CommunityTopicCommentPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID,), array(CommunityTopicPeer::ID,), $join_behavior);

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doCount:doCount') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $criteria, $con);
    }


		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinAllExceptCommunityTopic(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doSelectJoinAllExcept:doSelectJoinAllExcept') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $c, $con);
    }


		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		CommunityTopicCommentPeer::addSelectColumns($c);
		$startcol2 = (CommunityTopicCommentPeer::NUM_COLUMNS - CommunityTopicCommentPeer::NUM_LAZY_LOAD_COLUMNS);

		MemberPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (MemberPeer::NUM_COLUMNS - MemberPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(CommunityTopicCommentPeer::MEMBER_ID,), array(MemberPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicCommentPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicCommentPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = CommunityTopicCommentPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicCommentPeer::addInstanceToPool($obj1, $key1);
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
								$obj2->addCommunityTopicComment($obj1);

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

		CommunityTopicCommentPeer::addSelectColumns($c);
		$startcol2 = (CommunityTopicCommentPeer::NUM_COLUMNS - CommunityTopicCommentPeer::NUM_LAZY_LOAD_COLUMNS);

		CommunityTopicPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (CommunityTopicPeer::NUM_COLUMNS - CommunityTopicPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID,), array(CommunityTopicPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = CommunityTopicCommentPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = CommunityTopicCommentPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = CommunityTopicCommentPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				CommunityTopicCommentPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = CommunityTopicPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = CommunityTopicPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = CommunityTopicPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					CommunityTopicPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addCommunityTopicComment($obj1);

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
		return CommunityTopicCommentPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCommunityTopicCommentPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(CommunityTopicCommentPeer::ID) && $criteria->keyContainsValue(CommunityTopicCommentPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.CommunityTopicCommentPeer::ID.')');
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

		
    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCommunityTopicCommentPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(CommunityTopicCommentPeer::ID);
			$selectCriteria->add(CommunityTopicCommentPeer::ID, $criteria->remove(CommunityTopicCommentPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCommunityTopicCommentPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCommunityTopicCommentPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(CommunityTopicCommentPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												CommunityTopicCommentPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof CommunityTopicComment) {
						CommunityTopicCommentPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CommunityTopicCommentPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								CommunityTopicCommentPeer::removeInstanceFromPool($singleval);
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

	
	public static function doValidate(CommunityTopicComment $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CommunityTopicCommentPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CommunityTopicCommentPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(CommunityTopicCommentPeer::DATABASE_NAME, CommunityTopicCommentPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CommunityTopicCommentPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = CommunityTopicCommentPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(CommunityTopicCommentPeer::DATABASE_NAME);
		$criteria->add(CommunityTopicCommentPeer::ID, $pk);

		$v = CommunityTopicCommentPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(CommunityTopicCommentPeer::DATABASE_NAME);
			$criteria->add(CommunityTopicCommentPeer::ID, $pks, Criteria::IN);
			$objs = CommunityTopicCommentPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseCommunityTopicCommentPeer::DATABASE_NAME)->addTableBuilder(BaseCommunityTopicCommentPeer::TABLE_NAME, BaseCommunityTopicCommentPeer::getMapBuilder());

