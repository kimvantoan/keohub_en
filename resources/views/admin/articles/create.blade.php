@extends('admin.layouts.app')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#content',
            height: 600,
            menubar: false,
            statusbar: false,
            skin: 'oxide',
            content_css: 'default',
            relative_urls: false,
            remove_script_host: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | ' +
                'bold italic underline strikethrough | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'image media link | removeformat | fullscreen',
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route("admin.upload_image") }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({
                            message: 'HTTP Error: ' + xhr.status,
                            remove: true
                        });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }),
            content_style: `
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Lora:ital,wght@0,400;0,500;1,400&display=swap');
                body { 
                    font-family: 'Lora', serif; 
                    font-size: 16px; 
                    line-height: 1; 
                    color: #333; 
                    padding: 0.5rem !important; 
                    max-width: 800px; 
                    margin: 0 auto; 
                }
                p { margin-bottom: 1.5em; }
            `,
            setup: function(editor) {
                editor.on('keyup change', function() {
                    const count = editor.plugins.wordcount.body.getWordCount();
                    document.getElementById('wordCount').innerText = count + ' Từ';
                });
                editor.on('init', function() {
                    const count = editor.plugins.wordcount.body.getWordCount();
                    document.getElementById('wordCount').innerText = count + ' Từ';
                });
            }
        });
    });

    function previewImage(input) {
        var previewContainer = document.getElementById('thumbnail-preview-container');
        var previewImage = document.getElementById('thumbnail-preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.src = "";
            previewContainer.classList.add('hidden');
        }
    }
</script>
<script>
    function openCategoryModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('newCategoryName').focus();
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('newCategoryName').value = '';
        document.getElementById('categoryError').classList.add('hidden');
    }

    function submitCategory() {
        const name = document.getElementById('newCategoryName').value;
        const errorEl = document.getElementById('categoryError');
        const btn = document.getElementById('saveCategoryBtn');

        if (!name.trim()) {
            errorEl.innerText = 'Vui lòng nhập tên danh mục.';
            errorEl.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.innerText = 'Đang lưu...';
        errorEl.classList.add('hidden');

        fetch('{{ route("admin.categories.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            btn.disabled = false;
            btn.innerText = 'Lưu';

            if (res.status === 200 || res.status === 201) {
                if (res.body.success) {
                    const select = document.getElementById('categories');
                    const option = document.createElement('option');
                    option.value = res.body.category.id;
                    option.text = res.body.category.name;
                    option.selected = true;
                    select.appendChild(option);
                    closeCategoryModal();
                } else {
                    errorEl.innerText = res.body.message || 'Có lỗi xảy ra.';
                    errorEl.classList.remove('hidden');
                }
            } else if (res.status === 422) {
                errorEl.innerText = res.body.errors.name[0];
                errorEl.classList.remove('hidden');
            } else {
                errorEl.innerText = 'Lỗi server.';
                errorEl.classList.remove('hidden');
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerText = 'Lưu';
            errorEl.innerText = 'Lỗi mạng, vui lòng thử lại.';
            errorEl.classList.remove('hidden');
        });
    }
</script>

@endpush

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Thêm bài viết mới</h2>
    </div>

    @if ($errors->any())
    <div class="px-6 py-4 pb-0">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700">Mô tả ngắn (Meta Description)</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">{{ old('meta_description') }}</textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Nội dung <span class="text-red-500">*</span>
                        <span id="wordCount" class="float-right text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">0 Từ</span>
                    </label>
                    <textarea name="content" id="content" rows="20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">{{ old('content') }}</textarea>
                </div>


            </div>

            <div class="space-y-6 bg-gray-50 p-4 rounded-lg border">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Xuất bản bài viết</span>
                    </label>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="categories" class="block text-sm font-medium text-gray-700">Danh mục</label>
                        <button type="button" onclick="openCategoryModal()" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                            + Thêm mới
                        </button>
                    </div>
                    <select id="categories" name="categories[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2 h-32">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Giữ phím Ctrl (hoặc Cmd) để chọn nhiều danh mục</p>
                </div>

                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700">Hình thu nhỏ (Thumbnail)</label>
                    <div id="thumbnail-preview-container" class="mt-2 mb-2 hidden">
                        <img id="thumbnail-preview" src="" alt="Thumbnail preview" class="h-32 object-cover rounded border">
                    </div>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 p-2 border border-gray-300 rounded" onchange="previewImage(this)">
                </div>



                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Lưu bài viết
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="mt-2 block text-center w-full bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        Hủy
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Thêm danh mục mới</h3>
            <div class="mt-2 px-7 py-3">
                <input type="text" id="newCategoryName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Tên danh mục...">
                <p id="categoryError" class="text-red-500 text-xs italic mt-2 hidden"></p>
            </div>
            <div class="items-center px-4 py-3 flex justify-end gap-2">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Hủy
                </button>
                <button type="button" onclick="submitCategory()" id="saveCategoryBtn" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Lưu
                </button>
            </div>
        </div>
    </div>
</div>
@endsection