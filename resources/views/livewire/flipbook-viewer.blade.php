<div class="my-10">
    <!-- Flipbook Container -->
    <div id="flipbook" class="flipbook mx-auto">
        <!-- Cover -->
        <div class="hard bg-gray-700">
            <div class="p-3 text-white">
                <h2 class="text-2xl font-bold">{{ $paper->title }}</h2>
                <p>{{ $paper->authors ?? '' }},<br>{{ $paper->publisher }}, {{ $paper->year }}</p>
            </div>
        </div>

        <!-- Back Cover -->
        <div class="hard"></div>
        <div class="hard">END</div>
    </div>
</div>

@push('styles')
<style>
    #flipbook {
        width: 800px;
        height: 500px;
    }
    .flipbook .page {
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .flipbook .hard {
        background: #f5f5f5;
        text-align: center;
    }
    canvas {
        display: block;
        margin: auto;
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@push('scripts')
<!-- ✅ External Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/9729/turn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    window.pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<!-- ✅ Flipbook Logic -->
<script>
    document.addEventListener('livewire:load', async () => {
        const pdfUrl = @json($src);
        const container = document.getElementById('flipbook');
        const insertBefore = container.children[container.children.length - 2];
        const pdf = await pdfjsLib.getDocument(pdfUrl).promise;

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const scale = 800 / page.getViewport({ scale: 1 }).width;
            const viewport = page.getViewport({ scale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            await page.render({ canvasContext: context, viewport }).promise;

            const pageDiv = document.createElement('div');
            pageDiv.className = 'page';
            pageDiv.appendChild(canvas);
            container.insertBefore(pageDiv, insertBefore);
        }

        // Wait until turn.js is ready
        const waitUntilTurnJsReady = () => {
            return new Promise(resolve => {
                const interval = setInterval(() => {
                    if (typeof $.fn.turn === 'function') {
                        clearInterval(interval);
                        resolve();
                    }
                }, 50);
            });
        };

        await waitUntilTurnJsReady();

        $('#flipbook').turn({
            width: 900,
            height: 600,
            autoCenter: true,
            elevation: 50,
            gradients: true
        });
    });
</script>
@endpush
