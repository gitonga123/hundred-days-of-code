<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Daniel personal project">
  <meta name="generator" content="Hugo 0.79.0">
  <title>Album example · Bootstrap v5.0</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
  @livewireStyles


  <!-- Bootstrap core CSS -->
  {{-- <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
  <script src="{{ asset('js/d285027a3d.js') }}"></script>



  <meta name="theme-color" content="#7952b3">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


</head>

<body>

  <header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a href="/" class="navbar-brand d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2"
            viewBox="0 0 24 24">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
            <circle cx="12" cy="13" r="4" /></svg>
          <strong>Home</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
          aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span id="timeClock"></span>
        </button>
      </div>
    </div>
  </header>

  <main>
    <section class="py-2 text-center container">
        <div class="row py-lg-5">
          <div class="col-lg-12 col-md-12 mx-auto">
                <form class="row row-cols-lg-auto g-3 align-items-center" method="POST"
                action="/update_time_to_pick_event" autocompletete="off" id="store_settings_time">
                @csrf
                <div class="col-12">
                    <label class="visually-hidden" for="inlineFormInputGroupUsername">Time</label>
                    <div class="input-group">
                      <input name="current_time" type="text" class="form-control" autocomplete="off"  placeholder="time" aria-label="time" value="{{$current_time->current_time}}" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
            </div>
        </div>
    </section>
    <section class="py-2 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-12 col-md-12 mx-auto">
            <table class="table table-striped table-hover" id="match_today_table_id">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Match Id</th>
                    <th scope="col">Home Player</th>
                    <th scope="col">Away Player</th>
                    <th scope="col">Result</th>
                    <th scope="col">Competition</th>
                    <th scope="col">View</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($store_map_id as $match)
                  <tr id="{{$match['id']}}">
                    <th scope="row">#</th>
                    <td>{{$match['id']}}</td>
                    <td>{{$match['home_player']}}</td>
                    <td>{{$match['away_player']}}</td>
                    <td>{{$match['result']}}</td>
                    <td>{{$match['competition']}}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="getMatchDetails({{$match['id']}}, '{{$match['competition']}}')">View Details</button></td>
                  </tr>
                  @endforeach
                </tbody>
                
              </table>
        </div>
    </section>
    @if ($result)
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-12 row-cols-sm-12 row-cols-md-12">
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="card-header"><span id="table_result_count"></span></p>
                                <span id="table_search_result"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

  </main>

  <footer class="text-muted py-5">
    <div class="container">
      <p class="float-end mb-1">
        <a href="#">Back to top</a>
      </p>
      <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
      <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a
          href="/docs/5.0/getting-started/introduction/">getting started guide</a>.</p>
    </div>
  </footer>

  @livewireScripts
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
  </script>
  <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script>
    function updateClock() {
        var currentTime = new Date( );
        var currentHours = currentTime.getHours( );
        var currentMin = currentTime.getMinutes( );
        var currentSeconds = currentTime.getSeconds( );

        currentMin = (currentMin < 10 ? "0" : "") + currentMin;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

        var timeOfDay = (currentHours < 12) ? " AM" : " PM";

        currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

        currentHours = (currentHours === 0) ? 12 : currentHours;

        var currentTimeString = currentHours + ":" + currentMin + ":" + currentSeconds + "" + timeOfDay;

        $('#timeClock').html("<span style='color: #fff'><strong>" + currentTimeString+"</strong></span>");
    }
    function getScoreDetails(match_id) {
      $(`#match_${match_id}`).html();
      let newServerRqst = $.ajax({
            url: `/search/match-score-details/${match_id}`,
            data: {},
            type: 'get'
        });
        newServerRqst.done(function (response) {
          let home_string = '';
          let away_string = '';
          var home_score = JSON.parse(response.data.home);
          var away_score = JSON.parse(response.data.away);
          var home_keys = Object.keys(home_score);
          var away_keys = Object.keys(away_score);
          home_string = '<tr>';
          away_string = '<tr>';
          home_keys.forEach(key => {
            if (key.includes('period')) {
              home_string+=`<td>${home_score[key]}</td>`;
              away_string+=`<td>${away_score[key]}</td>`;
            }
          });
          home_string += '</td>'; away_string +='</td>';
          $(`#span_id_${match_id}`).removeClass('d-none');
          $(`#span_id_${match_id}`).addClass('d-inline');
          $(`#match_${match_id}`).append(home_string);
          $(`#match_${match_id}`).append(away_string);
        });
    }
    function getMatchDetails(match_id, compe) {
        $('#table_result_count').html(`<h5>Loading...</h5>`);
        var serverRqst = $.ajax({
            url: `/search/match/${match_id}/${compe}`,
            data: {},
            type: 'get'
        });
        
        serverRqst.done(function (response) {
          var myObj = JSON.parse(response);
          let tr = '';
          let icon = '';
          let icon_2 = '';
          let table = `<table class="table table-striped table-hover" id="match_results_table_id">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Home Team</th>
                                        <th scope="col">Away Team</th>
                                        <th scope="col">Home</th>
                                        <th scope="col">Away</th>
                                        <th scope="col">Result</th>
                                        <th scope="col">Score</th>
                                        <th scope="col">Home Total</th>
                                        <th scope="col">Away Total</th>
                                        <th scope="col">Both Total</th>
                                        <th scope="col">Event Date</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>`;
          myObj.map(match => {  
              if (match.home_change === "-1") {
                  icon = `<i class="fa fa-sort-down text-danger"></i>`;
              } else if (match.home_change === "1") {
                  icon = `<i class="fa fa-sort-up text-success"></i>`;
              }

              if (match.away_change === "-1") {
                  icon_2 = `<i class="fa fa-sort-down text-danger"></i>`;
              } else if (match.away_change === "1") {
                  icon_2 = `<i class="fa fa-sort-up text-success"></i>`;
              }
              let class_home_name = "";
              let class_away_name = ""; 
              if (match.winner_home == 1) {
                class_home_name = "gOTTkb";
              }

              if (match.winner_away == 1) {
                class_away_name="gOTTkb"
              }

              tr += `<tr><td  onclick="getScoreDetails(${match.match_id})"><i class="fa fa-plus-circle"></i> ${match.match_id}</td><td>${match.player_1}<span id="span_id_${match.match_id}" class="d-none"><br/><span id="match_${match.match_id}"></span></span></td>
                      <td>${match.player_2}</td>
                      <td><span class="${class_home_name}">${match.home_odd}</span></td>
                      <td><span class="${class_away_name}">${match.away_odd}</span></td>
                      <td>${match.result}</td>
                      <td>${match.correct_score}</td>
                      <td>${match.home_total}</td>
                      <td>${match.away_total}</td>
                      <td>${match.both_total}</td>
                      <td>${match.event_date}</td>
                      <td><a href="/view_similar_matches/${match.id}" target="_blank"><i class="fa fa-eye"></i></a></td>
                      </tr>
                    `;
            icon = ``;
            icon_2 = ``;
          });
          table += tr;
          table += `</tbody></table>`;
          $('#table_result_count').html(`<h3>${myObj.length}</h3>`);
          $('#table_search_result').html(table);
        });
    }

    $(document).ready( function () {
          setInterval('updateClock()', 1000);
          var table = $('#match_today_table_id').DataTable();
          var table_2 = $('#match_results_table_id').DataTable()
    } );

  </script>
</body>

</html>