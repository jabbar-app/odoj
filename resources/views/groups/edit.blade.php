@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 text-center">Edit Member</h2>
        <div class="card shadow-sm p-4 border-0">
          <form action="{{ route('groups.update', $group->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="name" class="form-label">Nama Member</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ $group->name }}"
                required>
            </div>
            <div class="mb-3">
              <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
              <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ $group->whatsapp }}">
            </div>
            <div class="mb-3">
              <label for="group_id" class="form-label">Group</label>
              <select name="group_id" id="group_id" class="form-select" required>
                @foreach ($groups as $group)
                  <option value="{{ $group->id }}" {{ $group->id == $group->group_id ? 'selected' : '' }}>
                    {{ $group->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
