@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Person Location Report</div>

                    <div class="card-body">
                            <div id="map" style="width: 100%; height: 400px"></div>
                            <form id="locations_report_form" action="{{ route('locations-report') }}">
                                <div class="form-group">
                                    <label for="report-date">Date:</label>
                                    <input type="text" class="form-control datepicker" id="date" name="report-date"/>
                                </div>

                                <div class="form-group">
                                    <label for="city_id">Person to Track:</label>
                                    <select class="form-control" name="person_id" id="person_id">
                                        @foreach ($people as $people)
                                            <option value="{{$people->id}}">{{$people->fullName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        let myMap;

        (function initDates() {
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: new Date(),
            }).datepicker("setDate", new Date());
        })();


        function getPersonData(person_id, date, displayCallback) {
            const url = '/person-locations/' + person_id + '/date/' +  date;
            console.log(url);
            $.getJSON(url).done(function(data) {
                displayCallback(data);
                console.log(data);
            });
        }


        function displayRoute(personData)
        {
            myMap.geoObjects.removeAll();
            if (!personData[0].person_locations.length) {
                let center = [personData[0].city.latitude, personData[0].city.longitude];
                console.log(center);
                myMap.setCenter(center, 17);
            } else {

                if (personData[0].person_locations.length == 1) {
                    myMap.geoObjects.add(new ymaps.Placemark([personData[0].person_locations[0].latitude,
                        personData[0].person_locations[0].longitude], {
                        balloonContent: personLocationBalloonText(personData[0].person_locations[0])
                    }));
                    console.log('Center for one point only');
                    console.log([
                        personData[0].person_locations[0].latitude,
                        personData[0].person_locations[0].longitude
                    ]);
                    myMap.setCenter([
                        personData[0].person_locations[0].latitude,
                        personData[0].person_locations[0].longitude
                    ], 17);
                    return;
                }

                let locations = personData[0].person_locations.map(function(point) {
                   return [point.latitude, point.longitude]
                });

                console.log('Locations:');
                console.log(locations);

                ymaps.route(
                 locations,
                    {
                        mapStateAutoApply: true
                    }).
                 then(function (route) {
                        //change center, maybe cities are changed
                        console.log('building route');

                        myMap.geoObjects.add(route);
                        let len = locations.length;
                        for (let i = 0; i < len; i++) {
                            route.getWayPoints().get(i).properties.set({
                                balloonContent: personLocationBalloonText(personData[0].person_locations[0])
                            });
                        }
                    });
            }
        }

        function personLocationBalloonText(personLocation) {
           return personLocation.latitude + ',' +
               personLocation.longitude + '</br/>'
            + 'Time:' + personLocation.created_at;
        }

        ymaps.ready(init);

        function init() {
            myMap = new ymaps.Map('map', {
                center: [0, 0],
                zoom: 17
            });

            getPersonData($('#person_id').val(), $.trim($('#date').val()), displayRoute);

            $('#date').change(function() {
                getPersonData($('#person_id').val(), $.trim($('#date').val()), displayRoute);
            });


            $('#person_id').change(function() {
                getPersonData($('#person_id').val(), $.trim($('#date').val()), displayRoute);
            });
        };

    });
</script>
@endsection