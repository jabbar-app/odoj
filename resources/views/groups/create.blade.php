@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 text-center">Tambah Member Baru</h2>
        <div class="card shadow-sm p-4 border-0">
          <form action="{{ route('groups.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Nama Group</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="whatsapp_id" class="form-label">Group WhatsApp ID</label>
              <input type="text" name="whatsapp_id" id="whatsapp_id" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
