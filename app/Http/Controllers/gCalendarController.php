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
use App\Task;/*Modelo*/
use App\Operador;
use Laracasts\Flash\Flash;

class gCalendarController extends Controller
{
    protected $client;
    public function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false))); //PHP 5.6
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

              /*Seleccion de RUT Correspondiente al inicio de seccion*/
              $gcalendar_id = Operador::find(1)->gcalendar_id;
              if (!empty($gcalendar_id)) {
                  $calendarId = $gcalendar_id;
              }else{
                $calendarId = 'primary'; /*Calendario Principal*/
              }             
            //  $calendarId = '1tag5q73jl88vle96547b0plu8@group.calendar.google.com'; /*Calendario Compartido*/
              
              /*Edicion de parametros*/
              $optParams = array(
              'maxResults' => 1000,
              'orderBy' => 'startTime',
              'singleEvents' =>TRUE,
              'timeMin'=>Carbon::now()->addyear(-1)->toIso8601String(),//Tiempo Minimo desde el cual comienza a leer
              'timeMax'=>Carbon::now()->addyear(1)->toIso8601String(),//Tiempo Maximo desde el cual comienza a leer
              );
                /*Retornamos los items de nuestro calendario, con nuestros parametros establecidos*/
              $results = $service->events->listEvents($calendarId,$optParams);
              $tasks = Task::all(); /*Consulta a la BD*/

            return view('calendar.index2',compact('tasks'),compact('results'));
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
      
      if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
              $this->client->setAccessToken($_SESSION['access_token']);
              $service = new Google_Service_Calendar($this->client);
              $Operador = Operador::findOrFail(1);
              if (!empty($Operador->gcalendar_id)) {
              $calendarId = $Operador->gcalendar_id;
              }else{
              $calendarId = 'primary'; 
              }

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
/*Creacion de calendario obteniendo ID de google calendar, *****Buscar la manera de dar permisos publicos*******/
    public function Getgcalendar(){
   
          $Operador = Operador::findOrFail(1);
            if (empty($Operador->gcalendar_id)) {
            session_start();
            $this->client->setAccessToken($_SESSION['access_token']);  
            $service = new Google_Service_Calendar($this->client);   
            /*Caracteristicas del calendario*/
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary("R9Calendario");
            $calendar->setTimeZone('America/Santiago');
         
            $createdCalendar = $service->calendars->insert($calendar);
            $valid = $createdCalendar->getId(); /*Guardar DATABASE*/
           // dd($valid); /*Google ID de calendario*/
            $Operador->gcalendar_id = $createdCalendar->getid();
            $Operador->save();
            Flash::success("Creacion de Google Calendar");
            return redirect()->route('gcalendar.index');  
            }
            else{
            Flash::success('Ya se encuentra Sincronizado con google calendar'); 
            return redirect()->route('gcalendar.index');
            }         
    }
/*Integracion de con la persona que inicia seccion R9Calendario*/
    public function Asignacion_Google_Calendar(){
          // $rule = new AclRule();
          // $scope = new AclRuleScope();
          // $scope->setType("default");
          // $scope->setValue("");
          //$rule->setScope($scope);
          //  $rule->setRole("reader");
          // $createdRule = $service->acl->insert($createdCalendar->id, $rule);

            session_start();
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client); 
            $calendarListEntry = new Google_Service_Calendar_CalendarListEntry(); 
            $calendarId = '1tag5q73jl88vle96547b0plu8@group.calendar.google.com';//example
            $calendarListEntry->setId($calendarId);
            $createdCalendarListEntry = $service->calendarList->insert($calendarListEntry);

            dd($createdCalendarListEntry->getSummary()); 
    }

    /**
     * Display the specified resource.
     *
     * @param $eventId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
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
              $gcalendar_id = Operador::find(1)->gcalendar_id;
             if (!empty($Operador->gcalendar_id)) {
              $calendarId = $Operador->gcalendar_id;
              }else{
              $calendarId = 'primary'; 
              }

            //$calendarId = '1tag5q73jl88vle96547b0plu8@group.calendar.google.com'; //Example
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
            //Delete
             $gcalendar_id = Operador::find(1)->gcalendar_id;
             if (!empty($Operador->gcalendar_id)) {
              $calendarId = $Operador->gcalendar_id;
              }else{
              $calendarId = 'primary'; 
              }
            $eventId = $request->id;
            $service->events->delete($calendarId, $eventId);

        } else {
            return redirect()->route('oauthCallback');
        }
    }
}
