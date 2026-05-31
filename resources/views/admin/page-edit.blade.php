@extends('admin.layouts.app')

@section('title', 'Редактирование: ' . $page->name)

@push('styles')
<style>
    .editor-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 2px;
        padding: 6px;
        border: 1px solid #ccc;
        border-bottom: 0;
        border-radius: 4px 4px 0 0;
        background: #f8f9fa;
    }
    .editor-toolbar button {
        padding: 4px 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        background: #fff;
        cursor: pointer;
        font-size: 13px;
        line-height: 1.4;
    }
    .editor-toolbar button:hover {
        background: #e9ecef;
    }
    .editor-toolbar select {
        padding: 3px 6px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 13px;
    }
    .editor-toolbar .sep {
        width: 1px;
        background: #ddd;
        margin: 2px 4px;
    }
    #editor {
        min-height: 450px;
        max-height: 650px;
        overflow-y: auto;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 0 0 4px 4px;
        background: #fff;
    }
    #editor:focus {
        outline: none;
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    #editor img {
        max-width: 100%;
        cursor: pointer;
    }
    #editor img.selected {
        outline: 3px solid #0d6efd;
        outline-offset: 2px;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,0,0,.5);
        justify-content: center;
        align-items: center;
    }
    .modal-overlay.open {
        display: flex;
    }
    .modal-box {
        background: #fff;
        border-radius: 8px;
        width: 700px;
        max-width: 95vw;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0,0,0,.3);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .modal-header h5 { margin: 0; }
    .modal-header .close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
    }

    .modal-box label { font-weight: 500; margin-bottom: 2px; }

    .img-preview-box {
        border: 1px dashed #ccc;
        border-radius: 4px;
        padding: 10px;
        text-align: center;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        margin-bottom: 12px;
    }
    .img-preview-box img {
        max-width: 100%;
        max-height: 200px;
    }
    .lock-btn {
        border: 1px solid #ccc;
        background: #fff;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 16px;
        line-height: 1;
        height: 38px;
        margin-top: 24px;
    }
    .lock-btn.active { background: #cfe2ff; border-color: #86b7fe; }
    .img-size-group { display: flex; gap: 8px; align-items: flex-start; }
    .img-size-group .form-group { flex: 1; }
    .border-style-group { display: flex; gap: 8px; align-items: flex-end; }
    .border-style-group select { width: 120px; }
    .align-group { display: flex; gap: 8px; }
    .align-group label { font-weight: 400; cursor: pointer; }
    .align-group input[type="radio"] { margin-right: 3px; }
</style>
@endpush

@section('content')
    <h2 class="text-2xl font-bold mb-4">Редактирование: {{ $page->name }}</h2>

    <form method="POST" action="/admin/pages/{{ $page->id }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Название</label>
            <input name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('name', $page->name) }}" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
            <input name="opis" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('opis', $page->opis) }}" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Содержимое</label>
            <div class="editor-toolbar" id="toolbar">
                <button type="button" onclick="exec('bold')" title="Жирный"><b>B</b></button>
                <button type="button" onclick="exec('italic')" title="Курсив"><i>I</i></button>
                <button type="button" onclick="exec('underline')" title="Подчеркнутый"><u>U</u></button>
                <button type="button" onclick="exec('strikeThrough')" title="Зачёркнутый"><s>S</s></button>
                <span class="sep"></span>
                <button type="button" onclick="exec('superscript')" title="Надстрочный">x<sup>2</sup></button>
                <button type="button" onclick="exec('subscript')" title="Подстрочный">x<sub>2</sub></button>
                <span class="sep"></span>
                <button type="button" onclick="exec('removeFormat')" title="Очистить формат">✕</button>
                <span class="sep"></span>
                <button type="button" onclick="exec('insertOrderedList')" title="Нумерованный список">1.</button>
                <button type="button" onclick="exec('insertUnorderedList')" title="Маркированный список">•</button>
                <button type="button" onclick="exec('outdent')" title="Уменьшить отступ">⇤</button>
                <button type="button" onclick="exec('indent')" title="Увеличить отступ">⇥</button>
                <button type="button" onclick="exec('justifyLeft')" title="По левому краю">≡</button>
                <button type="button" onclick="exec('justifyCenter')" title="По центру">≡</button>
                <button type="button" onclick="exec('justifyRight')" title="По правому краю">≡</button>
                <button type="button" onclick="exec('justifyFull')" title="По ширине">≡</button>
                <span class="sep"></span>
                <select onchange="execFormat(this)">
                    <option value="">Абзац</option>
                    <option value="h1">H1</option>
                    <option value="h2">H2</option>
                    <option value="h3">H3</option>
                    <option value="h4">H4</option>
                    <option value="h5">H5</option>
                    <option value="h6">H6</option>
                    <option value="pre">pre</option>
                    <option value="blockquote">blockquote</option>
                </select>
                <select onchange="exec('fontSize', this.value)">
                    <option value="">Размер</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
                <span class="sep"></span>
                <input type="color" onchange="exec('foreColor', this.value)" title="Цвет текста">
                <input type="color" onchange="exec('hiliteColor', this.value)" title="Цвет фона">
                <span class="sep"></span>
                <button type="button" onclick="insertLink()" title="Ссылка">🔗</button>
                <button type="button" onclick="openImageModal()" title="Изображение">🖼</button>
                <button type="button" onclick="insertTable()" title="Таблица">⊞</button>
                <button type="button" onclick="exec('insertHorizontalRule')" title="Горизонтальная линия">—</button>
                <span class="sep"></span>
                <button type="button" onclick="toggleHtml()" title="Режим HTML">&lt;/&gt;</button>
                <button type="button" onclick="document.getElementById('editor').innerHTML = ''" title="Очистить">🗑</button>
            </div>
            <div id="editor" contenteditable="true">{!! $page->html !!}</div>
            <textarea name="html" id="htmlInput" style="display:none"></textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded transition">Сохранить</button>
            <a href="/admin/pages" class="text-gray-600 hover:text-gray-800 text-sm px-3 py-2 rounded transition">Назад к списку</a>
            <span class="text-gray-400 text-xs">Ctrl+S — быстрая отправка</span>
        </div>
    </form>

    <!-- Модальное окно настройки изображения -->
    <div class="modal-overlay" id="imageModal">
        <div class="modal-box">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h5 class="text-lg font-semibold" id="imgModalTitle">Настройки изображения</h5>
                <button class="text-2xl leading-none text-gray-400 hover:text-gray-600" onclick="closeImageModal()">&times;</button>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Загрузить файл</label>
                        <input type="file" accept="image/*" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgFileInput" onchange="uploadImageFile(this)">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Или URL изображения</label>
                        <input type="text" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgUrl" placeholder="https://..." oninput="previewImage()">
                    </div>
                </div>
                <div class="img-preview-box" id="imgPreviewBox">
                    <img id="imgPreview" src="" style="display:none">
                    <span id="imgPreviewPlaceholder" style="color:#999">Предпросмотр</span>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ширина (px)</label>
                        <input type="number" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgWidth" min="0" oninput="onSizeInput('w')">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Высота (px)</label>
                        <input type="number" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgHeight" min="0" oninput="onSizeInput('h')">
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Отступ (margin, px)</label>
                        <input type="number" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgMargin" value="0" min="0">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Радиус скругления (px)</label>
                        <input type="number" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgBorderRadius" value="0" min="0">
                    </div>
                </div>

                <div class="flex gap-2 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Рамка</label>
                        <input type="number" class="block text-sm border border-gray-300 rounded px-2 py-1.5 w-20" id="imgBorderWidth" value="0" min="0" placeholder="Толщина">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                        <select id="imgBorderStyle" class="block text-sm border border-gray-300 rounded px-2 py-1.5 w-28">
                            <option value="solid">solid</option>
                            <option value="dashed">dashed</option>
                            <option value="dotted">dotted</option>
                            <option value="double">double</option>
                            <option value="groove">groove</option>
                            <option value="ridge">ridge</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                        <input type="color" id="imgBorderColor" value="#cccccc" class="block h-9 w-10 border border-gray-300 rounded px-0.5 py-0.5">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Выравнивание</label>
                    <div class="flex gap-4 text-sm">
                        <label class="flex items-center gap-1"><input type="radio" name="imgAlign" value="" checked> Нет</label>
                        <label class="flex items-center gap-1"><input type="radio" name="imgAlign" value="left"> Слева</label>
                        <label class="flex items-center gap-1"><input type="radio" name="imgAlign" value="center"> Центр</label>
                        <label class="flex items-center gap-1"><input type="radio" name="imgAlign" value="right"> Справа</label>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alt текст</label>
                        <input type="text" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgAlt">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgTitle">
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">CSS класс</label>
                        <input type="text" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgClass">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ссылка (обернуть в &lt;a&gt;)</label>
                        <input type="text" class="block w-full text-sm border border-gray-300 rounded px-2 py-1.5" id="imgLink" placeholder="https://...">
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-200">
                <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded transition" onclick="closeImageModal()">Отмена</button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded transition" onclick="applyImage()">Применить</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var editingImg = null;
    var aspectLock = false;
    var naturalW = 0, naturalH = 0;

    // ---------- общие команды ----------
    function exec(cmd, val) {
        document.execCommand(cmd, false, val || null);
        document.getElementById('editor').focus();
    }

    function execFormat(el) {
        var val = el.value;
        if (!val) return;
        document.execCommand('formatBlock', false, '<' + val + '>');
        el.value = '';
        document.getElementById('editor').focus();
    }

    // ---------- ссылка ----------
    function insertLink() {
        var url = prompt('Введите URL ссылки:', 'https://');
        if (url) {
            document.execCommand('createLink', false, url);
            document.getElementById('editor').focus();
        }
    }

    // ---------- таблица ----------
    function insertTable() {
        var rows = prompt('Строк:', 3);
        var cols = prompt('Колонок:', 3);
        if (rows && cols) {
            var html = '<table style="border-collapse:collapse;width:100%">';
            for (var r = 0; r < rows; r++) {
                html += '<tr>';
                for (var c = 0; c < cols; c++) {
                    html += '<td>&nbsp;</td>';
                }
                html += '</tr>';
            }
            html += '</table>';
            document.execCommand('insertHTML', false, html);
            document.getElementById('editor').focus();
        }
    }

    // ---------- HTML режим ----------
    var htmlMode = false;
    function toggleHtml() {
        var editor = document.getElementById('editor');
        var input = document.getElementById('htmlInput');
        if (htmlMode) {
            editor.innerHTML = input.value;
            editor.contentEditable = 'true';
            htmlMode = false;
        } else {
            input.value = editor.innerHTML;
            editor.contentEditable = 'false';
            htmlMode = true;
        }
        document.querySelector('#toolbar').querySelectorAll('button, select, input').forEach(function (el) {
            if (el.onclick && el.onclick.toString().indexOf('toggleHtml') !== -1) return;
            el.disabled = htmlMode;
        });
    }

    // ---------- Модальное окно изображения ----------
    function openImageModal(img) {
        editingImg = img || null;
        document.getElementById('imgModalTitle').textContent = img ? 'Настройки изображения' : 'Вставка изображения';
        resetImageForm();

        if (img) {
            loadImageFromElement(img);
        }

        document.getElementById('imageModal').classList.add('open');
        document.getElementById('editor').focus();
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.remove('open');
        editingImg = null;
    }

    function resetImageForm() {
        document.getElementById('imgFileInput').value = '';
        document.getElementById('imgUrl').value = '';
        document.getElementById('imgWidth').value = '';
        document.getElementById('imgHeight').value = '';
        document.getElementById('imgMargin').value = '0';
        document.getElementById('imgBorderRadius').value = '0';
        document.getElementById('imgBorderWidth').value = '0';
        document.getElementById('imgBorderStyle').value = 'solid';
        document.getElementById('imgBorderColor').value = '#cccccc';
        var radios = document.getElementsByName('imgAlign');
        for (var i = 0; i < radios.length; i++) radios[i].checked = radios[i].value === '';
        document.getElementById('imgAlt').value = '';
        document.getElementById('imgTitle').value = '';
        document.getElementById('imgClass').value = '';
        document.getElementById('imgLink').value = '';
        document.getElementById('imgPreview').style.display = 'none';
        document.getElementById('imgPreview').src = '';
        document.getElementById('imgPreviewPlaceholder').style.display = '';
        aspectLock = false;
        naturalW = 0;
        naturalH = 0;
    }

    function loadImageFromElement(img) {
        var src = img.getAttribute('src') || '';
        document.getElementById('imgUrl').value = src;
        previewImage();

        var w = img.getAttribute('width') || img.style.width || '';
        var h = img.getAttribute('height') || img.style.height || '';
        document.getElementById('imgWidth').value = parseInt(w) || '';
        document.getElementById('imgHeight').value = parseInt(h) || '';

        var style = img.getAttribute('style') || '';
        var m = style.match(/margin:\s*(\d+)px/);
        document.getElementById('imgMargin').value = m ? m[1] : '0';
        var br = style.match(/border-radius:\s*(\d+)px/);
        document.getElementById('imgBorderRadius').value = br ? br[1] : '0';

        var bw = img.style.borderWidth || img.getAttribute('border') || '0';
        document.getElementById('imgBorderWidth').value = parseInt(bw) || 0;
        var bs = img.style.borderStyle || 'solid';
        document.getElementById('imgBorderStyle').value = bs;
        var bc = img.style.borderColor || '#cccccc';
        document.getElementById('imgBorderColor').value = rgbToHex(bc);

        var align = img.getAttribute('data-align') || '';
        if (img.style.float === 'left') align = 'left';
        else if (img.style.float === 'right') align = 'right';
        else if (img.style.display === 'block' && img.style.marginLeft === 'auto' && img.style.marginRight === 'auto') align = 'center';
        var radios = document.getElementsByName('imgAlign');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = radios[i].value === align;
        }

        document.getElementById('imgAlt').value = img.getAttribute('alt') || '';
        document.getElementById('imgTitle').value = img.getAttribute('title') || '';
        document.getElementById('imgClass').value = img.getAttribute('class') || '';

        var parent = img.parentElement;
        if (parent && parent.tagName === 'A') {
            document.getElementById('imgLink').value = parent.getAttribute('href') || '';
        }
    }

    function rgbToHex(c) {
        if (c[0] === '#') return c;
        var m = c.match(/(\d+)/g);
        if (!m) return '#cccccc';
        return '#' + [m[0], m[1], m[2]].map(function (x) {
            var h = parseInt(x).toString(16);
            return h.length === 1 ? '0' + h : h;
        }).join('');
    }

    function uploadImageFile(input) {
        var file = input.files[0];
        if (!file) return;
        var fd = new FormData();
        fd.append('upload', file);
        fetch('/admin/upload-image', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: fd,
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.url) {
                document.getElementById('imgUrl').value = d.url;
                previewImage();
            }
        });
    }

    function previewImage() {
        var url = document.getElementById('imgUrl').value.trim();
        var preview = document.getElementById('imgPreview');
        var placeholder = document.getElementById('imgPreviewPlaceholder');
        if (url) {
            preview.src = url;
            preview.style.display = '';
            placeholder.style.display = 'none';
            preview.onload = function () {
                naturalW = preview.naturalWidth;
                naturalH = preview.naturalHeight;
                if (!document.getElementById('imgWidth').value && !document.getElementById('imgHeight').value) {
                    document.getElementById('imgWidth').value = naturalW;
                    document.getElementById('imgHeight').value = naturalH;
                }
            };
        } else {
            preview.style.display = 'none';
            preview.src = '';
            placeholder.style.display = '';
        }
    }

    function onSizeInput(from) {
        if (!aspectLock) return;
        var w = parseInt(document.getElementById('imgWidth').value) || 0;
        var h = parseInt(document.getElementById('imgHeight').value) || 0;
        if (naturalW === 0 || naturalH === 0) return;
        if (from === 'w' && w > 0) {
            document.getElementById('imgHeight').value = Math.round(w * naturalH / naturalW);
        } else if (from === 'h' && h > 0) {
            document.getElementById('imgWidth').value = Math.round(h * naturalW / naturalH);
        }
    }

    function toggleAspect() {
        aspectLock = !aspectLock;
        document.getElementById('lockBtn').classList.toggle('active');
    }

    // ---------- Применить настройки изображения ----------
    function applyImage() {
        var url = document.getElementById('imgUrl').value.trim();
        if (!url) return;

        var width = document.getElementById('imgWidth').value;
        var height = document.getElementById('imgHeight').value;
        var margin = parseInt(document.getElementById('imgMargin').value) || 0;
        var borderRadius = parseInt(document.getElementById('imgBorderRadius').value) || 0;
        var borderWidth = parseInt(document.getElementById('imgBorderWidth').value) || 0;
        var borderStyle = document.getElementById('imgBorderStyle').value;
        var borderColor = document.getElementById('imgBorderColor').value;
        var alt = document.getElementById('imgAlt').value;
        var title = document.getElementById('imgTitle').value;
        var cls = document.getElementById('imgClass').value;
        var link = document.getElementById('imgLink').value.trim();
        var align = document.querySelector('input[name="imgAlign"]:checked').value;

        var style = '';
        if (margin > 0) style += 'margin:' + margin + 'px;';
        if (borderRadius > 0) style += 'border-radius:' + borderRadius + 'px;';
        if (borderWidth > 0) style += 'border:' + borderWidth + 'px ' + borderStyle + ' ' + borderColor + ';';

        if (align === 'left') { style += 'float:left; margin-right:15px;'; }
        else if (align === 'right') { style += 'float:right; margin-left:15px;'; }
        else if (align === 'center') { style += 'display:block; margin-left:auto; margin-right:auto;'; }

        var html = '<img src="' + url + '"';
        if (width) html += ' width="' + width + '"';
        if (height) html += ' height="' + height + '"';
        if (alt) html += ' alt="' + escapeAttr(alt) + '"';
        if (title) html += ' title="' + escapeAttr(title) + '"';
        if (cls) html += ' class="' + escapeAttr(cls) + '"';
        if (style) html += ' style="' + escapeAttr(style) + '"';
        if (align) html += ' data-align="' + align + '"';
        html += '>';

        if (link) {
            html = '<a href="' + link + '" target="_blank">' + html + '</a>';
        }

        if (editingImg) {
            var parent = editingImg.parentElement;
            if (parent && parent.tagName === 'A' && !link) {
                parent.parentNode.replaceChild(htmlToNode(html), parent);
            } else {
                editingImg.outerHTML = html;
            }
        } else {
            document.execCommand('insertHTML', false, html);
        }

        closeImageModal();
        document.getElementById('editor').focus();
    }

    function escapeAttr(s) {
        return s.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function htmlToNode(html) {
        var t = document.createElement('template');
        t.innerHTML = html;
        return t.content.firstChild;
    }

    // ---------- клик по изображению в редакторе ----------
    document.getElementById('editor').addEventListener('click', function (e) {
        var img = e.target.closest('img');
        if (!img) return;
        e.preventDefault();
        document.querySelectorAll('#editor img.selected').forEach(function (el) { el.classList.remove('selected'); });
        img.classList.add('selected');
        openImageModal(img);
    });

    // ---------- форма ----------
    var form = document.querySelector('form');
    form.onsubmit = function () {
        document.getElementById('htmlInput').value = document.getElementById('editor').innerHTML;
    };

    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.onsubmit();
            form.submit();
        }
    });

    // закрытие модалки по Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeImageModal();
    });

    // закрытие по клику на overlay
    document.getElementById('imageModal').addEventListener('click', function (e) {
        if (e.target === this) closeImageModal();
    });
</script>
@endpush
