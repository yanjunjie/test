<?php
/*
Global methods:
view();
request();
app();
resolve();
*/

/*
* Service Container:
 *
 * Class registration/Dependency injection with Service Container
 *
 For Example:
1.
App::bind('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});

2.
App::singleton('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});
i.e,
$stripe = resolve('Stripe');
$stripe2 = resolve('Stripe');
$stripe3 = resolve('Stripe');

3.
App:instance('Stripe', $stripe);
*/

/*
* This is happening in the routes/web.php file
*/
App::bind('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});

/*
 * Now resolve the class and make an instance of the class using one of the following methods
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

