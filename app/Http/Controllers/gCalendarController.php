<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_CalendarListEntry;
use App\Task;


class gCalendarController extends Controller
{
    protected $client;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $calendarId = 'primary';
       
      $calendarId = '1tag5q73jl88vle96547b0plu8@group.calendar.google.com';

           //$evens= new Google_Service_Calendar_Event($this->client);
            //  $eventos = $evens->listEvents($calendarId);
            //  dd($eventos);
            ///$foo = $service->events->listEvents($calendarId);
            //dd($service);   date('c',Carbon::now())
            //$llala = Carbon::now()->addyear(2)->toIso8601String();
            //dd(date('c',time()),$llala);

                /*Edicion de parametros*/
                $optParams = array(
                'maxResults' => 1000,
                'orderBy' => 'startTime',
                'singleEvents' =>TRUE,
                //'timeMin' =>date('c',time()), //Hace relacion al tiempo minimo a leer
                'timeMin'=>Carbon::now()->addyear(-1)->toIso8601String(),
                'timeMax'=>Carbon::now()->addyear(1)->toIso8601String(),
                );
                /*Retornamos los items de nuestro calendario, con nuestros parametros establecidos*/
               $results = $service->events->listEvents($calendarId,$optParams);
               $tasks = Task::all(); /*Consulta a la BD*/
            return view('calendar.index2',compact('tasks'),compact('results'));
            //return view('calendar.index')->with("results",$results);
        } else {
                return redirect()->route('oauthCallback');
        }
    }

    public function oauth()
    {
        session_start();

        $rurl = action('gCalendarController@oauth');
        $this->client->setRedirectUri($rurl);
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);
        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();
            return redirect()->route('gcalendar.index');
        }
    }

    public function NewCalendar(){
    
           //$this->client->setAccessToken($_SESSION['access_token']);
            //$service = new Google_Service_Calendar($this->client);     
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary('Calendario_de_Alertas');
            $calendar->setTimeZone('America/Santiago');

            $createdCalendar = $service->calendars->insert($calendar);
            $valid = $createdCalendar->getId();
            dd($valid);
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.createEvent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session_start();

    //->toDateTimeString **Obtenemos de manera DATETIME
    //->toDateString     **Obtenemos de manera DATE
    // $startDateTime = $request->start_date;
    // $endDateTime = $request->end_date;
    $startDateTime = Carbon::parse($request->start_date)->toDateString();
    $endDateTime =  Carbon::parse($request->end_date)->toDateString();
   
   // $colorSET = '11';
     //  if ($request->title == "Calibracion") {
       //    $val = 'lalala';
    // }
  //console.log("asdlkasjdakldjdaskldsjalkadjsldjasldkjskldjkl");

    //  if ($request->color == 'rgb(221,+75,+57)') $colorSET = '11'; //Reparacion - Rojo
    //  if ($request->color == "rgb(0,+166,+90)")  $colorSET = '10'; //Calibracion - Verde
    //  if ($request->color == rgb(60,+141,+188))  $colorSET = '9'; //Mantencion - azul
       
//dd($startDateTime);
//dd($endDateTime);


        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' =>$request->title,
                'description' => $request->description,
               // 'start' => ['dateTime' => $startDateTime], /*dateTime date    , 'timeZone'=>*/
              //  'end' => ['dateTime' => $endDateTime], /*dateTime date*/
                //'start' => ['timeZone' =>'America/Santiago'],
                'start' => ['date' => $endDateTime], /*dateTime date*/
                'end' => ['date' => $endDateTime], /*dateTime date*/
                'reminders' => ['useDefault' => true],
                'colorId' => $request->color,

                //'al' => ['useDefault' => true],
            ]);
            $results = $service->events->insert($calendarId, $event);
            if (!$results) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'message' => 'Event Created']);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
/*Creacion de calendario obteniendo ID de google calendar,
Buscar la manera de dar permisos publicos*/
    public function show2(){
   
            session_start();
      
            $this->client->setAccessToken($_SESSION['access_token']);  
            $service = new Google_Service_Calendar($this->client);   
            
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary('R9Calendario');
            $calendar->setTimeZone('America/Santiago');
         

            $createdCalendar = $service->calendars->insert($calendar);
            $valid = $createdCalendar->getId();

            dd($createdCalendar);

    }
/*Sincronizacion Personal con calendario*/
    public function show(){

       /**     session_start();
            $this->client->setAccessToken($_SESSION['access_token']);  
            $service = new Google_Service_Calendar($this->client);
          //$calendar = new Google_Service_Calendar_Calendar();
            $calendar = $service->calendars->get('1tag5q73jl88vle96547b0plu8@group.calendar.google.com');

           //$createdCalendar = $service->calendars->insert($calendar);
             $createdCalendar = $service->calendars->insert($calendar);

    dd($createdCalendar);
**/

session_start();
$this->client->setAccessToken($_SESSION['access_token']);
$service = new Google_Service_Calendar($this->client); 
$calendarListEntry = new Google_Service_Calendar_CalendarListEntry(); 
$calendarId = '1tag5q73jl88vle96547b0plu8@group.calendar.google.com';
$calendarListEntry->setId($calendarId);
$createdCalendarListEntry = $service->calendarList->insert($calendarListEntry);

  dd($createdCalendarListEntry->getSummary()); 


    }
    /*
    public function show($eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);

            $service = new Google_Service_Calendar($this->client);
            $event = $service->events->get('primary', $eventId);

            if (!$event) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $event]);

        } else {
            return redirect()->route('oauthCallback');
        }
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request) //, $eventId
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $startDateTime = Carbon::parse($request->start_date)->toIso8601String();
            
            $startDate = Carbon::parse($request->start_date)->toDateString();
            $endDate = Carbon::parse($request->end_date)->toDateString();
            
            //$eventDuration = 30; //minutes

            if ($request->has('end_date')) {
                $endDateTime = Carbon::parse($request->end_date)->toIso8601String();
            } else {
            // $endDateTime = Carbon::parse($request->start_date)->addMinutes($eventDuration)->3339String();
                $endDateTime = Carbon::parse($request->start_date)->toIso8601String();
            }

            // retrieve the event from the API.
            $calendarId = '1tag5q73jl88vle96547b0plu8@group.calendar.google.com'; //Example
            $event = $service->events->get($calendarId, $request->id);
            // $event = $service->events->get('primary', $eventId);

            $event->setSummary($request->title);

            $event->setDescription($request->description);

            //start time
            $start = new Google_Service_Calendar_EventDateTime();
            //$start->setDateTime($startDateTime);
            $start->setDate($startDate);
            $event->setStart($start);

            //end time
            $end = new Google_Service_Calendar_EventDateTime();
            //$end->setDateTime($endDateTime);
            $end->setDate($endDate);
            $event->setEnd($end);
            //$event->setDateOnly(true);
            $updatedEvent = $service->events->update($calendarId, $event->getId(), $event);


            if (!$updatedEvent) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $updatedEvent]);

        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);
            $eventId = $request->id;
            $service->events->delete('primary', $eventId);

        } else {
            return redirect()->route('oauthCallback');
        }
    }
}
