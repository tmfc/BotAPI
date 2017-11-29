<?php namespace api\base;

use yii\base\Event;
use api\method\getMe;
use api\method\getFile;
use api\method\getChat;
use api\method\sendGame;
use api\method\leaveChat;
use api\method\sendAudio;
use api\method\sendPhoto;
use api\method\sendVenue;
use api\method\sendVideo;
use api\method\sendVoice;
use api\method\setWebhook;
use api\method\getUpdates;
use api\method\sendContact;
use api\method\sendInvoice;
use api\method\sendMessage;
use api\method\sendSticker;
use api\method\sendDocument;
use api\method\setChatPhoto;
use api\method\setChatTitle;
use api\method\sendLocation;
use api\method\setGameScore;
use api\method\deleteMessage;
use api\method\deleteWebhook;
use api\method\sendVideoNote;
use api\method\getStickerSet;
use api\method\getChatMember;
use api\method\sendMediaGroup;
use api\method\forwardMessage;
use api\method\pinChatMessage;
use api\method\getWebhookInfo;
use api\method\kickChatMember;
use api\method\sendChatAction;
use api\method\addStickerToSet;
use api\method\deleteChatPhoto;
use api\method\editMessageText;
use api\method\unbanChatMember;
use api\method\unpinChatMessage;
use api\method\uploadStickerFile;
use api\method\promoteChatMember;
use api\method\answerInlineQuery;
use api\method\getGameHighScores;
use api\method\editMessageCaption;
use api\method\restrictChatMember;
use api\method\setChatDescription;
use api\method\createNewStickerSet;
use api\method\getChatMembersCount;
use api\method\answerCallbackQuery;
use api\method\answerShippingQuery;
use api\method\deleteStickerFromSet;
use api\method\exportChatInviteLink;
use api\method\getUserProfilePhotos;
use api\method\getChatAdministrators;
use api\method\editMessageReplyMarkup;
use api\method\answerPreCheckoutQuery;
use api\method\setStickerPositionInSet;
use api\method\editMessageLiveLocation;
use api\method\stopMessageLiveLocation;

/**
 * Class API
 * @package api\base
 * @link https://core.telegram.org/bots/api
 *
 * @author Mehdi Khodayari <khodayari.khoram@gmail.com>
 * @since 3.5.3
 */
class API extends Object
{

    const VERSION = '3.5.3';
    const EVENT_AFTER_SEND = 'AfterSend';
    const EVENT_BEFORE_SEND = 'BeforeSend';
    const EVENT_REQUEST_FAILED = 'RequestFailed';
    const EVENT_REQUEST_SUCCEED = 'RequestSucceed';

    /**
     * @param string $name
     * @param Event $event
     */
    public static function trigger($name, $event = null)
    {
        $class = self::className();
        Event::trigger($class, $name, $event);
    }

    /**
     * @param string $name
     * @param callable $handler
     */
    public static function off($name, $handler = null)
    {
        $class = self::className();
        Event::off($class, $name, $handler);
    }

    /**
     * @param string $name
     * @param callable $handler
     * @param mixed $data
     * @param bool $append
     */
    public static function on($name, $handler, $data = null, $append = true)
    {
        $class = self::className();
        Event::on($class, $name, $handler, $data, $append);
    }

    /**
     * @var Token
     */
    protected $token;

    /**
     * Request constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        if (!($token instanceof Token)) {
            $this->token = new Token($token);
        }

        parent::__construct();
    }

    /**
     * getUpdates
     * Use this method to receive incoming updates using long polling (wiki).
     * An Array of Update objects is returned.
     *
     * Notes:
     * 1. This method will not work if an outgoing webhook is set up.
     * 2. In order to avoid getting duplicate updates,
     *    recalculate offset after each server response.
     *
     * @see https://core.telegram.org/bots/api#getupdates
     * @param array $params
     * @return getUpdates
     */
    public function getUpdates($params = [])
    {
        return new getUpdates($this->token, $params);
    }

