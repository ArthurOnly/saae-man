@extends('template')


@section('body')
    <div class="container mx-auto py-24 px-4">
        <div class="flex w-full">
            <h1 class="text-4xl font-bold">Clientes</h1>
        </div>
        <form class="form-inline" method="GET">
        <div class="form-group mb-2 mt-2">
            <input type="text" class="form-control text-black" id="filter" name="filter" placeholder="Buscar por nome..." value="{{$filter}}">
            <button type="submit" class="btn btn-default mb-2 bg-blue-800 p-2 ml-0">Buscar</button>
        </div>
        </form>
        <table class="mt-8 min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider hidden md:flex">@sortablelink('name', 'Nome')</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">@sortablelink('subscription', 'N. Inscrição')</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Ações</th>
                </tr>
            <thead>
            <tbody class="bg-gray-600 divide-y divide-gray-600 w-full">
                @foreach ($clients as $client)
                    <tr>
                        <td scope="col" class="px-6 py-4 whitespace-nowrap">
                            {{$client->name}}
                        </td>
                        <td scope="col" class="px-6 py-4 whitespace-nowrap hidden md:flex">
                            {{$client->subscription}}
                        </td>
                        <td class="px-6 py-4">
                            <a href={{route("client.edit", $client->id)}}>Editar</a>
                            <form class="inline" action='{{route("client.destroy", $client->id)}}' onsubmit='return confirm("Tem certeza que quer deletar o cliente?")' method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="ml-2" type="submit">Excluir</a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            <tbody>
        <table>
        <div class="mt-4">
            {{ $clients->links() }}
        </div>
    </div>
@endsection
