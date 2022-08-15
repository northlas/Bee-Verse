<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $users = User::where('visibility', true)->get();
        if(auth()->user()) $users = $users->where('id', '!=', auth()->user()->id);
        $fields = Field::all();

        $output = '';

        foreach ($users as $user) {
            $field_name = [];

            foreach ($user->field as $value) {
                array_push($field_name, __($value->name));
            }

            $output .= '
            <div class="col mb-3">
                <a href="/profile/'.$user->slug.'" class="text-decoration-none">
                    <div class="card shadow-sm h-100 bg-dark-secondary border border-white">
                        <img src="./storage/Assets/Avatar/'.$user->profile->where("active", true)->first()->avatar->image.'" class="card-img-top">
                        <div class="card-body">
                            <h6 class="card-title text-white">'.$user->name.'</h6>
                            <p class="card-text text-white-50" style="font-size: 12px">'.implode(", ", $field_name).'</p>
                        </div>
                    </div>
                </a>
            </div>';
        }
        
        return view('main.dashboard', [
            'users' => $output,
            'fields' => $fields,
            'page' => 'home',
        ]);
    }

    public function filter(Request $request){   
        $users = User::where('visibility', true)->get();
        if(auth()->user()) $users = $users->where('id', '!=', auth()->user()->id);
        
        if($request['gender']) $users = $users->toQuery()->whereIn('gender', $request['gender'])->get();
        
        if($request['field']) $users = $users->toQuery()->whereHas('field', fn(Builder $query) => $query->whereIn('name', $request['field']))->get();

        if($request['search']){
            $keyword = $request['search'];
            $users = $users->toQuery()->where('name', 'LIKE', "%$keyword%")->get();
        }

        $output = '';

        foreach ($users as $user) {
            $field_name = [];

            foreach ($user->field as $value) {
                array_push($field_name, __($value->name));
            }

            $output .= '
            <div class="col mb-3">
                <a href="/profile/'.$user->slug.'" class="text-decoration-none">
                    <div class="card shadow-sm h-100 bg-dark-secondary border border-white">
                        <img src="./storage/Assets/Avatar/'.$user->profile->where("active", true)->first()->avatar->image.'" class="card-img-top">
                        <div class="card-body">
                            <h6 class="card-title text-white">'.$user->name.'</h6>
                            <p class="card-text text-white-50" style="font-size: 12px">'.implode(", ", $field_name).'</p>
                        </div>
                    </div>
                </a>
            </div>';
        }
        
        return response()->json($output);
    }
}
