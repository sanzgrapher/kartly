@extends('layout.admin')

@section('title', 'Orders')

@section('content')
    <div class="mt-8 bg-white rounded-lg border border-gray-300">
       <div class="mb-3 p-3">
         <h2 class="font-semibold ">Orders</h2>
        <p class=" text-sm text-gray-400" >All orders</p>
       </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">User</th>
                        <th class="p-4 text-sm">Total</th>
                        <th class="p-4 text-sm">Created</th>
                        <th class="p-4 text-sm">Actions</th>
                    </tr>
                </thead>



                <tbody>
                    @foreach ($orders as $o)
                        <tr class="border-t  border-gray-300">
                            <td class="p-4 text-sm">{{ $o->id }}</td>

                            <td class="p-4 text-sm">{{ $o->user->name ?? 'n/a' }}</td>
                            <td class="p-4 text-sm">
                                {{ $o->total }} </td>
                            <td class="p-4 text-sm">{{ $o->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.orders.show', $o->id) }}" title="View">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 p-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
