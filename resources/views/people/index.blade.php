<x-layout>
  <x-slot name="title">
    {{$title}}
  </x-slot>
  <x-slot name="breadcrumb">
    <ol class="breadcrumb mb-4">
      {{-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> --}}
      <li class="breadcrumb-item active">People</li>
    </ol>
  </x-slot>

  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        People Data
    </div>
    <div class="card-body">
        @can('isAdmin')
        <a href="{{ route('people.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</a>
        @endcan
        <a href="{{ route('people.csv') }}" class="btn btn-success"><i class="fas fa-file-csv"></i> Export CSV</a>
        {{-- <a href="{{ route('people.csv-chunk') }}" class="btn btn-success"><i class="fas fa-file-csv"></i> Export CSV Chunking</a> --}}
        <table class="table table-responsive table-hover table-striped">
            <thead>
                <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Umur</th>
                  <th>Foto</th>
                  @can('isAdmin')
                  <th class="text-center">Aksi</th>
                  @endcan
                </tr>
            </thead>
            <tbody>
              @foreach ($peoples as $people)
                  <tr>
                    <td class="align-middle">{{$people->nik}}</td>
                    <td class="align-middle">{{$people->name}}</td>
                    <td class="align-middle">{{$people->age}} Tahun</td>
                    <td>
                      @if ($people->image)
                      <img style="height: 60px" src="{{ asset("/images/{$people->image}") }}" alt="{{$people->image}}" class="img-thumbnail">
                      @else
                      Tidak ada gambar
                      @endif
                    </td>
                    @can('isAdmin')
                    <td class="align-middle">
                      <div class="d-flex justify-content-evenly">
                        <form action="{{ route('people.destroy', ['id'=> $people->id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        <a href="{{ route('people.edit', ['id' => $people->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                      </div>
                    </td>
                    @endcan
                  </tr>
              @endforeach
            </tbody>
        </table>
        {{$peoples->links()}}
    </div>
  </div>
</x-layout>