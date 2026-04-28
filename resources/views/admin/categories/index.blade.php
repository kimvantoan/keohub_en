@extends('admin.layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
        <h2 class="text-xl font-semibold text-gray-800">Quản lý Danh mục</h2>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
            <i class="fas fa-plus mr-2"></i>Thêm danh mục mới
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="px-6 py-4 border-b bg-gray-50">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full max-w-md">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập tên danh mục hoặc slug..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
            </div>

            <div class="flex space-x-2 w-full md:w-auto">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded text-sm font-medium transition-colors w-full md:w-auto">
                    Tìm kiếm
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.categories.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded text-sm font-medium transition-colors w-full md:w-auto text-center">
                        Xóa tìm kiếm
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <th class="px-6 py-3 border-b">ID</th>
                    <th class="px-6 py-3 border-b">Tên danh mục</th>
                    <th class="px-6 py-3 border-b">Slug</th>
                    <th class="px-6 py-3 border-b text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $category->id }}</td>
                        <td class="px-6 py-4 font-bold">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Sửa">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Chưa có danh mục nào. <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:underline">Tạo danh mục đầu tiên</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
