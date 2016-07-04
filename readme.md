##=============================================##
Plugin description : Facebook login with laravel with latest facebook SDk
Develop by : Hems patel(http://patelitsolutions.com/)
Developer contact(email) : patel.hemant15@gmail.com
Licence: MIT, GNU
##=============================================##


How to use:

1) Download from packagist.org.
2) 
Add `hemsfacebook/fblogin` to `composer.json`.

    "hemsfacebook/fblogin": "dev-master"
	
3)
Run `composer update` to pull down the latest version of Facebook.
Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
       'Hemsfacebook\Fblogin\FbloginServiceProvider',
    )

Now add the alias.

    'aliases' => array(
         'HemsFacebook' => 'Hemsfacebook\Fblogin\Facades\HemsfbFacade',
    )

4)
## Configuration

Run `php artisan config:publish hemsfacebook/fblogin` and modify the config file with your own informations.

	'redirect' URL::to("/") . '/(Your call back url)',
    'scope'   'public_profile,email',
    'appId'   'FB APP appid',
    'secret'  'FB APP secret'


## Examples

1. Get Login Url with your credentials and scope.

    Route::get('/', function()
    {
    	return HemsFacebook::loginUrl();
    });
	
2. Use facebook API

    Route::get('/', function()
    {
    	$profile = HemsFacebook::api('/me?fields=id,name,email,gender');
    });

    
