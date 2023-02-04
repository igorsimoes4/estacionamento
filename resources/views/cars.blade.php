@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Painel')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"/>
    <meta http-equiv="refresh" content="300">
@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "600",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                    toastr.error('{{$error}}');
                @endforeach
            @endif
            @if (session('create'))
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "600",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.success('{{session('create')}}');
            @endif
            @if (session('delete_car'))
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "600",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.error('{{session('delete_car')}}');
            @endif

            function relogio() {
                var data = new Date();
                var hora = data.getHours();
                var minuto = data.getMinutes();
                var segundo = data.getSeconds();

                if(hora < 10) {
                    hora = "0"+hora;
                }
                if(minuto < 10) {
                    minuto = "0"+minuto;
                }
                if(segundo < 10) {
                    segundo = "0"+segundo;
                }

                var horas = hora+":"+minuto+":"+segundo;
                document.getElementById("rel").value=horas;
            }

            var tempo = setInterval(relogio,1000);

    </script>
@endsection

@section('content_header')
    <h1 style="display: flex; justify-content:space-between; padding: 0 20px 0 20px; margin-bottom:10px;">
        Veículos no Estacionamento
        <a class="btn btn-md btn-success" href="{{route('cars.create')}}"><i style="margin-right: 5px; font-size:15px;" class="fa fa-plus-circle" aria-hidden="true"></i>  Adicionar Veículo</a>
    </h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <input disabled style="text-align: center; font-size: 50px; border:none; background-color:#fff;" class="form-control form-control-lg" type="text" id="rel">
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-3">
                    <form action="">
                        @csrf
                        <div class="input-group">
                            <input type="search" class="form-control form-control-lg" placeholder="Digite a Placa">
                            <div class="input-group-append">
                                <button class="btn btn-lg btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Modelo</th>
                            <th>Placa</th>
                            <th>Hora Entrada</th>
                            <th>Total Estacionado</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                        @php
                            date_default_timezone_set('America/Sao_Paulo');
                            $saida = new DateTime();
                            $entrada = new DateTime($car->created_at);
                            $tempo = $entrada->diff($saida);

                            $hora = (($saida->getTimestamp() - $entrada->getTimestamp()) / 60) / 60;
                            $minuto = ($saida->getTimestamp() - $entrada->getTimestamp()) / 60;

                            if($car->tipo_car == 'carro') {
                                if(round($hora / 24) >= 1) {
                                    $result_day = round($hora / 24) * 50;
                                    if($tempo->d > 1) {
                                        if($tempo->h > 1) {
                                            $result = ((($tempo->h - 1) * 5) + $result_day) + 17;
                                        }
                                        if($tempo->h < 1) {
                                            if($tempo->i < 30) {
                                                $result = $result_day + 10;
                                            }
                                        }
                                    }else {
                                        $result = (($tempo->h - 1) * 5) + 17;
                                    }
                                }else {
                                    if($tempo->h > 1) {
                                        $result = (($tempo->h - 1) * 5) + 17;
                                    }elseif ($tempo->h < 1) {
                                        if($tempo->i < 30) {
                                            $result = 10;
                                        }elseif (($tempo->i > 30)) {
                                            $result = 17;
                                        }else {
                                            if($tempo->i > 60) {
                                                $temp = $minuto / 60;
                                                $result = ($tempo->i - 1) * 5;
                                            }
                                        }
                                    }
                                }
                            }

                            if($car->tipo_car == 'moto') {
                                if(round($hora / 24) >= 1) {
                                    $result_day = round($hora / 24) * 14;
                                    if($tempo->d > 1) {
                                        if($tempo->h > 1) {
                                            $result = ((($tempo->h - 1) * 1) + $result_day) + 8;
                                        }
                                        if($tempo->h < 1) {
                                            if($tempo->i < 30) {
                                                $result = $result_day + 5;
                                            }
                                        }
                                    }else {
                                        $result = (($tempo->h - 1) * 1) + 8;
                                    }
                                }else {
                                    if($tempo->h > 1) {
                                        $result = (($tempo->h - 1) * 1) + 8;
                                    }elseif ($tempo->h < 1) {
                                        if($tempo->i < 30) {
                                            $result = 5;
                                        }elseif (($tempo->i > 30)) {
                                            $result = 8;
                                        }else {
                                            if($tempo->i > 60) {
                                                $temp = $minuto / 60;
                                                $result = ($tempo->i - 1) * 1;
                                            }
                                        }
                                    }
                                }
                            }

                            if($car->tipo_car == 'caminhonete') {
                                if(round($hora / 24) >= 1) {
                                    $result_day = round($hora / 24) * 60;
                                    if($tempo->d > 1) {
                                        if($tempo->h > 1) {
                                            $result = ((($tempo->h - 1) * 5) + $result_day) + 20;
                                        }
                                        if($tempo->h < 1) {
                                            if($tempo->i < 30) {
                                                $result = $result_day + 15;
                                            }
                                        }
                                    }else {
                                        $result = (($tempo->h - 1) * 5) + 20;
                                    }
                                }else {
                                    if($tempo->h > 1) {
                                        $result = (($tempo->h - 1) * 5) + 20;
                                    }elseif ($tempo->h < 1) {
                                        if($tempo->i < 30) {
                                            $result = 15;
                                        }elseif (($tempo->i > 30)) {
                                            $result = 20;
                                        }else {
                                            if($tempo->i > 60) {
                                                $temp = $minuto / 60;
                                                $result = ($tempo->i - 1) * 5;
                                            }
                                        }
                                    }
                                }
                            }



                        @endphp
                            <tr>
                                <th>{{$car->tipo_car}}</th>
                                <th>{{$car->modelo}}</th>
                                <th>{{$car->placa}}</th>
                                <th>{{$car->entrada}}</th>
                                <th>
                                    @php
                                        if($tempo->d < 1) {
                                            if($tempo->h > 1) {
                                                echo $tempo->h;
                                                echo " horas ";
                                                echo $tempo->i;
                                                echo " minutos";
                                            }else {
                                                echo $tempo->i;
                                                echo " minutos";
                                            }
                                        }else {
                                            echo $tempo->d;
                                            echo " dias ";
                                            echo $tempo->h;
                                            echo " horas ";
                                            echo $tempo->i;
                                            echo " minutos";
                                        }
                                    @endphp

                                </th>
                                <th>R$ {{$result}},00</th>
                                <th width="300">
                                    <div class="row">
                                        <a style="margin-right: 5px;" id="teste" class="btn btn-sm btn-warning" href="{{route('cars.show', ['car' => $car->id])}}"><i style="margin-right: 5px; font-size:13px;" class="fas fa-solid fa-eye"></i> Visualizar</a>
                                        <a style="margin-right: 5px;" id="teste" class="btn btn-sm btn-danger" href="{{route('cars.edit', ['car' => $car->id])}}"><i style="margin-right: 5px; font-size:13px;" class="fas fa-solid fa-edit"></i> Finalizar</a>
                                        <form action="{{ route('pembayaran.print') }}" method="POST">
                                            <input type="hidden" name="tipo_car" value="{{$car->tipo_car}}" class="form-control">
                                            <input type="hidden" name="preco" value="{{$car->result}}" class="form-control">
                                            <input type="hidden" name="placa" value="{{$car->placa}}" class="form-control">
                                            <input type="hidden" name="entrada" value="{{$car->entrada}}" class="form-control">
                                            <input type="hidden" name="data" value="{{$entrada->format('d/m/Y')}}" class="form-control">
                                            <input type="hidden" name="hora" value="{{$entrada->format('H:i:s')}}" class="form-control">
                                            <input type="hidden" name="_token" class="form-control" value="{!! csrf_token() !!}">
                                            <button type="submit" name="submit" class="btn btn-sm btn-info"><i style="margin-right: 5px; font-size:13px;" class="fas fa-solid fa-print"></i> Imprimir</button>
                                        </form>
                                    </div>
                                </th>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div style="display: flex; justify-content:flex-end;padding: 0 20px 0 20px;">
                {{$cars->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>

@endsection
