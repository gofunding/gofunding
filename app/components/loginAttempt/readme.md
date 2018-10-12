#Add the behavior to your login model.

```
public function behaviors()
{
    $behaviors = parent::behaviors();

    $behaviors[] = [
        'class' => '\ethercreative\loginattempts\LoginAttemptBehavior',

        // Amount of attempts in the given time period
        'attempts' => 3,

        // the duration, in seconds, for a regular failure to be stored for
        // resets on new failure
        'duration' => 300,

        // the duration, in seconds, to disable login after exceeding `attemps`
        'disableDuration' => 900,

        // the attribute used as the key in the database
        // and add errors to
        'usernameAttribute' => 'email',

        // the attribute to check for errors
        'passwordAttribute' => 'password',

        // the validation message to return to `usernameAttribute`
        'message' => 'Login disabled',
    ];

    return $behaviors;
}
```