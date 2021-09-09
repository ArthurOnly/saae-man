@extends('template')


@section('body')
    <div id='map' style='width: 100%; height: 500px;'></div>
    <p>
    <span class="text-yellow-500">Religamento: Amarelo</span>, 
    <span class="text-blue-500">Religamento concluido: Azul</span>, 
    <span class="text-red-500">Desligamento: Vermelho</span>,
    <span class="text-green-500">Desligamento concluido: Verde</span></p>
    <div class="container mx-auto py-24">
        <div class="flex w-full">
            <h1 class="text-4xl font-bold">Procedimentos</h1>
            @if ($userType == 1)
                <a href="{{route('operation.create')}}" class="ml-auto px-6 py-3 font-semibold rounded-full bg-green-100 text-green-800">+ Inserir novo</a>
            @endif
        </div>
        <table class="mt-8 min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider hidden md:flex">Código</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">O. de serviço</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Endereço</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Tipo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Ações</th>
                </tr>
            <thead>
            @if (isset($message))
                <p>Sim</p>
            @endif
            <tbody class="bg-gray-600 divide-y divide-gray-600 w-full">
                @foreach ($all_operations as $operation)
                    <tr>
                        <td scope="col" class="px-6 py-4 whitespace-nowrap hidden md:flex">
                            {{$operation['subscription']}}
                        </td>
                        <td scope="col" class="px-6 py-4 whitespace-nowrap">
                            {{$operation['order']}}
                        </td>
                        <td class="px-6 py-4">
                            {{$operation['address']}}
                        </td>
                        <td class="px-6 py-4">
                            {{$operation['operation_type']["name"]}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{$operation['completed'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}}">
                            {{$operation['completed'] ? 'Finalizado' : 'A Realizar'}}
                        </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href={{route("operation.finish", $operation['id'])}}>Finalizar</a>
                            @if ($userType == 1)
                                <a class="ml-4" href={{route("operation.register", $operation['id'])}}>Editar</a>
                                <a class="ml-4" href={{route("operation.archive", $operation['id'])}}>Arquivar</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
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
            let popup = new mapboxgl.Popup({className: "text-black", offset: 25 }).setHTML(text);
                    
            // create DOM element for the marker
            let el = document.createElement('div');
            el.id = 'marker';

            return popup;
        }

        function createMarker(map, lat, long, color, popup){
            var marker = new mapboxgl.Marker({
                color: color,
                draggable: false
            }).setLngLat([long, lat]).setPopup(popup)
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

        const markers = JSON.parse(('{!! htmlspecialchars(json_encode($all_operations), ENT_QUOTES, 'UTF-8') !!}'.replace(/&quot;/g,'"')));
        markers.map(marker => {
            const baseUrl = "{!! url('operation/finish/') !!}"
            const mapsUrl = `https://www.google.com/maps?q=${marker.lat},${marker.long}`
            const text = `${marker.order} <br> Maps:<a href="${mapsUrl}">Clique aqui</a> <br> <a href="${baseUrl}/${marker.id}">Clique para finalizar</a>\n`
            const popup = createPopup(text);
            let color = marker.operation_type == 1 ? "yellow" : "red";
            if (marker.completed)
                color = color == "red" ? "green" : "blue"

            createMarker(map, marker.lat, marker.long, color, popup)
        })
    </script>
@endsection
