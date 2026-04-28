@extends('admin.layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Danh sách bài viết</h2>
        <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i>Thêm bài viết
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="px-6 py-4 border-b bg-gray-50">
        <form action="{{ route('admin.articles.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập tiêu đề hoặc slug..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
            </div>
            
            <div class="w-full md:w-48">
                <label for="category" class="block text-xs font-medium text-gray-700 mb-1">Danh mục</label>
                <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-48">
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Trạng thái</label>
                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 text-sm">
                    <option value="">Tất cả trạng thái</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                </select>
            </div>

            <div class="flex space-x-2 w-full md:w-auto">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded text-sm font-medium transition-colors w-full md:w-auto">
                    Lọc
                </button>
                @if(request()->anyFilled(['search', 'category', 'status']))
                    <a href="{{ route('admin.articles.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded text-sm font-medium transition-colors w-full md:w-auto text-center">
                        Xóa lọc
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
                    <th class="px-6 py-3 border-b">Hình ảnh</th>
                    <th class="px-6 py-3 border-b">Tiêu đề</th>
                    <th class="px-6 py-3 border-b">Danh mục</th>
                    <th class="px-6 py-3 border-b text-center">Trạng thái</th>
                    <th class="px-6 py-3 border-b">Ngày đăng</th>
                    <th class="px-6 py-3 border-b text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse ($articles as $article)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $article->id }}</td>
                    <td class="px-6 py-4">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="" class="h-10 w-16 object-cover rounded shadow-sm">
                        @else
                            <div class="h-10 w-16 bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900" title="{{ $article->title }}">{{ Str::limit($article->title, 50) }}</div>
                        <div class="text-xs text-gray-500 mt-1" title="{{ $article->slug }}">{{ Str::limit($article->slug, 50) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($article->categories as $category)
                                <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-medium rounded bg-blue-50 text-blue-700 border border-blue-200">{{ $category->name }}</span>
                            @empty
                                <span class="text-xs text-gray-400 italic">Chưa có</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($article->is_published)
                            <span class="px-2 py-1 inline-flex text-[10px] leading-4 font-bold rounded-sm bg-green-100 text-green-700 uppercase tracking-wide">Xuất bản</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-[10px] leading-4 font-bold rounded-sm bg-gray-200 text-gray-600 uppercase tracking-wide">Nháp</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('news.show', $article->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-900" title="Xem bài viết">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Sửa">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
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
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        Chưa có bài viết nào. <a href="{{ route('admin.articles.create') }}" class="text-blue-600 hover:underline">Tạo bài viết đầu tiên</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($articles->hasPages())
    <div class="px-6 py-4 border-t bg-gray-50">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection
