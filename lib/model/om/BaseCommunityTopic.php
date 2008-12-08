<?php


abstract class BaseCommunityTopic extends BaseObject  implements Persistent {


  const PEER = 'CommunityTopicPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $community_id;

	
	protected $name;

	
	protected $member_id;

	
	protected $created_at;

	
	protected $updated_at;

	
	protected $aCommunity;

	
	protected $aMember;

	
	protected $collCommunityTopicComments;

	
	private $lastCommunityTopicCommentCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
	}

	
	public function getId()
	{
		return $this->id;
	}

	
	public function getCommunityId()
	{
		return $this->community_id;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getMemberId()
	{
		return $this->member_id;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
						return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
						return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = CommunityTopicPeer::ID;
		}

		return $this;
	} 
	
	public function setCommunityId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->community_id !== $v) {
			$this->community_id = $v;
			$this->modifiedColumns[] = CommunityTopicPeer::COMMUNITY_ID;
		}

		if ($this->aCommunity !== null && $this->aCommunity->getId() !== $v) {
			$this->aCommunity = null;
		}

		return $this;
	} 
	
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = CommunityTopicPeer::NAME;
		}

		return $this;
	} 
	
	public function setMemberId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->member_id !== $v) {
			$this->member_id = $v;
			$this->modifiedColumns[] = CommunityTopicPeer::MEMBER_ID;
		}

		if ($this->aMember !== null && $this->aMember->getId() !== $v) {
			$this->aMember = null;
		}

		return $this;
	} 
	
	public function setCreatedAt($v)
	{
						if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
									try {
				if (is_numeric($v)) { 					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
															$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			
			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = CommunityTopicPeer::CREATED_AT;
			}
		} 
		return $this;
	} 
	
	public function setUpdatedAt($v)
	{
						if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
									try {
				if (is_numeric($v)) { 					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
															$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			
			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = CommunityTopicPeer::UPDATED_AT;
			}
		} 
		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array())) {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->community_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->member_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->created_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->updated_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating CommunityTopic object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aCommunity !== null && $this->community_id !== $this->aCommunity->getId()) {
			$this->aCommunity = null;
		}
		if ($this->aMember !== null && $this->member_id !== $this->aMember->getId()) {
			$this->aMember = null;
		}
	} 
	
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = CommunityTopicPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aCommunity = null;
			$this->aMember = null;
			$this->collCommunityTopicComments = null;
			$this->lastCommunityTopicCommentCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopic:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			CommunityTopicPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseCommunityTopic:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopic:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(CommunityTopicPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(CommunityTopicPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseCommunityTopic:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			CommunityTopicPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

												
			if ($this->aCommunity !== null) {
				if ($this->aCommunity->isModified() || $this->aCommunity->isNew()) {
					$affectedRows += $this->aCommunity->save($con);
				}
				$this->setCommunity($this->aCommunity);
			}

			if ($this->aMember !== null) {
				if ($this->aMember->isModified() || $this->aMember->isNew()) {
					$affectedRows += $this->aMember->save($con);
				}
				$this->setMember($this->aMember);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = CommunityTopicPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CommunityTopicPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CommunityTopicPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collCommunityTopicComments !== null) {
				foreach ($this->collCommunityTopicComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aCommunity !== null) {
				if (!$this->aCommunity->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCommunity->getValidationFailures());
				}
			}

			if ($this->aMember !== null) {
				if (!$this->aMember->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMember->getValidationFailures());
				}
			}


			if (($retval = CommunityTopicPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCommunityTopicComments !== null) {
					foreach ($this->collCommunityTopicComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CommunityTopicPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCommunityId();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getMemberId();
				break;
			case 4:
				return $this->getCreatedAt();
				break;
			case 5:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = CommunityTopicPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCommunityId(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getMemberId(),
			$keys[4] => $this->getCreatedAt(),
			$keys[5] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CommunityTopicPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCommunityId($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setMemberId($value);
				break;
			case 4:
				$this->setCreatedAt($value);
				break;
			case 5:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CommunityTopicPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCommunityId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMemberId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);

		if ($this->isColumnModified(CommunityTopicPeer::ID)) $criteria->add(CommunityTopicPeer::ID, $this->id);
		if ($this->isColumnModified(CommunityTopicPeer::COMMUNITY_ID)) $criteria->add(CommunityTopicPeer::COMMUNITY_ID, $this->community_id);
		if ($this->isColumnModified(CommunityTopicPeer::NAME)) $criteria->add(CommunityTopicPeer::NAME, $this->name);
		if ($this->isColumnModified(CommunityTopicPeer::MEMBER_ID)) $criteria->add(CommunityTopicPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(CommunityTopicPeer::CREATED_AT)) $criteria->add(CommunityTopicPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CommunityTopicPeer::UPDATED_AT)) $criteria->add(CommunityTopicPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);

		$criteria->add(CommunityTopicPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCommunityId($this->community_id);

		$copyObj->setName($this->name);

		$copyObj->setMemberId($this->member_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getCommunityTopicComments() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addCommunityTopicComment($relObj->copy($deepCopy));
				}
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CommunityTopicPeer();
		}
		return self::$peer;
	}

	
	public function setCommunity(Community $v = null)
	{
		if ($v === null) {
			$this->setCommunityId(NULL);
		} else {
			$this->setCommunityId($v->getId());
		}

		$this->aCommunity = $v;

						if ($v !== null) {
			$v->addCommunityTopic($this);
		}

		return $this;
	}


	
	public function getCommunity(PropelPDO $con = null)
	{
		if ($this->aCommunity === null && ($this->community_id !== null)) {
			$c = new Criteria(CommunityPeer::DATABASE_NAME);
			$c->add(CommunityPeer::ID, $this->community_id);
			$this->aCommunity = CommunityPeer::doSelectOne($c, $con);
			
		}
		return $this->aCommunity;
	}

	
	public function setMember(Member $v = null)
	{
		if ($v === null) {
			$this->setMemberId(NULL);
		} else {
			$this->setMemberId($v->getId());
		}

		$this->aMember = $v;

						if ($v !== null) {
			$v->addCommunityTopic($this);
		}

		return $this;
	}


	
	public function getMember(PropelPDO $con = null)
	{
		if ($this->aMember === null && ($this->member_id !== null)) {
			$c = new Criteria(MemberPeer::DATABASE_NAME);
			$c->add(MemberPeer::ID, $this->member_id);
			$this->aMember = MemberPeer::doSelectOne($c, $con);
			
		}
		return $this->aMember;
	}

	
	public function clearCommunityTopicComments()
	{
		$this->collCommunityTopicComments = null; 	}

	
	public function initCommunityTopicComments()
	{
		$this->collCommunityTopicComments = array();
	}

	
	public function getCommunityTopicComments($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCommunityTopicComments === null) {
			if ($this->isNew()) {
			   $this->collCommunityTopicComments = array();
			} else {

				$criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->id);

				CommunityTopicCommentPeer::addSelectColumns($criteria);
				$this->collCommunityTopicComments = CommunityTopicCommentPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->id);

				CommunityTopicCommentPeer::addSelectColumns($criteria);
				if (!isset($this->lastCommunityTopicCommentCriteria) || !$this->lastCommunityTopicCommentCriteria->equals($criteria)) {
					$this->collCommunityTopicComments = CommunityTopicCommentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCommunityTopicCommentCriteria = $criteria;
		return $this->collCommunityTopicComments;
	}

	
	public function countCommunityTopicComments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collCommunityTopicComments === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->id);

				$count = CommunityTopicCommentPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->id);

				if (!isset($this->lastCommunityTopicCommentCriteria) || !$this->lastCommunityTopicCommentCriteria->equals($criteria)) {
					$count = CommunityTopicCommentPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collCommunityTopicComments);
				}
			} else {
				$count = count($this->collCommunityTopicComments);
			}
		}
		$this->lastCommunityTopicCommentCriteria = $criteria;
		return $count;
	}

	
	public function addCommunityTopicComment(CommunityTopicComment $l)
	{
		if ($this->collCommunityTopicComments === null) {
			$this->initCommunityTopicComments();
		}
		if (!in_array($l, $this->collCommunityTopicComments, true)) { 			array_push($this->collCommunityTopicComments, $l);
			$l->setCommunityTopic($this);
		}
	}


	
	public function getCommunityTopicCommentsJoinMember($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CommunityTopicPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCommunityTopicComments === null) {
			if ($this->isNew()) {
				$this->collCommunityTopicComments = array();
			} else {

				$criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->id);

				$this->collCommunityTopicComments = CommunityTopicCommentPeer::doSelectJoinMember($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->id);

			if (!isset($this->lastCommunityTopicCommentCriteria) || !$this->lastCommunityTopicCommentCriteria->equals($criteria)) {
				$this->collCommunityTopicComments = CommunityTopicCommentPeer::doSelectJoinMember($criteria, $con, $join_behavior);
			}
		}
		$this->lastCommunityTopicCommentCriteria = $criteria;

		return $this->collCommunityTopicComments;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collCommunityTopicComments) {
				foreach ((array) $this->collCommunityTopicComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collCommunityTopicComments = null;
			$this->aCommunity = null;
			$this->aMember = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseCommunityTopic:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseCommunityTopic::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 