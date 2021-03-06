<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Ciudad;
use App\Http\Requests\UsuarioFormRequest;
use App\Pais;
use App\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function __construct()
    {
        // LSL PARA LA VALIDACION
        $this->middleware('auth');
        //$this->foo = $foo;
    }

    public function getEstadosByPais(Request $request)
    {
        if ($request->ajax()) {
            $estados     = Estado::where('pais_id', $request->pais_id)->get();
            $estadoArray = array();
            foreach ($estados as $estado) {
                $estadoArray[$estado->id] = $estado->nombre;
            }

            return response()->json($estadoArray);
        }
        //
    }



    public function getCiudadesByEstado(Request $request)
    {
        if ($request->ajax()) {
            $ciudades     = Ciudad::where('estado_id', $request->estado_id)->get();
            $valorArray = array();
            foreach ($ciudades as $ciudad) {
                $valorArray[$ciudad->id] = $ciudad->nombre;
            }

            return response()->json($valorArray);
        }
        //
    }





    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('search'));
            $usuarios = Usuario::where('usua_nombre', 'LIKE', '%' . $query . '%')->orderBy('usua_nombre', 'asc')->paginate(3);

            return view('usuarios.index', ['usuarios' => $usuarios, 'search' => $query]);

        }
        //$usuarios = Usuario::all();
        //return view('usuarios.index',['usuarios' => $usuarios]);
    }

    public function show($id)
    {
        return view('usuarios.show', ['usuario' => Usuario::findOrFail($id)]);
    }

    public function create()
    {

        $paises = Pais::all();

        return view('usuarios.create', ['paises' => $paises]);

    }

    public function store(UsuarioFormRequest $request)
    {
        $usuario                 = new Usuario();
        $usuario->usua_nombre    = $request->get('nombre');
        $usuario->usua_email     = $request->get('email');
        $usuario->usua_direccion = $request->get('direccion');
        $usuario->pais_id        = $request->get('pais');
        $usuario->usua_code_zip  = $request->get('zip');

        $usuario->usua_f_nacimiento = date_create();
        $usuario->save();

        return redirect('/usuarios');
    }

    public function edit($id)
    {
        $paises = Pais::all();

        return view('usuarios.edit', ['usuario' => Usuario::findOrFail($id), 'paises' => $paises]);
    }

    public function update(UsuarioFormRequest $request, $id)
    {

        $usuario                 = Usuario::findOrFail($id);
        $usuario->usua_nombre    = $request->get('nombre');
        $usuario->usua_email     = $request->get('email');
        $usuario->usua_direccion = $request->get('direccion');
        $usuario->pais_id        = $request->get('pais_id');

        $usuario->update();

        return redirect('/usuarios');

    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->delete();

        return redirect('/usuarios');

    }

}
