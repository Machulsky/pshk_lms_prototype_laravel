<?php

namespace App\Http\Controllers;
use App\Category;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('admin')){
            return view('admin.users.index', ['users' => User::paginate(10)]);
        }else{
            return view('admin.users.index', ['users' => User::where('created_by', Auth::id())->paginate(10)]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', [
            'user' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
             ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMultiple()
    {
        return view('admin.users.create-multiple', [
            'user' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
             ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMultiple(Request $request)
    {
        $users = explode("\n", str_replace("\r", "", $request->input('users')));
        $created_users = collect();
        foreach($users as $user){
            $names = explode(" ", $user);
            $lastname = $names[0];
            $firstname = $names[1];
            $patronym = $names[2] ?? '';
            $login = 'student'.substr(rand()+rand()+time(),0,rand(5,7));
            $password = substr(rand()+rand()+time(),0,rand(8,10));
            $created_by = Auth::id();

            $new_user = User::create(
                [
                'username' => $login,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'patronym' => $patronym,
                'created_by' => Auth::id(),
                'password' => Hash::make($password)
                ]
            );
            $new_user->role()->attach(Role::where('id', $request->input('role') ?? 3)->first());
            if($request->input('categories')){
                $new_user->categories()->attach($request->input('categories'));
            }
            $new_user->pass = $password;

            $created_users->add($new_user);
        }

        return redirect()->route('admin.user.create.multiple')->with('credentials', [$created_users])->with('success', ['Пользователи успешно созданы']);


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

        $user = User::create(
            [
            'username' => $request->input('username'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'patronym' => $request->input('patronym'),
            'email' => $request->input('email'),
            'created_by' => Auth::id(),
            'password' => Hash::make($request->input('password'))
            ]
        );

        $user->role()->attach(Role::where('id', $request->input('role') ?? 3)->first());
        if($request->input('categories')){
            $user->categories()->attach($request->input('categories'));
        }

        return redirect()->route('admin.user.index')->with('success', ['Пользователь успешно создан!']);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if((($user->hasRole('admin') or $user->hasRole('teacher') )&& !Auth::user()->hasRole('admin')) && $user->id != Auth::id()){
            return redirect()->route('admin.user.index')->with('error', ['Вы не можете редактировать администратора или преподавателя']);
        }
        return view('admin.users.edit', [
            'user' => $user,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if((($user->hasRole('admin') or $user->hasRole('teacher') )&& !Auth::user()->hasRole('admin')) && $user->id != Auth::id()){
            return redirect()->route('admin.user.index')->with('error', ['Вы не можете редактировать администратора или преподавателя']);
        }
        if($user->password != $request->input('password')){
            $user->update( ['password' => Hash::make($request->input('password'))
            ]);
        }

        $user->update( [
            'username' => $request->input('username'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'patronym' => $request->input('patronym'),
            'email' => $request->input('email'),
            'created_by' => $request->input('created_by'),
            ]);
        $user->categories()->detach();
        $user->categories()->attach($request->input('categories'));

        return redirect()->route('admin.user.index')->with('success', ['Изменения сохранены']);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->hasRole('admin') or $user->hasRole('teacher') && !Auth::user()->hasRole('admin')){
            return redirect()->route('admin.user.index')->with('error', ['Вы не можете удалить администратора или преподавателя']);
        }
        $user->role()->detach();
        $user->answers()->delete();
        $user->categories()->detach();
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', ['Пользователь удалён']);
        //
    }
}
