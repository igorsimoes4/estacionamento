@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('plugins.Chartjs', true)

@section('title', 'Painel')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$car_parking}}</h3>
                            <p>Carros Estacionados</p>
                        </div>
                        <div class="icon"><i class="fa fa-fw fa-car"></i></div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$moto_parking}}</h3>
                            <p>Motos Estacionadas</p>
                        </div>
                        <div class="icon"><i class="fa fa-fw fa-motorcycle"></i></div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$caminhonete_parking}}</h3>
                            <p>Caminhonetes Estacionadas</p>
                        </div>
                        <div class="icon"><i class="fa fa-fw fa-car"></i></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Grafico de Veiculos mais estacionados</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="carPie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            let ctx = document.getElementById('carPie').getContext('2d');
            window.carPie = new Chart(ctx, {
                type: 'pie',
                labels: {!! $CarLabels !!},
                data: {
                    datasets: [{
                        data: {{$CarValues}},
                        backgroundColor: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Black', 'Brown']
                    }],
                },
                options: {
                    responsive: true,
                    legend: {
                        display: true
                    }
                }
            });
        }
    </script>

@endsection
