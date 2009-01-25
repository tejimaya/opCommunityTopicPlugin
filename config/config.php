<?php
$this->dispatcher->connect('routing.load_configuration', array('opCommunityTopicPluginRouting', 'listenToRoutingLoadConfigurationEvent'));

sfPropelBehavior::registerMethods('community_is_creatable_community_topic', array(
  array('opIsCreatableCommunityTopicBehavior', 'isCreatableCommunityTopic'),
));
sfPropelBehavior::add('Community', array('community_is_creatable_community_topic' => array()));
