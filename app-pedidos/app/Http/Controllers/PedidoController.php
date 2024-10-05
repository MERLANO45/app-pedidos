<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Exception;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ped = Pedido::orderBy('idPedido', 'desc')->get();
        return view('Pedidos.index')->with('pedidos', $ped);
    }

    /* Get Data Pedidos */
    public function getDataPedidos()
    {
        $ped = Pedido::all();
        $data = [
            [
                'id' => 1,
                'producto' => 'Cerveza Aguila',
                'cantidad' => 100,
                'precio' => 2500,
                'fecha' => '2024-10-02',
            ],
            [
                'id' => 2,
                'producto' => 'Arroz Diana',
                'cantidad' => 50,
                'precio' => 1200,
                'fecha' => '2024-10-01',
            ],
            [
                'id' => 3,
                'producto' => 'Gaseosa Coca-Cola 1.5L',
                'cantidad' => 30,
                'precio' => 4500,
                'fecha' => '2024-09-30',
            ],
            [
                'id' => 4,
                'producto' => 'Aceite Premier 1L',
                'cantidad' => 20,
                'precio' => 7500,
                'fecha' => '2024-09-28',
            ],
            [
                'id' => 5,
                'producto' => 'Harina PAN 1kg',
                'cantidad' => 10,
                'precio' => 3200,
                'fecha' => '2024-09-27',
            ],
        ];

        return response()->json(['data' => $ped]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_medicamento' => ['required', 'string'],
                'tipo_medicamento' => ['required', 'string'],
                'cantidad_producto' => ['required', 'int'],
                'distribuidor' => ['required', 'string']
            ]);
            $obj = new Pedido();
            $obj->fechaPedido = Controller::limpiarCadena((new \DateTime())->format('Y-m-d'));
            $obj->nombre_med = Controller::limpiarCadena(strtoupper($request->get('nombre_medicamento')));
            $obj->tipo_med = Controller::limpiarCadena($request->get('tipo_medicamento'));
            $obj->cantidad = Controller::limpiarCadena($request->get('cantidad_producto'));
            $obj->proveedor_med =  Controller::limpiarCadena($request->get('distribuidor'));
            //Sucursal
            $sucursales = $request->get('sucursal');
            $f_principal = in_array('principal', $sucursales) ? true : false;
            $f_secundaria = in_array('secundaria', $sucursales) ? true : false;
            $obj->f_principal = $f_principal;
            $obj->f_secundaria = $f_secundaria;
            $obj->save();

            return redirect('/pedidos/');
        } catch (ValidationException $e) {
            Log::error('Error de consulta en la base de datos: ' . $e->getMessage());
            return redirect()->back()->withErrors('Hubo un error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Log::error('Error de consulta en la base de datos: ' . $e->getMessage());
            return redirect()->back()->withErrors('Hubo un error al realizar la consulta en la base de datos: ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            Log::error('Error en el servidor: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un error en el servidor.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PedidoModel  $pedidoModel
     * @return \Illuminate\Http\Response
     */
    public function show($pedidoModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PedidoModel  $pedidoModel
     * @return \Illuminate\Http\Response
     */
    public function edit($pedidoModel)
    {
        $pedido = Pedido::where('idPedido', $pedidoModel)->get();
        return view('Pedidos.edit')->with('p', $pedido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PedidoModel  $pedidoModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idPedido)
    {
        try {
            $request->validate([
                'nombre_medicamento' => ['required', 'string'],
                'tipo_medicamento' => ['required', 'string'],
                'cantidad_producto' => ['required', 'int'],
                'distribuidor' => ['required', 'string']
            ]);
            $idLimp = Controller::limpiarCadena($idPedido);
            $obj = Pedido::find($idLimp);
            $obj->nombre_med = Controller::limpiarCadena(strtoupper($request->get('nombre_medicamento')));
            $obj->tipo_med = Controller::limpiarCadena($request->get('tipo_medicamento'));
            $obj->cantidad = Controller::limpiarCadena($request->get('cantidad_producto'));
            $obj->proveedor_med =  Controller::limpiarCadena($request->get('distribuidor'));
            //Sucursal
            $sucursales = $request->get('sucursal');
            $f_principal = in_array('principal', $sucursales) ? true : false;
            $f_secundaria = in_array('secundaria', $sucursales) ? true : false;
            $obj->f_principal = $f_principal;
            $obj->f_secundaria = $f_secundaria;
            $obj->save();

            $id = $obj->idPedido;
            return redirect('/pedidos/' . $id . '/edit');
        } catch (ValidationException $ev) {
            Log::error('Error de consulta en la base de datos: ' . $ev->getMessage());
            return redirect()->back()->withErrors('Hubo un error al realizar la consulta en la base de datos: ' . $ev->getMessage())->withInput();
        } catch (QueryException $eq) {
            Log::error('Error de consulta en la base de datos: ' . $eq->getMessage());
            return redirect()->back()->withErrors('Hubo un error al realizar la consulta en la base de datos: ' . $eq->getMessage())->withInput();
        } catch (Exception $e) {
            Log::error('Error en el servidor: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un error en el servidor.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PedidoModel  $pedidoModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($idPedido)
    {
        $item = Pedido::find(Controller::limpiarCadena($idPedido));
        if ($item) {
            try {
                $item->delete();
                return response()->json(['message' => 'Elemento eliminado correctamente'], 200);
            } catch (QueryException $e) {
                return response()->json(['message' => 'Error en la ejecucion: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Elemento no encontrado'], 404);
        }
    }
}
