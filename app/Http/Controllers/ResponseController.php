<?php namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Request as Request;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;

class ResponseController extends Controller {

	public function create(BaseRequest $request) {

		$input = (object)\Input::all();

		$company = \Auth::user()->company;

		if( $input->response == '' )
			return 'hello lamer';

		$room = \App\Room::whereCompanyId($company->id)
		->with(['request' => function($q){
			$q->with('user');
			$q->with('type');
			$q->with('model');
			$q->with('make');
		}])
		->find($input->room);

		if( ! $room )
			return 'hello lamer';

		$response = new \App\Response;

		$response->text = htmlentities($input->response);
		$response->company_id = $company->id;
		$response->room_id = $input->room;

		$response->save();

		if(isset($input->photos)){

			if( count($input->photos) > 10 )
				return 'hello lamer';

			foreach ($input->photos as $src) {

				$name = md5(\Hash::make($src . \Auth::id() . $room->id));

				$dirname = 'img/room' . $room->id . '/photos';

				$fullname = $dirname . '/' . $name . '.jpg';

				if( ! file_exists($dirname) ){
					mkdir($dirname, 0777, true);
				}
				
				\Image::make($src)->save($fullname, 100);

				$photo = new \App\ResponsePhoto(['src' => $fullname]);

				$response->photos()->save($photo);

			}

		}

		\Mail::queue('emails.response', [
			'request' => $room->request,
			'room' => $room,
			'company' => $company
		], function($msg) use ($room){
			$msg->to($room->request->user->email)
			->subject('Новый заказ | Комтранс');
		});
        $admin = $request->getAdmin();
        if($admin){
            \Mail::queue('emails.response_admin', [
                'request' => $room->request,
                'room' => $room,
                'company' => $company
            ], function($msg) use ($admin){
                $msg->to($admin->email)
                    ->subject('Новый заказ | Комтранс');
            });
        }

	}

}
