<?php

namespace luya\admin\models;

use Yii;
use yii\web\IdentityInterface;

use luya\admin\aws\ChangePasswordInterface;
use luya\admin\Module;
use luya\admin\traits\SoftDeleteTrait;
use yii\helpers\Json;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\aws\ChangePasswordActiveWindow;

/**
 * User Model represents all Administration Users.
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property integer $title
 * @property string $email
 * @property string $password
 * @property string $password_salt
 * @property string $auth_token
 * @property integer $is_deleted
 * @property string $secure_token
 * @property integer $secure_token_timestamp
 * @property integer $force_reload
 * @property string $settings
 * @property \luya\admin\models\UserSetting $setting Setting object to store data.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class User extends NgRestModel implements IdentityInterface, ChangePasswordInterface
{
    const USER_SETTING_ISDEVELOPER = 'isDeveloper';
    
    const USER_SETTING_UILANGUAGE = 'luyadminlanguage';
    
    use SoftDeleteTrait;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'eventBeforeValidate']);
    }
    
    private $_setting;
    
    public function getSetting()
    {
        if ($this->_setting === null) {
            $settingsArray = (empty($this->settings)) ? [] : Json::decode($this->settings);
            $this->_setting = Yii::createObject(['class' => UserSetting::className(), 'sender' => $this, 'data' => $settingsArray]);
        }
        
        return $this->_setting;
    }
    
    public function getLastloginTimestamp()
    {
        $item = UserLogin::find()->select(['timestamp_create'])->where(['user_id' => $this->id])->orderBy('id DESC')->asArray()->one();
    
        if ($item) {
            return $item['timestamp_create'];
        }
    }
    
    public function updateSettings(array $data)
    {
        $this->updateAttributes([
            'settings' => Json::encode($data),
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-admin-user';
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestListOrder()
    {
        return ['firstname' => SORT_ASC];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'title' => ['selectArray', 'data' => static::getTitles(), 'initValue' => 0],
            'firstname' => 'text',
            'lastname' => 'text',
            'email' => 'text',
            'password' => 'password',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestFilters()
    {
        return [
            'Removed' => self::find()->where(['is_deleted' => true]),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function ngRestExtraAttributeTypes()
    {
        return [
            'lastloginTimestamp' => 'datetime',
        ];
    }
    
    public function ngRestScopes()
    {
        return [
            ['list', ['firstname', 'lastname', 'email', 'lastloginTimestamp']],
            ['create', ['title', 'firstname', 'lastname', 'email', 'password']],
            ['update', ['title', 'firstname', 'lastname', 'email']],
            ['delete', true],
        ];
    }
    
    public function ngRestActiveWindows()
    {
        return [
            ['class' => ChangePasswordActiveWindow::class],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['firstname', 'lastname', 'email'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'firstname', 'lastname', 'email', 'password'], 'required', 'on' => 'restcreate'],
            [['title', 'firstname', 'lastname', 'email'], 'required', 'on' => 'restupdate'],
            [['email', 'password'], 'required', 'on' => 'login'],
            [['secure_token'], 'required', 'on' => 'securelayer'],
            [['title', 'firstname', 'lastname', 'email', 'password'], 'required', 'on' => 'default'],
            [['email'], 'email'],
            [['email'], 'unique', 'on' => ['restcreate', 'restupdate']],
            [['settings'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Module::t('mode_user_title'),
            'firstname' => Module::t('mode_user_firstname'),
            'lastname' => Module::t('mode_user_lastname'),
            'email' => Module::t('mode_user_email'),
            'password' => Module::t('mode_user_password'),
            'lastloginTimestamp' => Module::t('model_user_lastlogintimestamp'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'firstname', 'lastname', 'email', 'password'],
            'restupdate' => ['title', 'firstname', 'lastname', 'email'],
            'changepassword' => ['password', 'password_salt'],
            'login' => ['email', 'password', 'force_reload'],
            'securelayer' => ['secure_token'],
            'default' => ['title', 'firstname', 'lastname', 'email', 'password', 'force_reload', 'settings'],
        ];
    }

    /**
     * Method which is called ON_BFORE_CREATE event.
     */
    public function beforeCreate()
    {
        $this->auth_token = '';
        $this->is_deleted = false;
    }

    /**
     * Method which is called ON_BEFORE_VALIDATE
     */
    public function eventBeforeValidate()
    {
        if ($this->scenario == 'restcreate') {
            $this->encodePassword();
        }
    }

    /**
     * Generate, store and return the secure Login token.
     *
     * @return string
     */
    public function getAndStoreToken()
    {
        $token = Yii::$app->security->generateRandomString(6);
        $token = strtolower(str_replace(['-', '_'], 'a', $token));
        $this->setAttribute('secure_token', sha1($token));
        $this->setAttribute('secure_token_timestamp', time());
        $this->update(false);

        return $token;
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->where(['is_deleted' => false]);
    }

    /**
     * @inheritdoc
     */
    public function changePassword($newpass)
    {
        $this->password = $newpass;

        if ($this->encodePassword()) {
            if ($this->save()) {
                return true;
            } else {
                $this->addError('newpass', 'Fehler beim Speichern des Passworts aufgetreten. (Datenbankfehler)');
            }
        }

        return $this->addError('newpass', 'Fehler beim Verschlüsseln des Passworts aufgetreten!');
    }
    
    /**
     * Encodes the current active record password field.
     * @return boolean
     */
    public function encodePassword()
    {
        if (empty($this->password) || strlen($this->password) < 8) {
            $this->addError('password', 'The password must be at least 8 chars.');

            return false;
        }
        // create random string for password salting
        $this->password_salt = Yii::$app->getSecurity()->generateRandomString();
        // store the password
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password.$this->password_salt);

        return true;
    }
    
    /**
     * Get the title Mr, Mrs. as string for the current user.
     *
     * @return string
     */
    public function getTitleNamed()
    {
        return self::getTitles()[$this->title];
    }

    /**
     * Returns the available titles (mr, mrs index by numberic identifier
     *
     * @return array
     */
    public static function getTitles()
    {
        return [
            1 => Module::t('model_user_title_mr'),
            2 => Module::t('model_user_title_mrs'),
        ];
    }

    /**
     * Return sensitive fields from api exposure.
     *
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::fields()
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['password_salt'], $fields['auth_token'], $fields['is_deleted']);
        return $fields;
    }

    /**
     * Return the current related groups.
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['id' => 'group_id'])->viaTable('admin_user_group', ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['groups', 'lastloginTimestamp'];
    }

    // AuthMethods

    /**
     * Finds a current user for a given email.
     *
     * @param string $email The email address to find the user from.
     * @return \yii\db\ActiveRecord|null
     */
    public static function findByEmail($email)
    {
        return self::find()->where(['email' => $email, 'is_deleted' => false])->one();
    }

    /**
     * Validates the password for the current given user.
     *
     * @param string $password The plain user input password.
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password.$this->password_salt, $this->password);
    }
    
    /**
     * Get the user logins for the given user.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserLogins()
    {
        return $this->hasMany(UserLogin::class, ['user_id' => 'id']);
    }

    // IdentityInterface

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->joinWith(['userLogins ul'])->andWhere(['admin_user.id' => $id, 'is_destroyed' => false, 'ip' => Yii::$app->request->userIP])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }
}
