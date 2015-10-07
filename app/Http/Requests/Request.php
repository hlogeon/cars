<?php namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

	//

    public function getAdmin()
    {
        return User::where('name', 'admin')->first();
    }
}
