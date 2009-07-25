<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * community topic/event actions.
 *
 * @package    OpenPNE
 * @subpackage communityTopic
 * @author     Yoichiro SAKURAI <saku2saku@gmail.com>
 */
class communityTopicActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('communitytopic', 'topicList');
  }

  /**
   * Executes topicList action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeTopicList(sfWebRequest $request)
  {
    $this->form = new CommunityTopicSearchForm();
    $this->form->bind($request->getParameter('communityTopic'), array());

    $this->pager = new sfDoctrinePager('CommunityTopic', 20);
    if ($request->hasParameter('communityTopic'))
    {
      $this->pager->setQuery($this->form->getQuery());
    }
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    return sfView::SUCCESS;
  }

  /**
   * Executes topicDelete action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeTopicDelete(sfWebRequest $request)
  {
    $this->topic = Doctrine::getTable('CommunityTopic')->retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->topic);

    if ($request->isMethod(sfRequest::POST))
    {
      $this->topic->delete();
      $this->getUser()->setFlash('notice', 'Topic Deleted successfully.');
      $this->redirect('communitytopic/topicList');
    }
    return sfView::SUCCESS;
  }

  /**
   * Executes topicCommentList action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeTopicCommentList(sfWebRequest $request)
  {
    $this->form = new CommunityTopicCommentSearchForm();
    $this->form->bind($request->getParameter('communityTopicComment'), array());

    $this->pager = new sfDoctrinePager('CommunityTopicComment', 20);
    if ($request->hasParameter('communityTopicComment'))
    {
      $parameter = $request->getParameter('communityTopicComment');
      $community_topic_id = $parameter['community_topic_id']['text'];
      $number = $parameter['number']['text'];
      $member_name = $parameter['member_name']['text'];
      $body = $parameter['body']['text'];
      $query = Doctrine_Query::create()->from('CommunityTopicComment c')->leftJoin('c.Member m');
      if (!empty($community_topic_id)) $query->andWhere('c.community_topic_id = ?', $community_topic_id);
      if (!empty($number)) $query->andWhere('c.number = ?', $number);
      if (!empty($member_name)) $query->andWhere('m.name LIKE ?', '%' . $member_name . '%');
      if (!empty($body)) $query->andWhere('c.body LIKE ?', '%' . $body . '%');
      $this->pager->setQuery($query);
    }
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    return sfView::SUCCESS;
  }

  /**
   * Executes topicCommentDelete action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeTopicCommentDelete(sfWebRequest $request)
  {
    $this->topicComment = Doctrine::getTable('CommunityTopicComment')->retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->topicComment);

    if ($request->isMethod(sfRequest::POST))
    {
      $this->topicComment->delete();
      $this->getUser()->setFlash('notice', 'Topic Comment Deleted successfully.');
      $this->redirect('communitytopic/topicCommentList');
    }
    return sfView::SUCCESS;
  }

  /**
   * Executes eventList action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeEventList(sfWebRequest $request)
  {
    $this->form = new CommunityEventSearchForm();
    $this->form->bind($request->getParameter('communityEvent'), array());

    $this->pager = new sfDoctrinePager('CommunityEvent', 20);
    if ($request->hasParameter('communityEvent'))
    {
      $this->pager->setQuery($this->form->getQuery());
    }
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    return sfView::SUCCESS;
  }

  /**
   * Executes eventDelete action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeEventDelete(sfWebRequest $request)
  {
    $this->event = Doctrine::getTable('CommunityEvent')->retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->event);

    if ($request->isMethod(sfRequest::POST))
    {
      $this->event->delete();
      $this->getUser()->setFlash('notice', 'Event Deleted successfully.');
      $this->redirect('communitytopic/eventList');
    }
    return sfView::SUCCESS;
  }

  /**
   * Executes eventCommentList action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeEventMemberList(sfWebRequest $request)
  {
    $this->form = new CommunityEventMemberSearchForm();
    $this->form->bind($request->getParameter('communityEventMember'), array());

    $this->pager = new sfDoctrinePager('CommunityEventMember', 20);
    if ($request->hasParameter('communityEventMember'))
    {
      $parameter = $request->getParameter('communityEventMember');
      $community_event_id = $parameter['community_event_id']['text'];
      $member_name = $parameter['member_name']['text'];
      $query = Doctrine_Query::create()->from('CommunityEventMember c')->leftJoin('c.Member m')->leftJoin('c.CommunityEvent ce');
      if (!empty($community_event_id)) $query->andWhere('c.community_event_id = ?', $community_event_id);
      if (!empty($member_name)) $query->andWhere('m.name LIKE ?', '%' . $member_name . '%');
      $this->pager->setQuery($query);
    }
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    return sfView::SUCCESS;
  }

  /**
   * Executes eventMemberDelete action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeEventMemberDelete(sfWebRequest $request)
  {
    $this->eventMember = Doctrine::getTable('CommunityEventMember')->retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->eventMember);

    if ($request->isMethod(sfRequest::POST))
    {
      $this->eventMember->delete();
      $this->getUser()->setFlash('notice', 'Event Member Deleted successfully.');
      $this->redirect('communitytopic/eventMemberList');
    }
    return sfView::SUCCESS;
  }

  /**
   * Executes eventCommentList action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeEventCommentList(sfWebRequest $request)
  {
    $this->form = new CommunityEventCommentSearchForm();
    $this->form->bind($request->getParameter('communityEventComment'), array());

    $this->pager = new sfDoctrinePager('CommunityEventComment', 20);
    if ($request->hasParameter('communityEventComment'))
    {
      $parameter = $request->getParameter('communityEventComment');
      $community_event_id = $parameter['community_event_id']['text'];
      $number = $parameter['number']['text'];
      $member_name = $parameter['member_name']['text'];
      $body = $parameter['body']['text'];
      $query = Doctrine_Query::create()->from('CommunityEventComment c')->leftJoin('c.Member m');
      if (!empty($community_event_id)) $query->andWhere('c.community_event_id = ?', $community_event_id);
      if (!empty($number)) $query->andWhere('c.number = ?', $number);
      if (!empty($member_name)) $query->andWhere('m.name LIKE ?', '%' . $member_name . '%');
      if (!empty($body)) $query->andWhere('c.body LIKE ?', '%' . $body . '%');
      $this->pager->setQuery($query);
    }
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    return sfView::SUCCESS;
  }

  /**
   * Executes eventCommentDelete action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeEventCommentDelete(sfWebRequest $request)
  {
    $this->eventComment = Doctrine::getTable('CommunityEventComment')->retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->eventComment);

    if ($request->isMethod(sfRequest::POST))
    {
      $this->eventComment->delete();
      $this->getUser()->setFlash('notice', 'Event Comment Deleted successfully.');
      $this->redirect('communitytopic/eventCommentList');
    }
    return sfView::SUCCESS;
  }
}
