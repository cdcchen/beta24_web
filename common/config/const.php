<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-8-19
 * Time: 下午1:19
 */

const YES = 1;
const NO = 0;

const UM_FRONTEND = 'frontend';
const UM_BACKEND = 'backend';

/*
 * Commonly used pattern
 */

const PATTERN_PHONE = '/^\d{11}$/';
const PATTERN_LETTER_NUMBER_UNDERLINE = '/^[a-z_][0-9a-z_]+$/i';

/**
 * database table name define
 */

const ONE_DAY_SECONDS = 86400;
const ONE_WEEK_SECONDS = 604800;

const TBL_USER = '{{%user}}';
const TBL_USER_CONFIG = '{{%user_config}}';
const TBL_USER_PROFILE = '{{%user_profile}}';
const TBL_CONFIG_GROUP = '{{%config_group}}';
const TBL_CONFIG_ITEM = '{{%config_item}}';
const TBL_USER_QUESTION = '{{%user_question}}';
const TBL_QUESTION = '{{%question}}';
const TBL_QUESTION_COMMENT = '{{%question_comment}}';
const TBL_QUESTION_TAG = '{{%question_tag}}';
const TBL_ANSWER = '{{%answer}}';
const TBL_ANSWER_COMMENT = '{{%answer_comment}}';
const TBL_ADVERT_SLOT = '{{%advert_slot}}';
const TBL_ADVERT_DELIVERY = '{{%advert_delivery}}';
const TBL_TAG = '{{%tag}}';
const TBL_FRIEND_LINK = '{{%friend_link}}';
const TBL_FEED_BACK = '{{%feed_back}}';


/**
 * channel define
 */

const CHANNEL_QUESTION = 'question';
const CHANNEL_TAG = 'tag';
const CHANNEL_USER = 'user';
const CHANNEL_BADGE = 'badge';
const CHANNEL_UNANSWERED = 'unanswered';


/**
 * questions list sort define
 */

const TAB_QUESTION_SORT_NEWEST = 'newest';
const TAB_QUESTION_SORT_BOUNTY = 'bounty';
const TAB_QUESTION_SORT_FREQUENT = 'frequent';
const TAB_QUESTION_SORT_VOTES = 'votes';
const TAB_QUESTION_SORT_ACTIVE = 'active';
const TAB_QUESTION_SORT_UNANSWERED = 'unanswered';


/**
 * unanswered questions list sort define
 */

const TAB_UNANSWERED_SORT_NEWEST = 'newest';
const TAB_UNANSWERED_SORT_BOUNTY = 'bounty';
const TAB_UNANSWERED_SORT_MY_TAGS = 'my_tags';
const TAB_UNANSWERED_SORT_NO_UPVOTED = 'no_upvoted';
const TAB_UNANSWERED_SORT_NO_ANSWERS = 'no_answers';


/**
 * answers list sort define
 */

const TAB_ANSWER_SORT_ACTIVE = 'active';
const TAB_ANSWER_SORT_OLDEST = 'oldest';
const TAB_ANSWER_SORT_VOTES = 'votes';


/**
 * site home sub tab
 */

const TAB_SITE_INTERESTING = 'my_tags';
const TAB_SITE_FEATURED = 'featured';
const TAB_SITE_HOT = 'hot';
const TAB_SITE_WEEK = 'week';
const TAB_SITE_MONTH = 'month';