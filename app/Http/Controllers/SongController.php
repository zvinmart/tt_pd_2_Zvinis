<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Author;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function list()
    {
        $items = Song::orderBy('name', 'asc')->get();
        return view(
            'song.list',
            [
                'title' => 'Dziesmas',
                'items' => $items
            ]
        );
    }

    public function create()
    {
        $authors = Author::orderBy('name', 'asc')->get();
        return view(
            'song.form',
            [
                'title' => 'Pievienot dziesmu',
                'song' => new Song(),
                'authors' => $authors,
            ]
        );
    }

    public function put(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:256',
            'author_id' => 'required',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable'
        ]);
        $song = new Song();
        $song->name = $validatedData['name'];
        $song->author_id = $validatedData['author_id'];
        $song->description = $validatedData['description'];
        $song->price = $validatedData['price'];
        $song->year = $validatedData['year'];
        $song->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $song->image = $uploadedFile->storePubliclyAs(
            '/',
            $name . '.' . $extension,
            'uploads'
            );
           }
           
        $song->save();
        return redirect('/songs');
    }

    public function update(Song $song)
    {
        $authors = Author::orderBy('name', 'asc')->get();
        return view(
            'song.form',
            [
                'title' => 'Rediģēt dziesmu',
                'song' => $song,
                'authors' => $authors,
            ]
        );
    }
    public function patch(Song $song, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:256',
            'author_id' => 'required',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable'
        ]);
        $song->name = $validatedData['name'];
        $song->author_id = $validatedData['author_id'];
        $song->description = $validatedData['description'];
        $song->price = $validatedData['price'];
        $song->year = $validatedData['year'];
        $song->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $song->image = $uploadedFile->storePubliclyAs(
            '/',
            $name . '.' . $extension,
            'uploads'
            );
           }
           
        $song->save();
        return redirect('/songs/update/' . $song->id);
    }

    public function delete(Song $song)
    {
        $song->delete();
        return redirect('/songs');
    }
}