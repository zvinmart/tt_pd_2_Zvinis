<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;


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



    private function saveSongData(Song $song, SongRequest $request)
    {
        $validatedData = $request->validated();
        $song->fill($validatedData);
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
    }

    public function put(SongRequest $request)
    {
        $song = new song();
        $this->saveSongData($song, $request);
        return redirect('/songs');
    }
    public function patch(Song $song, SongRequest $request)
    {
        $this->saveSongData($song, $request);
        return redirect('/songs/update/' . $song->id);
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
    
    public function delete(Song $song)
    {
        $song->delete();
        return redirect('/songs');
    }
}