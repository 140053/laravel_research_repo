<div x-data="{ open: false }" class="w-full max-w-md mx-auto">
    {{-- Thumbnail Canvas --}}
    <canvas id="{{ $id }}" class="cursor-pointer border shadow rounded w-full h-auto" @click="open = true"></canvas>

    {{-- Modal --}}
    <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
        <div class="relative bg-white rounded shadow-lg max-w-5xl w-full h-[90vh] overflow-hidden">
            {{-- Close Button --}}
            <button @click="open = false"
                class="absolute top-2 right-2 text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded z-10">
                ✕
            </button>

            {{-- PDF Iframe --}}
            <iframe src="{{ $src }}" class="w-full h-full border-none"></iframe>
        </div>
    </div>
</div>

{{-- PDF.js for rendering thumbnail --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const url = @json($src);
        const canvas = document.getElementById(@json($id));
        const ctx = canvas.getContext('2d');

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        pdfjsLib.getDocument(url).promise.then(pdf => {
            return pdf.getPage(1);
        }).then(page => {
            const scale = 1.2;
            const viewport = page.getViewport({ scale });

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            return page.render(renderContext).promise;
        }).catch(error => {
            console.error('PDF.js render error:', error);
        });
    });
</script>
