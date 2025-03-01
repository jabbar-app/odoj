@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 text-center">Daftar Groups dan Members</h2>
        <div class="card shadow-sm p-4 border-0">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Group Name</th>
                <th>Members</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($groups as $group)
                <tr>
                  <td>{{ $group->name }}</td>
                  <td>
                    <ul>
                      @foreach ($group->member ?? [] as $member)
                        <li>{{ $member['name'] }} ({{ $member['whatsapp'] }})</li>
                      @endforeach
                    </ul>
                  </td>
                  <td>
                    <a href="{{ route('groups.create', ['group_id' => $group->id]) }}" class="btn btn-sm btn-primary">Add Member</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