    /**
     * setWebhook
     * Use this method to specify a url and receive incoming updates via
     * an outgoing webhook. Whenever there is an update for the bot,
     * we will send an HTTPS POST request to the specified url,
     * containing a JSON-serialized Update.
     *
     * In case of an unsuccessful request,
     * we will give up after a reasonable amount of attempts.
     * Returns true.
     *
     * If you'd like to make sure that the Webhook request comes from Telegram,
     * we recommend using a secret path in the URL, e.g. https://www.example.com/<token>.
     * Since nobody else knows your bot‘s token,
     * you can be pretty sure it’s us.
     *
     * Notes
     * 1. You will not be able to receive updates using getUpdates for as
     *    long as an outgoing webhook is set up.
     * 2. To use a self-signed certificate, you need to upload your public key
     *    certificate using certificate parameter. Please upload as InputFile,
     *    sending a String will not work.
     * 3. Ports currently supported for Webhooks: 443, 80, 88, 8443.
     *
     * NEW! If you're having any trouble setting up webhooks,
     * please check out this amazing guide to Webhooks.
     *
     * @see https://core.telegram.org/bots/api#setwebhook
     * @param array $params
     * @return setWebhook
     */
    public function setWebhook($params = [])
    {
        return new setWebhook($this->token, $params);
    }

    /**
     * deleteWebhook
     * Use this method to remove webhook integration if
     * you decide to switch back to getUpdates.
     * Returns True on success.
     * Requires no parameters.
     *
     * @see https://core.telegram.org/bots/api#deletewebhook
     * @return deleteWebhook
     */
    public function deleteWebhook()
    {
        return new deleteWebhook($this->token);
    }

    /**
     * getWebhookInfo
     * Use this method to get current webhook status. Requires no parameters.
     * On success, returns a WebhookInfo object. If the bot is using getUpdates,
     * will return an object with the url field empty.
     *
     * @see https://core.telegram.org/bots/api#getwebhookinfo
     * @return getWebhookInfo
     */
    public function getWebhookInfo()
    {
        return new getWebhookInfo($this->token);
    }

    /**
     * getMe
     * A simple method for testing your bot's auth token. Requires no parameters.
     * Returns basic information about the bot in
     * form of a User object.
     *
     * @see https://core.telegram.org/bots/api#getme
     * @return getMe
     */
    public function getMe()
    {
        return new getMe($this->token);
    }

    /**
     * sendMessage
     * Use this method to send text messages. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendmessage
     * @param array $params
     * @return sendMessage
     */
    public function sendMessage($params = [])
    {
        return new sendMessage($this->token, $params);
    }

    /**
     * forwardMessage
     * Use this method to forward messages of any kind. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#forwardmessage
     * @param array $params
     * @return forwardMessage
     */
    public function forwardMessage($params = [])
    {
        return new forwardMessage($this->token, $params);
    }

    /**
     * sendPhoto
     * Use this method to send photos. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendphoto
     * @param array $params
     * @return sendPhoto
     */
    public function sendPhoto($params = [])
    {
        return new sendPhoto($this->token, $params);
    }

    /**
     * sendAudio
     * Use this method to send audio files, if you want Telegram clients to display them in the music player. Y
     * our audio must be in the .mp3 format. On success, the sent Message is returned.
     * Bots can currently send audio files of up to 50 MB in size,
     * this limit may be changed in the future.
     *
     * For sending voice messages,
     * use the sendVoice method instead.
     *
     * @see https://core.telegram.org/bots/api#sendaudio
     * @param array $params
     * @return sendAudio
     */
    public function sendAudio($params = [])
    {
        return new sendAudio($this->token, $params);
    }

    /**
     * sendDocument
     * Use this method to send general files. On success, the sent Message is returned.
     * Bots can currently send files of any type of up to 50 MB in size,
     * this limit may be changed in the future.
     *
     * @see https://core.telegram.org/bots/api#senddocument
     * @param array $params
     * @return sendDocument
     */
    public function sendDocument($params = [])
    {
        return new sendDocument($this->token, $params);
    }

