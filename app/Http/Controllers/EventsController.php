<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;
use PDF;
use Calendar;

class EventsController extends Controller
{
    /**
     * Display a listing of the holidays this year.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
      //clear the table
      Events::truncate();
      $events = [];
      //place on calendar
      $url = env('YEAR_CALENDAR','');
      $jsonData = json_decode(file_get_contents($url),true);
      if(count($jsonData)>1){
      for ($j=0; $j < count($jsonData); $j++) {
        $dateval = (string)$jsonData[$j]['date']['year'].'-'.
                   (string)$jsonData[$j]['date']['month'].'-'.
                   (string)$jsonData[$j]['date']['day'];
        $event = Calendar::event(
        (string)$jsonData[$j]['name'][0]['text'],
        true,
        date('Y-m-d H:i:s',strtotime($dateval)),
        date('Y-m-d H:i:s',strtotime($dateval)),
        $j
        );
      array_push($events,$event);

      $eventsObject = new Events();
      $eventsObject->name = (string)$jsonData[$j]['name'][0]['text'];
      $eventsObject->date = date('Y-m-d H:i:s',strtotime($dateval));
      $eventsObject->holiday_type = (string)$jsonData[$j]['holidayType'];
      $eventsObject->language = (string)$jsonData[$j]['name'][0]['lang'];
      $eventsObject->save();
      }
      }else{
       $request->session()->flash('error', $jsonData['error']);
      }


      $calendar = Calendar::addEvents($events);
      return view('events')->with('calendar',$calendar);
    }

    /**
     * Downloads the pdf of the content in the db.
     *
     * @return \Illuminate\Http\Response
     */
    public function PdfDownload(Request $request){
      $events = Events::all();
      $year = substr($events[0]['date'],0,4);
      $pdf = PDF::loadView('pdf_download', ['events' => $events,'yr' => $year]);
      return $pdf->download($year.'s_Holidays.pdf');
    }

    /**
     * Get's content from API into the db and also adds content to the calendar.
     *
     * @return \Illuminate\Http\Response
     */
    public function date(Request $request) {

      request()->validate([
        'date' => 'required',
      ]);

      Events::truncate();

      $events = [];
      $date= substr($request->date,0,4);
      $new_year='https://kayaposoft.com/enrico/json/v2.0/?action=getHolidaysForYear&year='.$date.'&country=za&region=bw&holidayType=public_holiday';
      $jsonData = json_decode(file_get_contents($new_year),true);
      if(count($jsonData)>1){
      for ($j=0; $j < count($jsonData); $j++) {
        $dateval = (string)$jsonData[$j]['date']['year'].'-'.
                   (string)$jsonData[$j]['date']['month'].'-'.
                   (string)$jsonData[$j]['date']['day'];
        $event = Calendar::event(
        (string)$jsonData[$j]['name'][0]['text'],
        true,
        date('Y-m-d H:i:s',strtotime($dateval)),
        date('Y-m-d H:i:s',strtotime($dateval)),
        $j
      );

      array_push($events,$event);

      $eventsObject = new Events();
      $eventsObject->name = (string)$jsonData[$j]['name'][0]['text'];
      $eventsObject->date = date('Y-m-d H:i:s',strtotime($dateval));
      $eventsObject->holiday_type = (string)$jsonData[$j]['holidayType'];
      $eventsObject->language = (string)$jsonData[$j]['name'][0]['lang'];
      $eventsObject->save();
      }
     }else{
      $request->session()->flash('error', $jsonData['error']);
      }

      $calendar = Calendar::addEvents($events, ['color' => '#2378a2'])->setOptions(['date' => $date]);
      return view('events')->with('calendar',$calendar);
    }

}
