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
 * Class registration/Dependency injection with Service Container like this
 *
1.
App::bind('App\Billing\Stripe');

2.
App::bind('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});

3.
App::singleton('Stripe', function(){
    return new \App\Billing\Stripe(config('services.stripe.secret'));
});
i.e,
$stripe = resolve('Stripe');
$stripe2 = resolve('Stripe');
$stripe3 = resolve('Stripe');

4.
App:instance('Stripe', $stripe);
*/

/*
* The following examples are happening in the routes/web.php file
*/
//Example 01:
App::bind('App\Billing\Stripe');

//Example 02:
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

