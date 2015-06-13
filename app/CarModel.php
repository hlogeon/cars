<?php namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class CarModel extends Model {

	protected $table = 'models';

	public function make() {
		return $this->belongsTo('App\Make', 'make_id');
	}

	public function feedbacks() {
		return $this->hasMany('App\Feedback', 'model_id');
	}

}