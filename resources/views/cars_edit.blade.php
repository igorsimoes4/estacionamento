@extends('adminlte::page')

@section('title', 'Nova Página')

@section('content_header')
    <h1 style="display: flex; justify-content:space-between; padding: 0 20px 0 20px; margin-bottom:10px;">
        Editar Veículo
    </h1>
@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"/>
@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
    </script>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

            function exibemensagem() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                    Toast.fire({
                    icon: 'success',
                    title: 'Página Adicionada com sucesso'
                });
            };
    </script>
@endsection


@section('content')


    <div class="card">
        <div class="card-body">
            <form action="{{route('cars.store')}}" class="form-horizontal" method="POST">
                @csrf
                <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="">Modelo do Carro</label>
                        <div class="col-sm-10">
                            <input type="text" name="modelo" value="{{$car->modelo}}" class="form-control @error('modelo') is-invalid @enderror" />
                        </div>

                </div>

                <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="">Placa do Carro</label>
                        <div class="col-sm-10">
                            <input type="text" name="placa" value="{{$car->placa}}" class="form-control @error('placa') is-invalid @enderror" />
                        </div>

                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="">Hora de Entrada</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="entrada" value="{{$car->created_at}}" class="form-control @error('entrada') is-invalid @enderror" />
                    </div>

                </div>

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

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="">Escolha o tipo de Veiculo</label>
                    <div class="col-sm-10">

                        <select class="form-control" name="tipo_car">
                            <option value="carro" {{$car->tipo_car=='carro'?'selected="selected"':''}}>Carro</option>
                            <option value="moto" {{$car->tipo_car=='moto'?'selected="selected"':''}}>Moto</option>
                            <option value="caminhonete" {{$car->tipo_car=='caminhonete'?'selected="selected"':''}}>Caminhonete</option>
                        </select>
                    </div>

                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="">Tempo Estacionado</label>
                    <div class="col-sm-10">
                        <input type="text" disabled name="entrada" value="{{$tempo->format('%d dias %h horas %i minutos')}}" class="form-control @error('entrada') is-invalid @enderror" />
                    </div>

                </div>

                <div class="form-group row">



                    <label class="col-sm-2 col-form-label" for="">Preço</label>
                    <div class="col-sm-10">
                        <input type="price" value="{{$result}}" class="form-control @error('entrada') is-invalid @enderror">
                    </div>

                </div>

                <div class="form-group row">

                        <label class="col-sm-8 col-form-label" for=""></label>
                        <div class="col-sm-4">
                            <button class="btn btn-success form-control">
                                <i style="margin-right: 5px; font-size:15px;" class="fa fa-plus-circle" aria-hidden="true"></i> Adicionar
                            </button>
                        </div>

                </div>
            </form>
        </div>

    </div>


@endsection
