@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div id="map" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    let myMap;
    let peopleLocations = {!! json_encode($peopleLocations->toArray(), JSON_HEX_TAG) !!};

    function init() {
      myMap = new ymaps.Map('map', {
          center: [54.782, 32.04],
          zoom: 17
      });

      display(peopleLocations);
    };

    function display(people) {
        const len = people.length;

        for (let i = 0; i < len; i++) {
            myMap.geoObjects.add(new ymaps.Placemark([people[i].latitude, people[i].longitude], {
                balloonContent: 'Name:' + people[i].first_name + ' ' + people[i].second_name
                    + ' ' + people[i].last_name + '<br/>' + 'Email: ' + (people[i].email ? people[i].email : '') +
                    '<br/>' + 'Phone: ' + (people[i].phone ? people[i].phone : '') + '</br/>' + 'Last coordinated: ' + '[' + people[i].latitude + ',' + people[i].longitude + ']'
            }, {
                preset: 'islands#circleIcon',
                iconColor: '#3caa3c'
            }));
        }

        if (people.length) {
            let container = $('#map');
            let bounds = myMap.geoObjects.getBounds();
            let centerAndZoom = ymaps.util.bounds.getCenterAndZoom(bounds, [container.width(), container.height()]);
            myMap.setCenter(centerAndZoom.center, centerAndZoom.zoom);
        }
    }

    ymaps.ready(init);
});

</script>

@endsection
