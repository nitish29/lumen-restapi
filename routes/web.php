<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
// use App\Users;

$app->get('/', function () use ($app) {
    return $app->version();
});

/*Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
   //var_dump($query->sql); // Dumps sql
   //var_dump($query->bindings); //Dumps data passed to query
   var_dump($query->time); //Dumps time sql took to be processed
});*/

// $app->get('users/{id}', function($id) use ($app) {

// 	return Users::findOrFail($id);

$app->group(['prefix' => 'api/v1'], function($app)
{
	$app->get('users/lastName/{last_name:[A-Za-z]+}/firstName/{first_name:[A-Za-z]+}/gender/{gender:[A-Za-z]+}/age/{age:[0-9]+}', 'UsersController@searchUserByAllAttributes');

	$app->get('users/lastName/{last_name:[A-Za-z]+}', 'UsersController@searchUserByLastName');

	$app->get('users/lastName/{last_name:[A-Za-z]+}/age/{age:[0-9]+}', 'UsersController@searchUserByLastNameAndAge');

	$app->get('users/lastName/{last_name:[A-Za-z]+}/gender/{gender:[A-Za-z]+}', 'UsersController@searchUserByLastNameAndGender');

	$app->get('users/lastName/{last_name:[A-Za-z]+}/gender/{gender:[A-Za-z]+}/age/{age:[0-9]+}', 'UsersController@searchUserByLastNameGenderAndAge');

	$app->get('users/firstName/{first_name:[A-Za-z]+}', 'UsersController@searchUserByFirstName');

	$app->get('users/firstName/{first_name:[A-Za-z]+}/age/{age:[0-9]+}', 'UsersController@searchUserByFirstNameAndAge');

	$app->get('users/firstName/{first_name:[A-Za-z]+}/gender/{gender:[A-Za-z]+}', 'UsersController@searchUserByFirstNameAndGender');

	$app->get('users/firstName/{first_name:[A-Za-z]+}/gender/{gender:[A-Za-z]+}/age/{age:[0-9]+}', 'UsersController@searchUserByFirstNameGenderAndAge');

	$app->get('users/age/{age:[0-9]+}', 'UsersController@searchUserByAge');

	$app->get('users/gender/{gender:[A-Za-z]+}/age/{age:[0-9]+}', 'UsersController@searchUserByGenderAndAge');

	$app->get('users/gender/{gender:[A-Za-z]+}', 'UsersController@searchUserByGender');

	$app->get('users/lastName/{last_name:[A-Za-z]+}/firstName/{first_name:[A-Za-z]+}', 'UsersController@searchUserByLastNameAndFirstName');
	
	
	$app->get('users/el', 'UsersController@searchUserDetailsUsingEloquent');
	$app->get('users/qb', 'UsersController@searchUserDetailsUsingQueryBuilder');
	$app->get('users/raw', 'UsersController@searchUserDetailsUsingRawSQL');
	$app->get('users','UsersController@index');
	$app->get('users/{user_id}','UsersController@searchUserDetails');


});