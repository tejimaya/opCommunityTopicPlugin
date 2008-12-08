<?php


abstract class BaseCommunityTopicComment extends BaseObject  implements Persistent {


  const PEER = 'CommunityTopicCommentPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $community_topic_id;

	
	protected $member_id;

	
	protected $body;

	
	protected $created_at;

	
	protected $updated_at;

	
	protected $aCommunityTopic;

	
	protected $aMember;

	
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

	
	public function getCommunityTopicId()
	{
		return $this->community_topic_id;
	}

	
	public function getMemberId()
	{
		return $this->member_id;
	}

	
	public function getBody()
	{
		return $this->body;
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
			$this->modifiedColumns[] = CommunityTopicCommentPeer::ID;
		}

		return $this;
	} 
	
	public function setCommunityTopicId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->community_topic_id !== $v) {
			$this->community_topic_id = $v;
			$this->modifiedColumns[] = CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID;
		}

		if ($this->aCommunityTopic !== null && $this->aCommunityTopic->getId() !== $v) {
			$this->aCommunityTopic = null;
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
			$this->modifiedColumns[] = CommunityTopicCommentPeer::MEMBER_ID;
		}

		if ($this->aMember !== null && $this->aMember->getId() !== $v) {
			$this->aMember = null;
		}

		return $this;
	} 
	
	public function setBody($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = CommunityTopicCommentPeer::BODY;
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
				$this->modifiedColumns[] = CommunityTopicCommentPeer::CREATED_AT;
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
				$this->modifiedColumns[] = CommunityTopicCommentPeer::UPDATED_AT;
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
			$this->community_topic_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->member_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->body = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->created_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->updated_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating CommunityTopicComment object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aCommunityTopic !== null && $this->community_topic_id !== $this->aCommunityTopic->getId()) {
			$this->aCommunityTopic = null;
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
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = CommunityTopicCommentPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aCommunityTopic = null;
			$this->aMember = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicComment:delete:pre') as $callable)
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
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			CommunityTopicCommentPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseCommunityTopicComment:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityTopicComment:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(CommunityTopicCommentPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(CommunityTopicCommentPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityTopicCommentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseCommunityTopicComment:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			CommunityTopicCommentPeer::addInstanceToPool($this);
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

												
			if ($this->aCommunityTopic !== null) {
				if ($this->aCommunityTopic->isModified() || $this->aCommunityTopic->isNew()) {
					$affectedRows += $this->aCommunityTopic->save($con);
				}
				$this->setCommunityTopic($this->aCommunityTopic);
			}

			if ($this->aMember !== null) {
				if ($this->aMember->isModified() || $this->aMember->isNew()) {
					$affectedRows += $this->aMember->save($con);
				}
				$this->setMember($this->aMember);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = CommunityTopicCommentPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CommunityTopicCommentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CommunityTopicCommentPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

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


												
			if ($this->aCommunityTopic !== null) {
				if (!$this->aCommunityTopic->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCommunityTopic->getValidationFailures());
				}
			}

			if ($this->aMember !== null) {
				if (!$this->aMember->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMember->getValidationFailures());
				}
			}


			if (($retval = CommunityTopicCommentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CommunityTopicCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCommunityTopicId();
				break;
			case 2:
				return $this->getMemberId();
				break;
			case 3:
				return $this->getBody();
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
		$keys = CommunityTopicCommentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCommunityTopicId(),
			$keys[2] => $this->getMemberId(),
			$keys[3] => $this->getBody(),
			$keys[4] => $this->getCreatedAt(),
			$keys[5] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CommunityTopicCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCommunityTopicId($value);
				break;
			case 2:
				$this->setMemberId($value);
				break;
			case 3:
				$this->setBody($value);
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
		$keys = CommunityTopicCommentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCommunityTopicId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMemberId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setBody($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CommunityTopicCommentPeer::DATABASE_NAME);

		if ($this->isColumnModified(CommunityTopicCommentPeer::ID)) $criteria->add(CommunityTopicCommentPeer::ID, $this->id);
		if ($this->isColumnModified(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID)) $criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $this->community_topic_id);
		if ($this->isColumnModified(CommunityTopicCommentPeer::MEMBER_ID)) $criteria->add(CommunityTopicCommentPeer::MEMBER_ID, $this->member_id);
		if ($this->isColumnModified(CommunityTopicCommentPeer::BODY)) $criteria->add(CommunityTopicCommentPeer::BODY, $this->body);
		if ($this->isColumnModified(CommunityTopicCommentPeer::CREATED_AT)) $criteria->add(CommunityTopicCommentPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CommunityTopicCommentPeer::UPDATED_AT)) $criteria->add(CommunityTopicCommentPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CommunityTopicCommentPeer::DATABASE_NAME);

		$criteria->add(CommunityTopicCommentPeer::ID, $this->id);

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

		$copyObj->setCommunityTopicId($this->community_topic_id);

		$copyObj->setMemberId($this->member_id);

		$copyObj->setBody($this->body);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


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
			self::$peer = new CommunityTopicCommentPeer();
		}
		return self::$peer;
	}

	
	public function setCommunityTopic(CommunityTopic $v = null)
	{
		if ($v === null) {
			$this->setCommunityTopicId(NULL);
		} else {
			$this->setCommunityTopicId($v->getId());
		}

		$this->aCommunityTopic = $v;

						if ($v !== null) {
			$v->addCommunityTopicComment($this);
		}

		return $this;
	}


	
	public function getCommunityTopic(PropelPDO $con = null)
	{
		if ($this->aCommunityTopic === null && ($this->community_topic_id !== null)) {
			$c = new Criteria(CommunityTopicPeer::DATABASE_NAME);
			$c->add(CommunityTopicPeer::ID, $this->community_topic_id);
			$this->aCommunityTopic = CommunityTopicPeer::doSelectOne($c, $con);
			
		}
		return $this->aCommunityTopic;
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
			$v->addCommunityTopicComment($this);
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

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->aCommunityTopic = null;
			$this->aMember = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseCommunityTopicComment:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseCommunityTopicComment::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 