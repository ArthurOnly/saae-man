@extends('template')

@section('body')
    <div class="container mx-auto py-24 px-8 max-w-lg">
        <h1 class="text-4xl text-bold">Registrar operação</h1>
        <form method="POST" action="" class="mt-8 flex flex-col gap-8">
            @csrf
            <div class="flex flex-col gap-4">
                <label>Ordem de serviço:</label>
                <input value="{{ old('order', $operation ? $operation->order : null) }}" required class="text-black" type="text" name="order">
            </div>
            <div class="flex flex-col gap-4">
                <label>Inscrição:</label>
                <input value="{{ old('subscription', $operation ? $operation->subscription : null) }}" required class="text-black" type="text" name="subscription">
            </div>
            <div class="flex flex-col gap-4">
                <label>Tipo:</label>
                <select required class="text-black" type="text" name="operation_type">
                    @foreach ($operation_types as $type)
                        <option selected="{{ old('operation_type', $operation ? $operation->operation_type : null) == $type["id"] }}" value={{$type["id"]}}>{{$type["name"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-8 lg:flex-row">
                <div class="flex flex-col gap-4 flex-grow-3 w-full">
                    <label>Rua:</label>
                    <input value="{{ old('street', $address ? $address[0] : null) }}" required class="text-black" type="text" name="street">
                </div>
                <div class="flex flex-col gap-4 flex-grow-1 w-full">
                    <label>Número:</label>
                    <input value="{{ old('number', $address ? $address[1] : null) }}" required class="text-black" type="text" name="number">
                </div>
            </div>
            <div class="flex flex-col gap-8 lg:flex-row">
                <div class="flex flex-col gap-4 flex-grow-3 w-full">
                    <label>Latitude (opcional):</label>
                    <input value="{{ old('lat', $operation ? $operation->lat : null) }}" class="text-black" type="text" name="lat">
                </div>
                <div class="flex flex-col gap-4 flex-grow-1 w-full">
                    <label>Logintude (opcional):</label>
                    <input value="{{ old('long', $operation ? $operation->long : null) }}" class="text-black" type="text" name="long">
                </div>
            </div>
            <button type="submit" class="bg-blue-800 p-4">Cadastrar</button>
        </form>
    </div>
@endsection
