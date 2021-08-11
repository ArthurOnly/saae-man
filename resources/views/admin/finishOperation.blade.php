@extends('template')

@section('body')
    <div class="container mx-auto py-24 px-8 max-w-lg">
        <h1 class="text-4xl text-bold">Deseja finalizar a operação N: {{$order}}?</h1>
        <form method="POST" action="" class="mt-8 flex flex-col gap-8">
            @csrf
            <button type="submit" class="bg-blue-800 p-4">Finalizar</button>
        </form>
    </div>
@endsection
