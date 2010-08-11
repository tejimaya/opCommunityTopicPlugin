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
    $this->forward('communityTopic', 'topicList');
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
    $this->topic = Doctrine::getTable('CommunityTopic')->find($request->getParameter('id'));
    $this->forward404Unless($this->topic);

    if ($request->isMethod(sfRequest::POST))
    {
      $request->checkCSRFProtection();
      $this->topic->delete();
      $this->getUser()->setFlash('notice', 'Topic Deleted successfully.');
      $this->redirect('communityTopic/topicList');
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
      $this->pager->setQuery($this->form->getQuery());
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
    $this->topicComment = Doctrine::getTable('CommunityTopicComment')->find($request->getParameter('id'));
    $this->forward404Unless($this->topicComment);

    if ($request->isMethod(sfRequest::POST))
    {
      $request->checkCSRFProtection();
      $this->topicComment->delete();
      $this->getUser()->setFlash('notice', 'Topic Comment Deleted successfully.');
      $this->redirect('communityTopic/topicCommentList');
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
    $this->event = Doctrine::getTable('CommunityEvent')->find($request->getParameter('id'));
    $this->forward404Unless($this->event);

    if ($request->isMethod(sfRequest::POST))
    {
      $request->checkCSRFProtection();
      $this->event->delete();
      $this->getUser()->setFlash('notice', 'Event Deleted successfully.');
      $this->redirect('communityTopic/eventList');
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
      $this->pager->setQuery($this->form->getQuery());
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
    $this->eventMember = Doctrine::getTable('CommunityEventMember')->find($request->getParameter('id'));
    $this->forward404Unless($this->eventMember);

    if ($request->isMethod(sfRequest::POST))
    {
      $request->checkCSRFProtection();
      $this->eventMember->delete();
      $this->getUser()->setFlash('notice', 'Event Member Deleted successfully.');
      $this->redirect('communityTopic/eventMemberList');
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
      $this->pager->setQuery($this->form->getQuery());
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
    $this->eventComment = Doctrine::getTable('CommunityEventComment')->find($request->getParameter('id'));
    $this->forward404Unless($this->eventComment);

    if ($request->isMethod(sfRequest::POST))
    {
      $request->checkCSRFProtection();
      $this->eventComment->delete();
      $this->getUser()->setFlash('notice', 'Event Comment Deleted successfully.');
      $this->redirect('communityTopic/eventCommentList');
    }
    return sfView::SUCCESS;
  }
}
