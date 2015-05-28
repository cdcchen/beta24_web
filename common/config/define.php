<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-8-19
 * Time: 下午1:19
 */

define('YES', 1);
define('NO', 0);

/*
 * Commonly used pattern
 */

define('PATTERN_PHONE', '/^\d{11}$/');
define('PATTERN_LETTER_NUMBER_UNDERLINE', '/^[a-z_][0-9a-z_]+$/i');

/**
 * database table name define
 */

define('ONE_DAY_SECONDS', 86400);
define('ONE_WEEK_SECONDS', 604800);
define('REQUEST_TIME', $_SERVER['REQUEST_TIME']);


define('TBL_USER', '{{%user}}');
define('TBL_USER_CONFIG', '{{%user_config}}');
define('TBL_USER_PROFILE', '{{%user_profile}}');
define('TBL_CONFIG_GROUP', '{{%config_group}}');
define('TBL_CONFIG_ITEM', '{{%config_item}}');
define('TBL_USER_QUESTION', '{{%user_question}}');
define('TBL_QUESTION', '{{%question}}');
define('TBL_QUESTION_COMMENT', '{{%question_comment}}');
define('TBL_QUESTION_TAG', '{{%question_tag}}');
define('TBL_ANSWER', '{{%answer}}');
define('TBL_ANSWER_COMMENT', '{{%answer_comment}}');
define('TBL_ADVERT_SLOT', '{{%advert_slot}}');
define('TBL_ADVERT_DELIVERY', '{{%advert_delivery}}');
define('TBL_TAG', '{{%tag}}');
define('TBL_FRIEND_LINK', '{{%friend_link}}');
define('TBL_FEED_BACK', '{{%feed_back}}');


/**
 * channel define
 */

define('CHANNEL_QUESTION', 'question');
define('CHANNEL_TAG', 'tag');
define('CHANNEL_USER', 'user');
define('CHANNEL_BADGE', 'badge');
define('CHANNEL_UNANSWERED', 'unanswered');


/**
 * questions list sort define
 */

define('TAB_QUESTION_SORT_NEWEST', 'newest');
define('TAB_QUESTION_SORT_BOUNTY', 'bounty');
define('TAB_QUESTION_SORT_FREQUENT', 'frequent');
define('TAB_QUESTION_SORT_VOTES', 'votes');
define('TAB_QUESTION_SORT_ACTIVE', 'active');
define('TAB_QUESTION_SORT_UNANSWERED', 'unanswered');


/**
 * unanswered questions list sort define
 */

define('TAB_UNANSWERED_SORT_NEWEST', 'newest');
define('TAB_UNANSWERED_SORT_BOUNTY', 'bounty');
define('TAB_UNANSWERED_SORT_MY_TAGS', 'my_tags');
define('TAB_UNANSWERED_SORT_NO_UPVOTED', 'no_upvoted');
define('TAB_UNANSWERED_SORT_NO_ANSWERS', 'no_answers');


/**
 * answers list sort define
 */

define('TAB_ANSWER_SORT_ACTIVE', 'active');
define('TAB_ANSWER_SORT_OLDEST', 'oldest');
define('TAB_ANSWER_SORT_VOTES', 'votes');


/**
 * site home sub tab
 */

define('TAB_SITE_INTERESTING', 'my_tags');
define('TAB_SITE_FEATURED', 'featured');
define('TAB_SITE_HOT', 'hot');
define('TAB_SITE_WEEK', 'week');
define('TAB_SITE_MONTH', 'month');