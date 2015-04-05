<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
    /**
     * @var Request
     */
    protected $request;

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->middleware('guest');
        $this->request = $request;
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('index.index');
	}

    public function create()
    {
        return view('index.index');
    }

    public function store()
    {
        $request=$this->request;

         Mail::send('emails.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message)
            {
                $message->from('abuitrago@perast.cl');
                $message->to('abuitrago@perast.cl', 'Admin')->subject('Contacto perast.cl');
            });

        return redirect()->route('contact')->with('message', 'Gracias por contactarnos!');

    }

}
