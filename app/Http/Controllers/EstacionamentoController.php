<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\Estacionamento;
use DateTime;
use Illuminate\Http\Request;

class EstacionamentoController extends Controller
{
    public function index() {
        $data = [];

        $car_parking = Cars::where('tipo_car', 'carro')->count();
        $moto_parking = Cars::where('tipo_car', 'moto')->count();
        $caminhonete_parking = Cars::where('tipo_car', 'caminhonete')->count();

        $cars = Cars::paginate(10);

        $carPie = [];
        $interval = intval(30);
        $dateInterval = date('Y-m-d H:i:s', strtotime('-'.$interval.' days'));

        $cars_all = Cars::selectRaw('tipo_car, count(tipo_car) as c')->where('created_at', '>=', $dateInterval)->groupBy('tipo_car')->get();

        foreach($cars_all as $car) {
            $carPie[ $car['tipo_car'] ] = intval($car['c']);

        }

        $CarLabels = json_encode(array_keys($carPie));
        $CarValues = json_encode(array_values($carPie));
        $data['cars'] = $cars;

        $data['CarLabels'] = $CarLabels;
        $data['CarValues'] = $CarValues;

        $data['car_parking'] = $car_parking;
        $data['moto_parking'] = $moto_parking;
        $data['caminhonete_parking'] = $caminhonete_parking;
        return view('home', $data);
    }

}
