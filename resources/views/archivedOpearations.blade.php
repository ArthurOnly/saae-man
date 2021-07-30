@extends('template')

@section('body')
    <div class="container mx-auto py-24">
        <div class="flex w-full">
            <h1 class="text-4xl font-bold">Procedimentos</h1>
        </div>
        <table class="mt-8 min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">O. de serviço</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Responsável</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Endereço</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Data</th>
                </tr>
            <thead>
            @if (isset($message))
                <p>Sim</p>
            @endif
            <tbody class="bg-gray-600 divide-y divide-gray-600 w-full">
                @foreach ($all_operations as $operation)
                    <tr>
                        <td scope="col" class="px-6 py-4 whitespace-nowrap">
                            {{$operation->order}}
                        </td>
                        <td scope="col" class="px-6 py-4 whitespace-nowrap">
                            {{$operation->email}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{$operation->address}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{$operation->created_at}}
                        </td>
                    </tr>
                @endforeach
            <tbody>
        <table>
    </div>
@endsection
