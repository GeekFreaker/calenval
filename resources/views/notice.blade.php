
@if($message = Session::get("error"))
  <div style="background:#dc9e9e">
     <h4 class="text-center text-danger" style="padding-left:110px;padding-right:110px;margin-top:4px;margin-bottom:4px;">
       {{$message}}
     </h4>
   </div>
@endif
