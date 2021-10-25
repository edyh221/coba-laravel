<x-layout>
  <x-slot name="title">
    {{$title}}
  </x-slot>
  <x-slot name="breadcrumb">
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="{{ route('people.index') }}">People</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </x-slot>

  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        People Data
    </div>
    <div class="card-body">
      <form class="row g-3" action="{{ route('people.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$people->id}}">
        <div class="col-md-6">
          <label for="nik" class="form-label">NIK</label>
          <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik" value="{{old('nik', $people->nik)}}">
          @error('nik')
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="col-md-6">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $people->name)}}">
          @error('name')
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="col-md-6">
          <label for="age" class="form-label">Umur</label>
          <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{old('age', $people->age)}}">
          @error('age')
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
          <div class="mt-3">
            <label for="image" class="form-label">Foto</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
              <div class="invalid-feedback">
                {{$message}}
              </div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <img src="{{ asset("images/{$people->image}") }}" alt="{{$people->image}}" class="img-thumbnail" style="height: 155px">
        </div>
        <div class="col-12 d-grid gap-2">
          <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</x-layout>