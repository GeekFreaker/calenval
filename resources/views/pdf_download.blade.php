<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<body>
  <div class="text-center" id="content">
    <h2 >South African Holidays <b> <span style="color:#669cd2">{{$yr}}</span> </b></h2>
    <br>
    <p>A brief summary of the holidays happeng in South Africa in the year {{$yr}}.</p>
    <br>
     <table class="table table-bordered table-striped">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Date</th>
        <th scope="col">Name</th>
        <th scope="col">Language</th>
        <th scope="col">Created</th>
        <th scope="col">Updated</th>
      </tr>
      <tbody>
          	@foreach ($events as $event)
              <tr>
                <th scope="col">{{$event->id}}</th>
                <td>{{$event->date}}</td>
                <td>{{$event->name}}</td>
                <td>{{$event->language}}</td>
                <td>{{$event->created_at}}</td>
                <td>{{$event->updated_at}}</td>
              </tr>
            @endforeach
    </tbody>
    </table>
    </p>
  </div>
</body>
