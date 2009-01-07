<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */



class CommunityTopicCommentMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.opTopicPlugin.lib.model.map.CommunityTopicCommentMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(CommunityTopicCommentPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CommunityTopicCommentPeer::TABLE_NAME);
		$tMap->setPhpName('CommunityTopicComment');
		$tMap->setClassname('CommunityTopicComment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('COMMUNITY_TOPIC_ID', 'CommunityTopicId', 'INTEGER', 'community_topic', 'ID', false, null);

		$tMap->addForeignKey('MEMBER_ID', 'MemberId', 'INTEGER', 'member', 'ID', false, null);

		$tMap->addColumn('BODY', 'Body', 'LONGVARCHAR', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} 
} 