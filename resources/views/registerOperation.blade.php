@extends('template')

@section('body')
    <div class="container mx-auto py-24 px-8 max-w-lg">
        <h1 class="text-4xl text-bold">Registrar operação</h1>
        <form method="POST" action="" class="mt-8 flex flex-col gap-8">
            @csrf
            <div class="flex flex-col gap-4">
                <label>Ordem de serviço:</label>
                <input type="text" name="ordem">
            </div>
            <div class="flex flex-col gap-4">
                <label>Inscrição:</label>
                <input type="text" name="inscricao">
            </div>
            <div class="flex flex-col gap-8 lg:flex-row">
                <div class="flex flex-col gap-4 flex-grow-3 w-full">
                    <label>Rua:</label>
                    <input type="text" name="rua">
                </div>
                <div class="flex flex-col gap-4 flex-grow-1 w-full">
                    <label>Número:</label>
                    <input type="text" name="numero">
                </div>
            </div>
            <button type="submit" class="bg-blue-800 p-4">Cadastrar</button>
        </form>
    </div>
@endsection
