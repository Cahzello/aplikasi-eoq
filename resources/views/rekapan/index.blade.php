@extends('main.main')

@section('container')
    <div class="card mx-4 my-4 p-4 card-shadow">

        <div class="card-shadow-mb4">
            <div class="card-header">
                <h1 class="h2 mb-4 text-gray-800">Data Rekapan Bahan Baku</h1>
                <p>Data Rekapan Bahan Baku Yang Telah Dibuat</p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="mx-4 my-4">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                        </div>

                    </div>
                @endif
            </div>
            <div class="card-body">
                @if (empty($responses->count()))
                    <div class="card mx-4 p-3 card-shadow">

                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <h1 class="h2 text-dark">Belum Ada Data.</h1>
                            <a href="/input-data">Klik disini untuk membuat data</a>
                        </div>
                    </div>
                @else
                    <div class="py-2 bg-body-tertiary">
                        <div class="container mx-0 ">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">

                                @foreach ($responses as $response)
                                    <div class="col my-2">
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <h3 class="card-title">Bahan Baku {{ $response->bahan_baku }}</h3>
                                                <p class="card-text">Dibuat Tanggal:
                                                </p>
                                                <p>{{$response->created_at->format('d F Y')}} </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <a href="{{ route('detail_rekapan', ['data' => $response]) }}"
                                                            class="btn btn-primary">Lihat Data</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>

                        </div>
                    </div>
                @endif
            </div>

        </div>


    </div>
@endsection
