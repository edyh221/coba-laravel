<x-layout>
  <x-slot name="title">
    {{$title}}
  </x-slot>
  <x-slot name="breadcrumb">
    <ol class="breadcrumb mb-4">
      {{-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> --}}
      <li class="breadcrumb-item active">User</li>
    </ol>
  </x-slot>

  <x-slot name="script">
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const editRole = document.querySelectorAll('.edit-role');
        editRole.forEach(function(e) {
          e.addEventListener('click', function() {
            const id = this.dataset.id;
            this.parentElement.parentElement.innerHTML = `
              <form action="{{url('admin/user/${id}')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-8">
                    <select class="form-select" aria-label="Default select example" name="role" onchange="this.form.submit()">
                      <option>Pilih Role</option>
                      <option value="ADMIN">ADMIN</option>
                      <option value="USER">USER</option>
                    </select>
                  </div>
                  <div class="col-4">
                    <button type="button" class="btn btn-sm btn-danger mt-1" onclick="window.location.reload()"><i class="fas fa-times"></i></button>
                  </div>
                </div>
              </form>
            `;
            const disable = document.querySelectorAll('.edit-role');
            disable.forEach(function(e) {
              e.innerHTML = ''
            })
          });
        })

        
      })
    </script>
  </x-slot>
  <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        User Data
    </div>
    <div class="card-body">
        <table class="table table-responsive table-hover table-striped">
            <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Role</th>
                  <th>Email</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td class="align-middle">{{$user->id}}</td>
                  <td class="align-middle">{{$user->name}}</td>
                  <td class="align-middle editable">
                    <div class="position-relative badge bg-warning text-black">
                      {{$user->role}} 
                      <span data-id="{{$user->id}}" class="edit-role position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="cursor: pointer">
                        <i class="fas fa-pencil-alt"></i>
                        <span class="visually-hidden">Edit</span>
                      </span>
                    </div>
                  </td>
                  <td class="align-middle">{{$user->email}} Tahun</td>
                </tr>
              @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
  </div>
</x-layout>