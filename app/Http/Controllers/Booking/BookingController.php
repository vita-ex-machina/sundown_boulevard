<?php
namespace App\Http\Controllers\Booking;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$reservations = Reservation::all();
        $reservations = Reservation::whereDate('reservation_date','>=', Carbon::today())->paginate(10);;

        // Need to add error handling
        $url = 'https://api.punkapi.com/v2/beers?page=1&per_page=20';
        $drink_json = json_decode(file_get_contents($url, false));
        // Need to add error handling
        $url = 'https://www.themealdb.com/api/json/v1/1/random.php';
        $meal_json = json_decode(file_get_contents($url, false));  
        
        return view('bookings.index',compact('reservations','drink_json','meal_json'));
    }

    /**
     * Get all availible tables at a specifed date and time frame
     */
    private static function getAvailibleTables($reservation_date,$start_time,$end_time) 
    {
        // Maby don't use DB:raw ??
        // $availible_tables = DB::select(DB::raw("SELECT * FROM `tables` t WHERE t.id NOT IN (
        //     SELECT table_id FROM `reservation_table` rt WHERE rt.reservation_id IN (
        //     SELECT id FROM `reservations` WHERE reservation_date ='".$reservation_date."' 
        //     AND ((DATE_ADD('".$start_time."', INTERVAL 1 MINUTE) BETWEEN start_time AND end_time) OR ('".$end_time."' BETWEEN start_time AND end_time))))"
        //     ));   
        
        $availible_tables = DB::select(DB::raw("SELECT * FROM `tables` t WHERE t.id NOT IN (
        SELECT table_id FROM `reservation_table` rt WHERE rt.reservation_id IN (
        SELECT id FROM `reservations` WHERE reservation_date ='".$reservation_date."' 
            AND (('".$start_time."' > start_time AND '".$start_time."' < end_time) 
            OR ('".$end_time."' BETWEEN start_time AND end_time))))"
            ));   
     
    
        return $availible_tables;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //stub
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Create $end_time string in time format H:i
        $start_time = $request->request->get('start_time');
        $end_time   = $request->request->get('end_time');
        $carbon_end_time = new Carbon($start_time);
        $carbon_end_time->addHours((int) $end_time);
        $end_time=$carbon_end_time->format('H:i');
        $request->request->set('end_time',$end_time);
        
        //Validate data
        $storeData = $request->validate([
            'user_id'           => 'required',
            'reservation_date'  => 'required|after:yesterday',
            'start_time'        => 'required|date_format:H:i|after:15:59|before:20:01',
            'end_time'          => 'required|date_format:H:i|after:17:59|before:22:01',
            'number_people'     => 'required|max:10',
            'drink_name'        => 'required',
            'dish_name'         => 'required'

        ]);

        //Get array of availible tables
        $reservation_date =$storeData['reservation_date'];
        $start_time       =$storeData['start_time'];
        $end_time         =$storeData['end_time'];
        $availible_tables = self::getAvailibleTables($reservation_date,$start_time,$end_time);

        //Check if there is enough availible tables for the specified number of people
        if(count($availible_tables)*2 < $storeData['number_people']){
            return redirect('/bookings')
            ->with('failure', 'Not enough available tables to accommodate '.$storeData['number_people'].
                              ' people at '.$reservation_date.' from '.$start_time.' to '.$end_time.'.');    
        }

        //Create reservation
        $booking = Reservation::create($storeData);
        $reservation = Reservation::find($booking->id);

        //Attach tables to the reservation
        $number_of_tables_needed = ceil($storeData['number_people']/2);
        for ($i=0; $i < $number_of_tables_needed; $i++) {               
            $reservation->tables()->attach($availible_tables[$i]->id);
        }

        return redirect('/bookings')->with('success', 'Booking has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //stub
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //stub
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //stub
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //stub
    }

}
