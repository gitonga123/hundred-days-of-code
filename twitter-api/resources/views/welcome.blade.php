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

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
    {{-- <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">About</h4>
          <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Contact</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div> --}}
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
        <a class="nav-link d-flex text-danger" href="/today/matches">Today Matches</a>
      </div>
    </div>
  </header>

  <main>

    <section class="py-2 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-12 col-md-12 mx-auto">
          <form class="row row-cols-lg-auto g-3 align-items-center" method="POST"
            action="/search_match_records/score_home" autocompletete="off">
            @csrf
            <div class="col-12">
              <label class="visually-hidden" for="inlineFormInputGroupUsername">Home</label>
              <div class="input-group">
                <input name="home_odd" type="text" class="form-control" autocomplete="off"  placeholder="Home" aria-label="Home" value="{{$request->home_odd}}" x-webkit-speech>
              </div>
            </div>
            <div class="col-12">
              <label class="visually-hidden" for="inlineFormInputGroupUsername">Away</label>
              <div class="input-group">
                <input name="away_odd" type="text" class="form-control" autocomplete="off"  placeholder="Away" aria-label="Away" value="{{$request->away_odd}}">
              </div>
            </div>

            <div class="col-12">
              <label class="visually-hidden" for="inlineFormSelectPref">Competition</label>
              <select class="form-select" id="inlineFormSelectPref" name="competition">
                <option selected>Choose...</option>
                @foreach ($competition as $comp)
                <option value="{{$comp->competition}}"@if($request->competition == $comp->competition)selected @endif>{{$comp->competition}}</option>
                @endforeach
              </select>
            </div>
              <div class="col-6">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Exected Home</label>
                <div class="input-group">
                  <input name="expected_value_home" type="text" class="form-control" autocomplete="off"  placeholder="Exected Home" aria-label="Away" value="{{$request->expected_value_home}}">
                </div>
              </div>
              <div class="col-6">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Actual Home</label>
                <div class="input-group">
                  <input name="actual_value_home" type="text" class="form-control" autocomplete="off"  placeholder="Actual Home" aria-label="Away" value="{{$request->actual_value_home}}">
                </div>
              </div>
              <div class="col-6">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Expected Away</label>
                <div class="input-group">
                  <input name="expected_value_away" type="text" class="form-control" autocomplete="off"  placeholder="Expected Away" aria-label="Away" value="{{$request->expected_value_away}}">
                </div>
              </div>
              <div class="col-6">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Actual Away</label>
                <div class="input-group">
                  <input name="actual_value_away" type="text" class="form-control" autocomplete="off"  placeholder="Actual Away" aria-label="Away" value="{{$request->actual_value_away}}">
                </div>
              </div>
              <div class="col-6">
                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                  <input type="hidden" name="include_all" value="0"/>
                  <input name="include_all" type="checkbox" class="custom-control-input" id="customControlInline" value="1">
                  <label class="custom-control-label" for="customControlInline">Include All</label>
                </div>
              </div>
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
          </form>
        </div>
    </section>
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row row-cols-12 row-cols-sm-12 row-cols-md-12">
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <table class="table table-striped table-hover" id="match_results_table_id">
                  <thead>
                    <tr>
                      <th scope="col">H Team</th>
                      <th scope="col">A Team</th>
                      <th scope="col">Home</th>
                      <th scope="col">Away</th>
                      <th scope="col">H %</th>
                      <th scope="col">A %</th>
                      <th scope="col">Result</th>
                      <th scope="col">Score</th>
                      <th scope="col">Event Date</th>
                      <th scope="col">Both Total</th>
                      <th scope="col">Competition</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($records as $match)
                    <tr>
                      <td>{{$match->player_1}}</td>
                      <td>{{$match->player_2}}</td>
                      <td>{{$match->home_odd}}
                        @if ($match->home_change == "-1")
                        <i class="fa fa-sort-down text-danger"></i>
                        @endif
                        @if ($match->home_change == "1")
                        <i class="fa fa-sort-up text-success"></i>
                        @endif
                        @if ($match->home_change == "0")
                        @endif

                      </td>
                      <td>{{$match->away_odd}}
                        @if ($match->away_change == "-1")
                        <i class="fa fa-sort-down text-danger"></i>
                        @endif
                        @if ($match->away_change == "1")
                        <i class="fa fa-sort-up text-success"></i>
                        @endif
                        @if ($match->away_change == "0")
                        @endif
                      </td>
                      <td>{{$match->expected_value_home}} - <span @if ($match->winner_home) class="gOTTkb" @endif>{{$match->actual_value_home}}</span></td>
                      <td>{{$match->expected_value_away}} - <span @if ($match->winner_away) class="gOTTkb" @endif>{{$match->actual_value_away}}</span></td>
                      <td>{{$match->result}}</td>
                      <td>{{$match->correct_score}}</td>
                      <td>{{$match->event_date}}</td>
                      <td>{{$match->both_total}}</td>
                      <td>{{$match->competition}}</td>
                    </tr>
                    @endforeach

                  </tbody>
                  <tfoot>
                    <tr>
                      <th scope="col">Home Team</th>
                      <th scope="col">Away Team</th>
                      <th scope="col">Home</th>
                      <th scope="col">Away</th>
                      <th scope="col">Home %</th>
                      <th scope="col">Away %</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row row-cols-12 row-cols-sm-12 row-cols-md-12">
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    
                    <span id="today_matches"></span>
                  </div>
                  <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">{{$total_records}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
    $(document).ready( function () {
          setInterval('updateClock()', 1000);
          $('#match_results_table_id tfoot th').each( function () {
              var title = $(this).text();
              if (title) {
                $(this).html( '<input type="text" size="4" />' );
              }
          } );

          var table = $('#match_results_table_id').DataTable({
                initComplete: function () {
                    // Apply the search
                    this.api().columns().every( function () {
                        var that = this;
        
                        $( 'input', this.footer() ).on( 'keyup change clear', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                }
            });
      } );

  </script>
</body>

</html>