    /**
     * sendVideo
     * Use this method to send video files, Telegram clients support mp4 videos
     * (other formats may be sent as Document). On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size,
     * this limit may be changed in the future.
     *
     * @see https://core.telegram.org/bots/api#sendvideo
     * @param array $params
     * @return sendVideo
     */
    public function sendVideo($params = [])
    {
        return new sendVideo($this->token, $params);
    }

    /**
     * sendVoice
     * Use this method to send audio files, if you want Telegram clients to display the file
     * as a playable voice message. For this to work, your audio must be in
     * an .ogg file encoded with OPUS (other formats may be sent as Audio or Document).
     * On success, the sent Message is returned. Bots can currently send voice messages
     * of up to 50 MB in size, this limit may be
     * changed in the future.
     *
     * @see https://core.telegram.org/bots/api#sendvoice
     * @param array $params
     * @return sendVoice
     */
    public function sendVoice($params = [])
    {
        return new sendVoice($this->token, $params);
    }

    /**
     * sendVideoNote
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendvideonote
     * @param array $params
     * @return sendVideoNote
     */
    public function sendVideoNote($params = [])
    {
        return new sendVideoNote($this->token, $params);
    }

    /**
     * sendMediaGroup
     * Use this method to send a group of photos or videos as an album.
     * On success, an array of the sent Messages is returned.
     *
     * @see https://core.telegram.org/bots/api#sendmediagroup
     * @param array $params
     * @return sendMediaGroup
     */
    public function sendMediaGroup($params = [])
    {
        return new sendMediaGroup($this->token, $params);
    }
    
    /**
     * sendLocation
     * Use this method to send point on the map. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendlocation
     * @param array $params
     * @return sendLocation
     */
    public function sendLocation($params = [])
    {
        return new sendLocation($this->token, $params);
    }

    /**
     * editMessageLiveLocation
     * Use this method to edit live location messages sent by the bot
     * or via the bot (for inline bots).
     *
     * A location can be edited until its live_period expires or
     * editing is explicitly disabled by a call to stopMessageLiveLocation.
     *
     * On success, if the edited message was sent by the bot, the edited
     * Message is returned, otherwise True is returned.
     *
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     * @param array $params
     * @return editMessageLiveLocation
     */
    public function editMessageLiveLocation($params = [])
    {
        return new editMessageLiveLocation($this->token, $params);
    }

    /**
     * stopMessageLiveLocation
     * Use this method to stop updating a live location message sent
     * by the bot or via the bot (for inline bots) before live_period expires.
     *
     * On success, if the message was sent by the bot, the sent Message is returned,
     * otherwise True is returned.
     *
     * @see https://core.telegram.org/bots/api#stopmessagelivelocation
     * @param array $params
     * @return stopMessageLiveLocation
     */
    public function stopMessageLiveLocation($params = [])
    {
        return new stopMessageLiveLocation($this->token, $params);
    }

    /**
     * sendVenue
     * Use this method to send information about a venue. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendvenue
     * @param array $params
     * @return sendVenue
     */
    public function sendVenue($params = [])
    {
        return new sendVenue($this->token, $params);
    }

    /**
     * sendContact
     * Use this method to send phone contacts. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendcontact
     * @param array $params
     * @return sendContact
     */
    public function sendContact($params = [])
    {
        return new sendContact($this->token, $params);
    }

    /**
     * sendChatAction
     * Use this method when you need to tell the user that something is happening
     * on the bot's side. The status is set for 5 seconds or less
     * (when a message arrives from your bot, Telegram clients clear
     * its typing status). Returns True on success.
     *
     * Example:
     * The ImageBot needs some time to process a request and upload the image.
     * Instead of sending a text message along the lines of “Retrieving image,
     * please wait…”, the bot may use sendChatAction with action = upload_photo.
     * The user will see a “sending photo” status for the bot.
     *
     * We only recommend using this method when a response from the
     * bot will take a noticeable amount of time to arrive.
     *
     * @see https://core.telegram.org/bots/api#sendchataction
     * @param array $params
     * @return sendChatAction
     */
    public function sendChatAction($params = [])
    {
        return new sendChatAction($this->token, $params);
    }

