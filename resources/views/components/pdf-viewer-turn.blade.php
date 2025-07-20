
    <!-- ✅ Load jQuery FIRST -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- ✅ Load Turn.js -->
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/9729/turn.min.js"></script>

<!-- ✅ Load PDF.js (v3.x) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    window.pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<!-- ✅ Flipbook container -->
<div class="my-10">
    <div id="flipbook" class="flipbook  mx-auto">
        <div class="hard bg-gray-700">
            <div class="p-3 "><h2 class="text-2xl ">{{ $paper->title }}<h2> {{ $paper->authors ? $paper->authors : '' }},<br> {{ $paper->publisher }}, {{ $paper->year }}    </div>
        </div>
        <div class="hard"></div>
        <!-- Pages will be injected here -->
        <div class="hard">END</div>        
    </div>
</div>



<!-- ✅ Flipbook + PDF render logic -->
<script>
    const pdfUrl = @json($src);

    async function waitUntilTurnJsReady() {
        return new Promise((resolve) => {
            const interval = setInterval(() => {
                if (typeof $.fn.turn === 'function') {
                    clearInterval(interval);
                    resolve();
                }
            }, 50);
        });
    }

    async function renderPDFAndInitFlipbook() {
        const container = document.getElementById('flipbook');
        const insertBefore = container.children[container.children.length - 2];

        const pdf = await pdfjsLib.getDocument(pdfUrl).promise;

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            // Dynamically scale to fit 800px width
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

        // Wait for Turn.js to be available before initializing
        await waitUntilTurnJsReady();

        $('#flipbook').turn({
            width: 900,
            height: 600,
            autoCenter: true,
            elevation: 50,
            gradients: true
        });
    }

    


    document.addEventListener('DOMContentLoaded', renderPDFAndInitFlipbook);
</script>

<!-- ✅ Styles -->
<style>
    #flipbook {
        width: 800px;
        height: 500px;
    }

    .flipbook .page {
        background-color: rgb(255, 255, 255);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
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
