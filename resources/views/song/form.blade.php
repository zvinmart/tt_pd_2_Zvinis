@extends('layout')
@section('content')
<h1>{{ $title }}</h1>
@if ($errors->any())
 <div class="alert alert-danger">Lūdzu, novērsiet radušās kļūdas!</div>
@endif
<form
enctype="multipart/form-data"
<div class="mb-3">
 <label for="song-image" class="form-label">Attēls</label>
 @if ($song->image)
 <img
 src="{{ asset('images/' . $song->image) }}"
 class="img-fluid img-thumbnail d-block mb-2"
 alt="{{ $song->name }}"
 >
 @endif
 <input
 type="file" accept="image/png, image/jpeg"
 id="song-image"
 name="image"
 class="form-control @error('image') is-invalid @enderror"
 >
 @error('image')
 <p class="invalid-feedback">{{ $errors->first('image') }}</p>
 @enderror
 method="post"
 action="{{ $song->exists ? '/songs/patch/' . $song->id : '/songs/put' }}">
 @csrf
</div>

 <div class="mb-3">
 <label for="song-name" class="form-label">Nosaukums</label>
 <input
 type="text"
 id="song-name"
 name="name"
 value="{{ old('name', $song->name) }}"
 class="form-control @error('name') is-invalid @enderror"
 >
 @error('name')
 <p class="invalid-feedback">{{ $errors->first('name') }}</p>
 @enderror
 </div>
 <div class="mb-3">
 <label for="song-author" class="form-label">Autors</label>
 <select
 id="song-author"
 name="author_id"
 class="form-select @error('author_id') is-invalid @enderror"
 >
 <option value="">Norādiet autoru!</option>
 @foreach($authors as $author)
 <option
 value="{{ $author->id }}"
 @if ($author->id == old('author_id', $song->author-
>id ?? false)) selected @endif
 >{{ $author->name }}</option>
 @endforeach
 </select>
 @error('author_id')
 <p class="invalid-feedback">{{ $errors->first('author_id') }}</p>
 @enderror
 </div>
 <div class="mb-3">
 <label for="song-description" class="form-label">Apraksts</label>
 <textarea
 id="song-description"
 name="description"
 class="form-control @error('description') is-invalid @enderror"
 >{{ old('description', $song->description) }}</textarea>
 @error('description')
 <p class="invalid-feedback">{{ $errors->first('description') }}</p>
 @enderror
 </div>
 <div class="mb-3">
 <label for="song-year" class="form-label">Izdošanas gads</label>
 <input
 type="number" max="{{ date('Y') + 1 }}" step="1"
 id="song-year"
 name="year"
 value="{{ old('year', $song->year) }}"
 class="form-control @error('year') is-invalid @enderror"
 >
 @error('year')
 <p class="invalid-feedback">{{ $errors->first('year') }}</p>
 @enderror
 </div>
 <div class="mb-3">
 <label for="song-price" class="form-label">Cena</label>
 <input
 type="number" min="0.00" step="0.01" lang="en"
 id="song-price"
 name="price"
 value="{{ old('price', $song->price) }}"
 class="form-control @error('price') is-invalid @enderror"
 >
 @error('price')
 <p class="invalid-feedback">{{ $errors->first('price') }}</p>
 @enderror
 </div>

 <div class="mb-3">
 <div class="form-check">
 <input
 type="checkbox"
 id="song-display"
 name="display"
 value="1"
 class="form-check-input @error('display') is-invalid @enderror"
 @if (old('display', $song->display)) checked @endif
 >
 <label class="form-check-label" for="song-display">
 Publicēt ierakstu
 </label>
 @error('display')
 <p class="invalid-feedback">{{ $errors->first('display') }}</p>
@enderror
</div>
</div>
<button type="submit" class="btn btn-primary">
    {{ $song->exists ? 'Atjaunot ierakstu' : 'Pievienot ierakstu' }}
</button>
</form>
@endsection