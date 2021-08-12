@extends('template')

@section('body')
    <main class="h-screen w-screen flex flex-col">
        <section class="h-1/2 w-full p-12 lg:h-full lg:w-1/2">
            <h1 class="text-5xl font-bold">Sistema de controle SAAE</h1>
        </section>
        <section class="h-1/2 w-full lg:h-full lg:w-1/2">
            <div class="d-flex flex-col p-12 w-full max-w-4xl">
                <a class="bg-blue-800 p-4 w-full block" href={{route("login")}}>Entrar como funcionário</a>
                <a class="bg-blue-800 p-4 w-full mt-8 block" href={{route("cliente.cadastrar")}}>Cadastrar cliente</a>
            </div>
        </section>
    </main>
@endsection