    /**
     * getUserProfilePhotos
     * Use this method to get a list of profile pictures for a user.
     * Returns a UserProfilePhotos object.
     *
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
     * @param array $params
     * @return getUserProfilePhotos
     */
    public function getUserProfilePhotos($params = [])
    {
        return new getUserProfilePhotos($this->token, $params);
    }

    /**
     * getFile
     * Use this method to get basic info about a file and prepare it for downloading.
     * For the moment, bots can download files of up to 20MB in size. On success,
     * a File object is returned. The file can then be downloaded via the link
     * https://api.telegram.org/file/bot<token>/<file_path>, where <file_path>
     * is taken from the response. It is guaranteed that the link will be
     * valid for at least 1 hour. When the link expires,
     * a new one can be requested by calling getFile again.
     *
     * Note:
     * This function may not preserve the original file name and MIME type.
     * You should save the file's MIME type and name (if available) when
     * the File object is received.
     *
     * @see https://core.telegram.org/bots/api#getfile
     * @param array $params
     * @return getFile
     */
    public function getFile($params = [])
    {
        return new getFile($this->token, $params);
    }

    /**
     * kickChatMember
     * Use this method to kick a user from a group, a supergroup or a channel.
     * In the case of supergroups and channels, the user will not be able to return
     * to the group on their own using invite links, etc., unless unbanned first.
     * The bot must be an administrator in the chat for this to work and must
     * have the appropriate admin rights.
     * Returns True on success.
     *
     * Note:
     * In regular groups (non-supergroups), this method will only work if the ‘All Members Are Admins’
     * setting is off in the target group. Otherwise members may only be removed by the group's
     * creator or by the member that added them.
     *
     * @see https://core.telegram.org/bots/api#kickchatmember
     * @param array $params
     * @return kickChatMember
     */
    public function kickChatMember($params = [])
    {
        return new kickChatMember($this->token, $params);
    }

    /**
     * unbanChatMember
     * Use this method to unban a previously kicked user in a supergroup or channel.
     * The user will not return to the group or channel automatically,
     * but will be able to join via link, etc.
     * The bot must be an administrator for this to work.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#unbanchatmember
     * @param array $params
     * @return unbanChatMember
     */
    public function unbanChatMember($params = [])
    {
        return new unbanChatMember($this->token, $params);
    }

    /**
     * restrictChatMember
     * Use this method to restrict a user in a supergroup.
     * The bot must be an administrator in the supergroup for this to work and must have
     * the appropriate admin rights. Pass True for all boolean parameters
     * to lift restrictions from a user.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#restrictchatmember
     * @param array $params
     * @return restrictChatMember
     */
    public function restrictChatMember($params = [])
    {
        return new restrictChatMember($this->token, $params);
    }

    /**
     * promoteChatMember
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have
     * the appropriate admin rights. Pass False for all boolean parameters to demote a user.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#promotechatmember
     * @param array $params
     * @return promoteChatMember
     */
    public function promoteChatMember($params = [])
    {
        return new promoteChatMember($this->token, $params);
    }

    /**
     * exportChatInviteLink
     * Use this method to export an invite link to a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the
     * appropriate admin rights. Returns exported invite
     * link as String on success.
     *
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     * @param array $params
     * @return exportChatInviteLink
     */
    public function exportChatInviteLink($params = [])
    {
        return new exportChatInviteLink($this->token, $params);
    }

    /**
     * setChatPhoto
     * Use this method to set a new profile photo for the chat.
     * Photos can't be changed for private chats. The bot must be an administrator in
     * the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * Note:
     * In regular groups (non-supergroups), this method will only work if the ‘All Members
     * Are Admins’ setting is off in the target group.
     *
     * @see https://core.telegram.org/bots/api#setchatphoto
     * @param array $params
     * @return setChatPhoto
     */
    public function setChatPhoto($params = [])
    {
        return new setChatPhoto($this->token, $params);
    }

