@extends('template')

@section('body')
    <div class="container mx-auto py-24 px-8 max-w-lg">
        <h1 class="text-4xl text-bold">Registrar cliente</h1>
        <form method="POST" action="" class="mt-8 flex flex-col gap-8">
            @csrf
            <div class="flex flex-col gap-4">
                <label>Nome:</label>
                <input value="{{ old('order') }}" required class="text-black" type="text" name="order">
            </div>
            <div class="flex flex-col gap-4">
                <label>Telefone:</label>
                <input value="{{ old('order') }}" required class="text-black" type="text" name="order">
            </div>
            <div class="flex flex-col gap-4">
                <label>Inscrição:</label>
                <input value="{{ old('subscription') }}" required class="text-black" type="text" name="subscription">
            </div>
            <button type="submit" class="bg-blue-800 p-4">Cadastrar</button>
        </form>
    </div>
@endsection
