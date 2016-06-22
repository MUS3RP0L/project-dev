<?php

namespace Muserpol\Http\Controllers;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\Rol;
use Muserpol\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('admin')) {
        return view('usuarios.index');
        }else{
            return redirect('/');
        }
    }

    public function UsuariosData()
    {

        $users = User::select(['id','username', 'ape', 'nom', 'tel','rol_id','status'])->where('id', '>', 1);

        return Datatables::of($users)->addColumn('name', '{{$ape}} {{$nom}}')
                ->addColumn('type', function ($user) { return $user->rol->name; })
                ->addColumn('action', function ($user) {
                return $user->status == "Activo" ? 
                        '<div class="text-center"><a href="usuario/'.$user->id.'/edit" > <i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        <a href="usuario/block/'.$user->id.'" > <i class="glyphicon glyphicon-ban-circle"></i></a></div>'
                        :
                        '<div class="text-center"><a href="usuario/'.$user->id.'/edit" > <i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        <a href="usuario/unblock/'.$user->id.'" > <i class="glyphicon glyphicon-ok-circle"></i></a></div>';
            })
            
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getViewModel()
    {
        $roles = Rol::all();
        $list_roles = array('' => '');
        foreach ($roles as $item) {
             $list_roles[$item->id]=$item->name;
        }
        return [
            'list_roles' => $list_roles
        ];
    }

    public function create()
    {
        if (Auth::user()->can('admin')) {
        return view('usuarios.create', self::getViewModel());
        }else{
            return redirect('/');
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $user = User::idIs($id)->first();
        $data = [
            'user' => $user
        ];
        $data = array_merge($data, self::getViewModel());

        return View('usuarios.edit', $data);
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

        return $this->save($request, $id);
    }

    public function save($request, $id = false)
    {

        if ($id) {
            $rules = [
                'ape' => 'required|min:3|regex:/^[A-ZÑa-záéíóúàèìòùäëïöüñ\s]+$/i',
                'nom' => 'required|min:3|regex:/^[A-ZÑa-záéíóúàèìòùäëïöüñ\s]+$/i',
                'tel' => 'required|min:8|numeric',
                'username' => 'required|unique:users,username,'.$id,
                'rol' => 'required'
            ];
        }
        else{ 
            $rules = [
                'ape' => 'required|min:3|regex:/^[A-ZÑa-záéíóúàèìòùäëïöüñ\s]+$/i',
                'nom' => 'required|min:3|regex:/^[A-ZÑa-záéíóúàèìòùäëïöüñ\s]+$/i',
                'tel' => 'required|min:8|numeric',
                'username' => 'required|unique:users,username',
                'password' => 'required|min:6|confirmed',
                'rol' => 'required'
            ];
        } 
        
        $messages = [
            'ape.required' => 'El campo apellidos es requerido',
            'ape.min' => 'El mínimo de caracteres permitidos en apellido es 3', 
            'ape.regex' => 'Sólo se aceptan letras para apellidos',

            'nom.required' => 'El campo nombre requerido',
            'nom.min' => 'El mínimo de caracteres permitidos en nombre es 3',
            'nom.regex' => 'Sólo se aceptan letras para nombre',

            'tel.required' => 'El campo teléfono es requerido',
            'tel.min' => 'El mínimo de caracteres permitidos en teléfono de usuario es 8',
            'tel.numeric' => 'El campo teléfono tiene q ser númerico',

            'username.required' => 'El campo nombre de usuario requerido',
            'username.min' => 'El mínimo de caracteres permitidos en nombre de usuario es 5',
            'username.unique' => 'El nombre de usuario ya existe',

            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'El mínimo de caracteres permitidos en contraseña es 6',
            'password.confirmed' => 'Las contraseñas no coinciden',

            'rol.required' => 'El campo contraseña es requerido'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect($id ? 'usuario/'.$id.'/edit' : 'usuario/create')
            ->withErrors($validator)
            ->withInput();
        }
        else{

            if ($id) {
                $user = User::idIs($id)->first();
            } else {
                $user = new User();
            }   

            $user->ape = trim($request->ape);
            $user->nom = trim($request->nom);
            $user->tel = trim($request->tel);
            $user->username = trim($request->username);
            if($request->password){$user->password = trim(bcrypt($request->password));}
            $user->rol_id = trim($request->rol); 
            $user->save();

            if ($id) {
                $message = "Usuario Actualizado con éxito";
            } else {
                $message = "Usuario Creado con éxito";
            }

            Session::flash('message', $message);
        }
        
        return redirect('usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $user = User::idIs($id)->first();
        $user->status = "Inactivo";
        $user->save();

        $message = "Usuario Inactivado";
        Session::flash('message', $message);
        return redirect('usuario');
    }

    public function unBlock($id)
    {
        $user = User::idIs($id)->first();
        $user->status = "Activo";
        $user->save();

        $message = "Usuario Activado";
        Session::flash('message', $message);
        return redirect('usuario');
    }
}
