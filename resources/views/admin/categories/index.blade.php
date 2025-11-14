@extends('layout.admin')

@section('title', 'Categories')

@section('content')
    <div class="bg-white rounded-lg border p-4">
        <h2 class="font-semibold mb-3">Categories</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $c)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $c->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $c->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $c->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