    /**
     * deleteChatPhoto
     * Use this method to delete a chat photo. Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have
     * the appropriate admin rights.
     * Returns True on success.
     *
     * Note:
     * In regular groups (non-supergroups), this method will only work if the ‘All Members Are Admins’
     * setting is off in the target group.
     *
     * @see https://core.telegram.org/bots/api#deletechatphoto
     * @param array $params
     * @return deleteChatPhoto
     */
    public function deleteChatPhoto($params = [])
    {
        return new deleteChatPhoto($this->token, $params);
    }

    /**
     * setChatTitle
     * Use this method to change the title of a chat. Titles can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have
     * the appropriate admin rights.
     * Returns True on success.
     *
     * Note:
     * In regular groups (non-supergroups), this method will only work if the ‘All Members
     * Are Admins’ setting is off in the target group.
     *
     * @see https://core.telegram.org/bots/api#setchattitle
     * @param array $params
     * @return setChatTitle
     */
    public function setChatTitle($params = [])
    {
        return new setChatTitle($this->token, $params);
    }

    /**
     * setChatDescription
     * Use this method to change the description of a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have
     * the appropriate admin rights.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#setchatdescription
     * @param array $params
     * @return setChatDescription
     */
    public function setChatDescription($params = [])
    {
        return new setChatDescription($this->token, $params);
    }

    /**
     * pinChatMessage
     * Use this method to pin a message in a supergroup. The bot must be an administrator
     * in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#pinchatmessage
     * @param array $params
     * @return pinChatMessage
     */
    public function pinChatMessage($params = [])
    {
        return new pinChatMessage($this->token, $params);
    }

    /**
     * unpinChatMessage
     * Use this method to unpin a message in a supergroup chat. The bot must be an
     * administrator in the chat for this to work and must have the appropriate
     * admin rights. Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     * @param array $params
     * @return unpinChatMessage
     */
    public function unpinChatMessage($params = [])
    {
        return new unpinChatMessage($this->token, $params);
    }

    /**
     * leaveChat
     * Use this method for your bot to leave a group, supergroup
     * or channel. Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#leavechat
     * @param array $params
     * @return leaveChat
     */
    public function leaveChat($params = [])
    {
        return new leaveChat($this->token, $params);
    }

    /**
     * getChat
     * Use this method to get up to date information about the chat (current name of
     * the user for one-on-one conversations, current username of a user, group or channel, etc.).
     * Returns a Chat object on success.
     *
     * @see https://core.telegram.org/bots/api#getchat
     * @param array $params
     * @return getChat
     */
    public function getChat($params = [])
    {
        return new getChat($this->token, $params);
    }

    /**
     * getChatAdministrators
     * Use this method to get a list of administrators in a chat. On success,
     * returns an Array of ChatMember objects that contains information about
     * all chat administrators except other bots. If the chat is a group or
     * a supergroup and no administrators were appointed,
     * only the creator will be returned.
     *
     * @see https://core.telegram.org/bots/api#getchatadministrators
     * @param array $params
     * @return getChatAdministrators
     */
    public function getChatAdministrators($params = [])
    {
        return new getChatAdministrators($this->token, $params);
    }

    /**
     * getChatMembersCount
     * Use this method to get the number of members in a chat.
     * Returns Int on success.
     *
     * @see https://core.telegram.org/bots/api#getchatmemberscount
     * @param array $params
     * @return getChatMembersCount
     */
    public function getChatMembersCount($params = [])
    {
        return new getChatMembersCount($this->token, $params);
    }

    /**
     * getChatMember
     * Use this method to get information about a member of a chat.
     * Returns a ChatMember object on success.
     *
     * @see https://core.telegram.org/bots/api#getchatmember
     * @param array $params
     * @return getChatMember
     */
    public function getChatMember($params = [])
    {
        return new getChatMember($this->token, $params);
    }

