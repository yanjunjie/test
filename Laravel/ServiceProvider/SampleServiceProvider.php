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
 * Class registration/Dependency injection with Service Provider like this
 *
1.
App::bind('App\Billing\Stripe');

2.
$this->app->bind('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});

3. we have to import the Stripe class
$this->app->bind('Stripe', function(){
    return new Stripe(config('services.stripe.secret'));
});

//OR
$this->app->bind(Stripe::class, function(){
    return new Stripe(config('services.stripe.secret'));
});

4. we have to import the App class
App::bind('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});

5.
$this->app->bind('HelpSpot\API', function ($app) {
    return new HelpSpot\API($app->make('HttpClient'));
});

6.
App::singleton('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});
*/

/*
* The following examples are happening in the providers/AppServiceProvider.php file
*/
public function resister()
{
    //Example 01:
    app()->bind('App\Billing\Stripe');

    //Example 02:
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
 * This is happening in the Controllers/TestController.php
 */
public function index()
{
    // example 01
    $stripe = resolve('App\Billing\Stripe');
    dd($stripe->get_result(12,12,'sum'));

    // example 02
    $stripe = resolve('Stripe');
    dd($stripe);
}

/*
* Create a class called Stripe in the app/billing directory (you can make anywhere in your application) like this
*
namespace App\Billing;
class Stripe
{
    public $key;
    public function __construct($key) {
        $this->key = $key;
    }

    public function get_result($a,$b,$type)
    {
        if($type=='sum')
        {
            return $a+$b;
        }
        else if($type=='sub')
        {
            return $a-$b;
        }
        else if($type=='mul')
        {
            return $a*$b;
        }
        else if($type=='div')
        {
            return $a/$b;
        }
        else
            return 'Please Enter Valid Number';
    }
}
*/

/*
 * Share something with Service Provider's boot method like so
 *
*/
public function boot()
{
    view()->share('test_var',12);
}