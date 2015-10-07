<?php namespace App\Console\Commands;

use App\Request;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ModerateRequests extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'moderate:requests';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Moderate requests that are older then an hour';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$requests = Request::where('updated_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('status', 0)->get();
        foreach($requests as $request){
            $request->updated_at = Carbon::now();
            $request->status = 1;
            $request->save();
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}

}
