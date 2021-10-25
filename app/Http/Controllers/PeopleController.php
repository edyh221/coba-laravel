<?php

namespace App\Http\Controllers;

use App\Models\People;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use SplTempFileObject;

class PeopleController extends Controller
{
  public function index()
  {
    return \view('people.index', [
      'peoples' => People::orderBy('created_at', 'DESC')->paginate(10),
      'title' => 'People'
    ]);
  }

  public function destroy($id) 
  {
    $people = People::find($id);
    if($people->image) {
      Storage::delete("images/{$people->image}");
    }
    $people->delete();
    return \redirect()->back()->with('status', 'People data has been deleted');
  }

  public function create()
  {
    return \view('people.create', [
      'title' => 'Create People Data'
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'nik' => 'required|max:16|unique:peoples,nik|min:16',
      'name' => 'required|string',
      'age' => 'required|numeric|min:17|max:80',
      'image' => 'image|mimes:jpg,bmp,png,jpeg'
    ]);

    if($validated) {
      if($request->hasFile('image')) {
        $filename = $request->nik . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('images', $filename);
      }

      People::create([
        'nik' => $request->nik,
        'name' => $request->name,
        'age' => $request->age,
        'image' => $filename
      ]);

      return \redirect('admin/people')->with('status', 'People data has been created');
    }
  }

  public function update(Request $request)
  {
    $validated = $request->validate([
      'nik' => 'required|max:16|min:16',
      'name' => 'required|string',
      'age' => 'required|numeric|min:17|max:80',
      'image' => 'image|mimes:jpg,bmp,png,jpeg'
    ]);

    if($validated) {
      $people = People::find($request->id);
      if($request->hasFile('image')) {
        $filename = $request->nik . '.' . $request->file('image')->getClientOriginalExtension();
        Storage::delete("images/{$people->image}");
        $request->file('image')->storeAs('images', $filename);
      }
      $people->nik = $request->nik;
      $people->name = $request->name;
      $people->age = $request->age;
      $people->image = $filename;
      $people->save();

      return \redirect('admin/people')->with('status', 'People data has been updated');
    }
  }

  public function edit($id)
  {
    return \view('people.edit', [
      'people' => People::find($id),
      'title' => 'Update People Data'
    ]);
  }

  public function csv()
  {
    $csv = Writer::createFromFileObject(new SplTempFileObject());
    $csv->insertOne(['nik', 'name', 'age', 'image']);
    foreach(People::all()->toArray() as $people) {
      $csv->insertOne([
        'nik' => $people['nik'],
        'name' => $people['name'],
        'age' => $people['age'] . ' Tahun',
        'image' => \asset('images/' . $people['image'])
      ]);
    }
    $csv->output(Carbon::now() . '.' . 'csv');
    die;
  }

  public function csvWithChunking()
  {
    $csv = Writer::createFromFileObject(new SplTempFileObject());
    $csv->insertOne(['nik', 'name', 'age', 'image']);
    People::chunk(200, function($peoples) use (&$csv) {
      foreach($peoples->toArray() as $people) {
        $csv->insertOne([
          'nik' => $people['nik'],
          'name' => $people['name'],
          'age' => $people['age'] . ' Tahun',
          'image' => \asset('images/' . $people['image'])
        ]);
      }
    });
    $csv->output(Carbon::now() . '.' . 'csv');
  }
}