    /**
     * answerCallbackQuery
     * Use this method to send answers to callback queries sent from inline keyboards.
     * The answer will be displayed to the user as a notification at the top of the
     * chat screen or as an alert. On success,
     * True is returned.
     *
     * Alternatively, the user can be redirected to the specified Game URL.
     * For this option to work, you must first create a game for your bot via
     * BotFather and accept the terms. Otherwise, you may use links like
     * t.me/your_bot?start=XXXX that open your bot with a parameter.
     *
     * @see https://core.telegram.org/bots/api#answercallbackquery
     * @param array $params
     * @return answerCallbackQuery
     */
    public function answerCallbackQuery($params = [])
    {
        return new answerCallbackQuery($this->token, $params);
    }

    /**
     * editMessageText
     * Use this method to edit text and game messages sent by the bot or via the bot
     * (for inline bots). On success, if edited message is sent by the bot, the edited
     * Message is returned, otherwise True is returned.
     *
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param array $params
     * @return editMessageText
     */
    public function editMessageText($params = [])
    {
        return new editMessageText($this->token, $params);
    }

    /**
     * editMessageCaption
     * Use this method to edit captions of messages sent by the bot or via the bot (for inline bots).
     * On success, if edited message is sent by the bot, the edited Message
     * is returned, otherwise True is returned.
     *
     * @see https://core.telegram.org/bots/api#editmessagecaption
     * @param array $params
     * @return editMessageCaption
     */
    public function editMessageCaption($params = [])
    {
        return new editMessageCaption($this->token, $params);
    }

    /**
     * editMessageReplyMarkup
     * Use this method to edit only the reply markup of messages sent by the bot or
     * via the bot (for inline bots). On success, if edited message is sent by the bot,
     * the edited Message is returned,
     * otherwise True is returned.
     *
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param array $params
     * @return editMessageReplyMarkup
     */
    public function editMessageReplyMarkup($params = [])
    {
        return new editMessageReplyMarkup($this->token, $params);
    }

    /**
     * deleteMessage
     * Use this method to delete a message, including service messages, with the following limitations:
     * - A message can only be deleted if it was sent less than 48 hours ago.
     * - Bots can delete outgoing messages in groups and supergroups.
     * - Bots granted can_post_messages permissions can delete outgoing messages in channels.
     * - If the bot is an administrator of a group, it can delete any message there.
     * - If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#deletemessage
     * @param array $params
     * @return deleteMessage
     */
    public function deleteMessage($params = [])
    {
        return new deleteMessage($this->token, $params);
    }

    /**
     * sendSticker
     * Use this method to send .webp stickers. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendsticker
     * @param array $params
     * @return sendSticker
     */
    public function sendSticker($params = [])
    {
        return new sendSticker($this->token, $params);
    }

    /**
     * getStickerSet
     * Use this method to get a sticker set. On success,
     * a StickerSet object is returned.
     *
     * @see https://core.telegram.org/bots/api#getstickerset
     * @param array $params
     * @return getStickerSet
     */
    public function getStickerSet($params = [])
    {
        return new getStickerSet($this->token, $params);
    }

    /**
     * uploadStickerFile
     * Use this method to upload a .png file with a sticker for later use in createNewStickerSet
     * and addStickerToSet methods (can be used multiple times).
     * Returns the uploaded File on success.
     *
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     * @param array $params
     * @return uploadStickerFile
     */
    public function uploadStickerFile($params = [])
    {
        return new uploadStickerFile($this->token, $params);
    }

    /**
     * createNewStickerSet
     * Use this method to create new sticker set owned by a user.
     * The bot will be able to edit the created sticker set.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param array $params
     * @return createNewStickerSet
     */
    public function createNewStickerSet($params = [])
    {
        return new createNewStickerSet($this->token, $params);
    }

