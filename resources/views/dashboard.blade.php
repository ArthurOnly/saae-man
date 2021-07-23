@extends('template')


@section('body')
    <div id='map' style='width: 100%; height: 500px;'></div>
    <div class="container mx-auto py-24">
        <h1 class="text-4xl font-bold">Procedimentos</h1>
        <table class="mt-8 min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Código<th>
                </tr>
            <thead>
            <tbody class="bg-gray-600 divide-y divide-gray-600 w-full">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        0002
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        0002
                    </td>
                </tr>
            <tbody>
        <table>
    </div>
@endsection
@section('js')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <script>
        function createPopup(text){
            // create the popup
            let popup = new mapboxgl.Popup({ offset: 25 }).setText(text);
                    
            // create DOM element for the marker
            let el = document.createElement('div');
            el.id = 'marker';

            return popup;
        }

        function createMarker(map, color, popup){
            var marker = new mapboxgl.Marker({
                color: color,
                draggable: true
            }).setLngLat([-35.42522, -5.64068]).setPopup(popup)
            .addTo(map);
        }
    </script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYXJ0aHVybWVkIiwiYSI6ImNrcmdvcHdjcjY4ZWUydm1uMGJla2c4a3MifQ.stihOlV05rOjNTYnQGjHnQ';
        var map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [-35.42522, -5.64068], // starting position [lng, lat]
            zoom: 13 // starting zoom
        });

        const popup = createPopup("Olá");
        createMarker(map, "red", popup)
    </script>
@endsection
