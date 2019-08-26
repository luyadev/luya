# JWT auth with SPA Applications

> since LUYA admin module version 2.2

The LUYA admin provides a basic JWT generator including an out of the box authentification system which can proxy requests trough LUYA Admin Api User and those permission system.

## Implementation

As all LUYA admin APIs requerd an authentification which is proxied trough LUYA API Users (Read about [[concept.headless.md]]).

![luya-proxy](https://raw.githubusercontent.com/luyadev/luya/master/docs/guide/img/jwt-apiuser-proxy.png "JWT with Admin as Proxy")

## Example

```php
class UserController extends \luya\admin\ngrest\base\Api
{
    public $authOptional = ['login', 'signup'];

    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'rsv\models\User';

    public function actionLogin()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_LOGIN;
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $user = User::find()->where(['email' => $model->email])->one();
            if ($user && Yii::$app->security->validatePassword($model->password, $user->password)) {
                if ($user->updateAttributes(['jwtToken' => Yii::$app->jwt->generateToken($user)])) {
                    return $user;
                }
        
            } else {
                $model->addError('email', 'Unable to find the given email or password is wrong.');
            }
        }

        return $this->sendModelError($model);
    }

    public function actionSignup()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $model;
        }

        return $this->sendModelError($model);
    }

    public function actionMe()
    {
        return $this->jwtIdentity;
    }
}
```