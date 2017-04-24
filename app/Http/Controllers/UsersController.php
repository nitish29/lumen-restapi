<?php

namespace App\Http\Controllers;

use App\Users;
use DB;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function index() {
        

        $users = Users::paginate(30);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

            return $this->error('Error fetch all users from database', 404);

        }
        

    }

    public function searchUserDetailsUsingEloquent() {
        
        //DB::connection()->enableQueryLog();
        $users = Users::all();
        //var_dump(DB::getQueryLog());

        if ( $users ) {

            return $this->success($users, 200);

        } else {

            return $this->error('Error fetch all users from database', 404);

        }
        

    }

    public function searchUserDetailsUsingQueryBuilder() {
        
        //DB::connection()->enableQueryLog();
        $users = DB::table('users')->paginate(30);
        //var_dump(DB::getQueryLog());

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

            return $this->error('Error fetch all users from database', 404);

        }
        

    }

    public function searchUserDetailsUsingRawSQL() {
        
        $users = DB::select('select * from users')->paginate();

        if ( $users ) {

            return $this->success($users, 200);

        } else {

            return $this->error('Error fetch all users from database', 404);

        }
        

    }

    public function searchUserByAllAttributes($last_name, $first_name, $gender, $age) {
        
        //DB::connection()->enableQueryLog();
        
        /*$users = Users::where('last_name', '=' , $last_name)
        ->where('first_name', '=' , $first_name)
        ->where('age', '=' , $age)
        ->where('gender', '=' , $gender)->get();*/

        $users = DB::table('users')
                        ->where('last_name', '=' , $last_name)
                        ->where('first_name', '=' , $first_name)
                        ->where('age', '=' , $age)
                        ->where('gender', '=' , $gender)->paginate(100);

    
        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByLastName($last_name){

        $users = DB::table('users')
                        ->where('last_name', '=' , $last_name)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }



    }

    public function searchUserByLastNameAndAge($last_name, $age){

        $users = DB::table('users')
                        ->where('last_name', '=' , $last_name)
                        ->where('age', '=' , $age)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByLastNameAndGender($last_name, $gender) {

        $users = DB::table('users')
                        ->where('last_name', '=' , $last_name)
                        ->where('gender', '=' , $gender)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByLastNameGenderAndAge($last_name, $gender, $age) {

        $users = DB::table('users')
                        ->where('last_name', '=' , $last_name)
                        ->where('age', '=' , $age)
                        ->where('gender', '=' , $gender)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }
        
    }

    public function searchUserByFirstName($first_name) {

        $users = DB::table('users')
                        ->where('first_name', '=' , $first_name)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByFirstNameAndAge($first_name, $age) {

        $users = DB::table('users')
                        ->where('first_name', '=' , $first_name)
                        ->where('age', '=' , $age)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByFirstNameAndGender($first_name, $gender) {

        $users = DB::table('users')
                        ->where('first_name', '=' , $first_name)
                        ->where('gender', '=' , $gender)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByFirstNameGenderAndAge($first_name, $gender, $age) {

        $users = DB::table('users')
                        ->where('first_name', '=' , $first_name)
                        ->where('age', '=' , $age)
                        ->where('gender', '=' , $gender)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByAge($age) {

        $users = DB::table('users')
                        ->where('age', '=' , $age)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByGender($gender) {

        $users = DB::table('users')
                        ->where('gender', '=' , $gender)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByGenderAndAge($gender,$age) {

        $users = DB::table('users')
                        ->where('age', '=' , $age)
                        ->where('gender', '=' , $gender)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('Users Not Found', 404); 

        }

    }

    public function searchUserByLastNameAndFirstName($last_name, $first_name) {

        $users = DB::table('users')
                        ->where('last_name', '=' , $last_name)
                        ->where('first_name', '=' , $first_name)->paginate(100);

        if ( !$users->isEmpty() ) {

            return $this->success($users, 200);

        } else {

           return $this->error('User Not Found', 404); 

        }

    }



}
