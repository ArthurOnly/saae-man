@extends('template')

@section('body')
    <div class="container mx-auto py-24 px-8 max-w-lg">
        <h1 class="text-4xl text-bold">Registrar cliente</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="" class="mt-8 flex flex-col gap-8">
            @csrf
            <div class="flex flex-col gap-4">
                <label>Nome:</label>
                <input value="{{ old('name') }}" required class="text-black" type="text" name="name">
            </div>
            <div class="flex flex-col gap-4">
                <label>Telefone:</label>
                <input value="{{ old('phone') }}" required class="text-black" type="text" name="phone">
            </div>
            <div class="flex flex-col gap-4">
                <label>Inscrição:</label>
                <input value="{{ old('subscription') }}" required class="text-black" type="text" name="subscription">
            </div>

            <button type="submit" class="bg-blue-800 p-4">Cadastrar</button>
        </form>
    </div>
@endsection
