<?php
/*
Global methods:
view();
request();
app();
resolve();
*/

/*
* Service Provider:
 *
 * Class registration/Dependency injection with Service Provider
 *
 For Example:
1.
public function register()
{
    $this->app->bind('Stripe', function(){
        return new \App\Billing\Stripe(config('services.stripe.secret'));
    });
}

2. we have to import App class
public function register()
{
    App::bind('Stripe', function(){
        return new \App\Billing\Stripe(config('services.stripe.secret'));
    });
}
3.
public function register()
{
    $this->app->bind('HelpSpot\API', function ($app) {
        return new HelpSpot\API($app->make('HttpClient'));
    });
}
4.
public function register()
{
    App::singleton('Stripe', function(){
        return new \App\Billing\Stripe(config('services.stripe.secret'));
    });
}
*/


/*
* This is happening in the providers/AppServiceProvider.php file
*/
public function resister()
{
    App::bind('Stripe', function(){
        return new \App\Billing\Stripe(config('services.stripe.secret'));
    });
}

/*
 * Now resolve the instance of the class using one of the following methods
 *
i) make();
ii) resolve();
iii) app();

For Example:
$stripe = App::make('Stripe');
$stripe = resolve('Stripe');
$stripe = app('Stripe');
*/

/*
 * This is happening in TestController
 */
public function index()
{
    $stripe = resolve('Stripe');
    dd($stripe);
}

/*
* Create a class called Stripe in the app/billing directory (you can make anywhere in your application) like this
*
namespace App\Billing;
class Stripe
{
    protected $key;
    public function __construct($key) {
        $this->key = $key;
    }
}
*/

/*
 * Share something with Service Provider's boot method
 *
 For Example:
*/
public function boot()
{
    view()->share('test_var',12);
}