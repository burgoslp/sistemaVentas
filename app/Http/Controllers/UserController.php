<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users=User::latest()->paginate(10);
        return view('users.index',compact('users'));
    }

    public function create(Request $request){
        $roles = Role::all();
         return view('users.create',compact('roles'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        DB::beginTransaction();

            // Crear el usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Asignar roles
            $user->roles()->sync($validated['roles']);

        DB::commit();

        return redirect()->route('usuarios')->with('success', 'Usuario creado exitosamente');

       
    }
  

    public function destroy($id){
        $user= User::findOrFail($id);

        // Verificar que el usuario no se esté eliminando a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('usuarios')
                ->with('error', 'No puedes eliminar tu propio usuario');
        }

        // Verificar que no sea el último administrador
        if ($this->isLastAdmin($user)) {
            return redirect()
                ->route('usuarios')
                ->with('error', 'No se puede eliminar el último administrador');
        }

        DB::beginTransaction();

         // 1. Eliminar relaciones en tabla pivot (roles)
        $user->roles()->detach();

        // 2. Opcional: Reasignar registros asociados (ej: pedidos)
        // $user->pedidos()->update(['user_id' => auth()->id()]);

        // 3. Eliminar el usuario
        $user->delete();

        DB::commit();

        return redirect()
            ->route('usuarios')
            ->with('success', 'Usuario eliminado correctamente');

        
    }

    protected function isLastAdmin(User $user){
        if ($user->hasRole('admin')) {
            $adminCount = User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->count();

            return $adminCount <= 1;
        }

        return false;
    }
    public function show($id){
        $user=User::findOrFail($id);
        $roles = Role::all();
        return view('users.show',compact('user','roles'));
    }
    public function update(Request $request, User $user){
    // Reglas de validación básicas
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id'
    ];

    // Solo validar contraseña si se proporcionó
    if ($request->filled('password')) {
        $rules['password'] = 'required|string|min:8|confirmed';
    }

    $validated = $request->validate($rules);

    DB::beginTransaction();

    try {
        // Actualizar datos básicos
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // Solo actualizar contraseña si se proporcionó
            'password' => $request->filled('password') 
                ? Hash::make($validated['password']) 
                : $user->password
        ]);

        // Sincronizar roles
        $user->roles()->sync($validated['roles']);

        DB::commit();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');

    } catch (\Exception $e) {
        DB::rollBack();
        
        return back()
            ->withInput()
            ->with('error', 'Error al actualizar el usuario: '.$e->getMessage());
    }
}

}
