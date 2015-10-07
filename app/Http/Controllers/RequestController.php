<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RequestController extends Controller {

	public function create(Requests\Request $req) {

		if( ! \Auth::user()->is_ready() )
			return 'hello lamer';

		$input = (object)\Input::all();

		$request = new \App\Request;

		$request->type_id = $input->type;

		if( ! $input->new && ! $input->old )
			return 'hello lamer';
		else {
			$request->new = $input->new;
			$request->old = $input->old;
		}

		if(\App\Make::isInType($input->make, $input->type))
			$request->make_id = $input->make;
		else
			return 'hello lamer';

		if(\App\CarModel::isInMake($input->model, $input->make))
			$request->model_id = $input->model;
		else
			return 'hello lamer';

		if( ! $input->year )
			return 'hello lamer';
		else
			$request->year = $input->year;

		if( ! $input->more )
			return 'hello lamer';
		else
			$request->text = $input->more;

		$request->user_id = \Auth::id();

		$request->save();

		return $this->createRooms($request, $req);

		return $request;

	}

	public function createRooms($request, $httpRequest){

		$companies = \App\Company::whereHas('models', function($q) use($request){
			$q->whereId($request->model_id);
		})
		->with('user')
		->whereTypeId($request->type_id)
		->get();


		foreach ($companies as $company) {
			$room = new \App\Room;
			$room->request_id = $request->id;
			$room->company_id = $company->id;
			$room->save();

			\Mail::queue('emails.request', [
				'request' => $request,
				'room' => $room
			], function($msg) use ($company){
				$msg->to($company->user->email)
				->subject('Новый заказ | Комтранс');
			});
            $admin = $httpRequest->getAdmin();
            if($admin){
                \Mail::queue('emails.request', [
                    'request' => $request,
                    'room' => $room
                ], function($msg) use($admin){
                    $msg->to($admin->email)
                        ->subject('Новый заказ | Комтранс');
                });
            }
		}

	}

}
