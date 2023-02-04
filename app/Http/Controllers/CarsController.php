<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        $cars = Cars::paginate(6);

        $data['cars'] = $cars;

        return view('cars', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'modelo',
            'placa',
            'entrada',
            'tipo_car'
        ]);

        $validator = Validator::make($data, [
            'modelo' => ['required', 'string'],
            'placa' => ['required', 'string'],
            'entrada' => ['required'],
            'tipo_car' => ['required', 'string']
        ]);

        if($validator->fails()) {
            return redirect(route('cars.create'))->withErrors($validator)->withInput();
        }

        $car = new Cars();
        $car->modelo = $data['modelo'];
        $car->placa = $data['placa'];
        $car->entrada = $data['entrada'];
        $car->tipo_car = $data['tipo_car'];
        $car->preco = 0;
        $car->save();

        return redirect(route('cars.index'))->with('create', 'Carro adicionado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Cars::find($id);

        if($car) {
            return view('cars_edit', ['car' => $car]);
        }

        return redirect(route('cars.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Cars::find($id);

        if($car) {
            $car['preco2'] = number_format($car['preco'], 2, ',', '.');
            return view('cars_edit', ['car' => $car]);
        }

        return redirect(route('cars.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