    /**
     * addStickerToSet
     * Use this method to add a new sticker to a set created by the bot.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param array $params
     * @return addStickerToSet
     */
    public function addStickerToSet($params = [])
    {
        return new addStickerToSet($this->token, $params);
    }

    /**
     * setStickerPositionInSet
     * Use this method to move a sticker in a set created by the bot to a specific position .
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     * @param array $params
     * @return setStickerPositionInSet
     */
    public function setStickerPositionInSet($params = [])
    {
        return new setStickerPositionInSet($this->token, $params);
    }

    /**
     * deleteStickerFromSet
     * Use this method to delete a sticker from a set created by the bot.
     * Returns True on success.
     *
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     * @param array $params
     * @return deleteStickerFromSet
     */
    public function deleteStickerFromSet($params = [])
    {
        return new deleteStickerFromSet($this->token, $params);
    }

    /**
     * answerInlineQuery
     * Use this method to send answers to an inline query.
     * On success, True is returned.
     *
     * No more than 50 results per query are allowed.
     *
     * @see https://core.telegram.org/bots/api#answerinlinequery
     * @param array $params
     * @return answerInlineQuery
     */
    public function answerInlineQuery($params = [])
    {
        return new answerInlineQuery($this->token, $params);
    }

    /**
     * sendInvoice
     * Use this method to send invoices. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendinvoice
     * @param array $params
     * @return sendInvoice
     */
    public function sendInvoice($params = [])
    {
        return new sendInvoice($this->token, $params);
    }

    /**
     * answerShippingQuery
     * If you sent an invoice requesting a shipping address and the parameter is_flexible
     * was specified, the Bot API will send an Update with a shipping_query field to the bot.
     * Use this method to reply to shipping queries.
     * On success, True is returned.
     *
     * @see https://core.telegram.org/bots/api#answershippingquery
     * @param array $params
     * @return answerShippingQuery
     */
    public function answerShippingQuery($params = [])
    {
        return new answerShippingQuery($this->token, $params);
    }

    /**
     * answerPreCheckoutQuery
     * Once the user has confirmed their payment and shipping details,
     * the Bot API sends the final confirmation in the form of an Update with the
     * field pre_checkout_query. Use this method to respond to such pre-checkout queries.
     * On success, True is returned. Note: The Bot API must receive an answer within 10
     * seconds after the pre-checkout query was sent.
     *
     * @see https://core.telegram.org/bots/api#answerprecheckoutquery
     * @param array $params
     * @return answerPreCheckoutQuery
     */
    public function answerPreCheckoutQuery($params = [])
    {
        return new answerPreCheckoutQuery($this->token, $params);
    }

    /**
     * sendGame
     * Use this method to send a game. On success,
     * the sent Message is returned.
     *
     * @see https://core.telegram.org/bots/api#sendgame
     * @param array $params
     * @return sendGame
     */
    public function sendGame($params = [])
    {
        return new sendGame($this->token, $params);
    }

    /**
     * setGameScore
     * Use this method to set the score of the specified user in a game. On success,
     * if the message was sent by the bot, returns the edited Message, otherwise returns True.
     * Returns an error, if the new score is not greater than the user's current score
     * in the chat and force is False.
     *
     * @see https://core.telegram.org/bots/api#setgamescore
     * @param array $params
     * @return setGameScore
     */
    public function setGameScore($params = [])
    {
        return new setGameScore($this->token, $params);
    }

    /**
     * getGameHighScores
     * Use this method to get data for high score tables. Will return the score of the specified
     * user and several of his neighbors in a game. On success,
     * returns an Array of GameHighScore objects.
     *
     * This method will currently return scores for the target user,
     * plus two of his closest neighbors on each side. Will also return the top
     * three users if the user and his neighbors are not among them.
     * Please note that this behavior is subject to change.
     *
     * @see https://core.telegram.org/bots/api#getgamehighscores
     * @param array $params
     * @return getGameHighScores
     */
    public function getGameHighScores($params = [])
    {
        return new getGameHighScores($this->token, $params);
    }
}