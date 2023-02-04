@extends('adminlte::page')

@section('title', 'Nova Página')

@section('content_header')
    <h1 style="display: flex; justify-content:space-between; padding: 0 20px 0 20px; margin-bottom:10px;">
        Adicionar Veículo

    </h1>
@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"/>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js">
    $(document).ready(function(){
            $('.placa').inputmask('(999)-999-9999');
    });
</script>
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
                            <input type="text" name="modelo" value="{{old('modelo')}}" class="form-control @error('modelo') is-invalid @enderror" />
                        </div>

                </div>

                <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="">Placa do Carro</label>
                        <div class="col-sm-10">
                            <input type="text" id="placa" name="placa" data-mask="YYY-YYYY" data-mask-selectonfocus="true" value="{{old('placa')}}" class="form-control @error('placa') is-invalid @enderror" />
                        </div>

                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="">Hora Atual</label>
                    <div class="col-sm-10">
                        @php
                            $data_atual = new DateTime();
                            $data_atual = $data_atual->format('d/m/Y H:i');
                        @endphp
                        <input type="datetime-local" autocomplete="" name="entrada" value="{{old('entrada')}}" class="form-control @error('entrada') is-invalid @enderror" />
                    </div>

                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="">Escolha o tipo de Veiculo</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipo_car">
                            <option value="carro" selected>Carro</option>
                            <option value="moto">Moto</option>
                            <option value="caminhonete">Caminhonete</option>
                        </select>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js">
        $(document).ready(function(){
                $('.placa').inputmask('(999)-999-9999');
        });
    </script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>


@endsection
