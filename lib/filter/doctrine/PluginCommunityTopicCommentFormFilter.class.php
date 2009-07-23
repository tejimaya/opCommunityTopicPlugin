<?php

/**
 * PluginCommunityTopicComment form.
 *
 * @package    filters
 * @subpackage CommunityTopicComment *
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginCommunityTopicCommentFormFilter extends BaseCommunityTopicCommentFormFilter
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    return parent::__construct($defaults, $options, false);
  }
}