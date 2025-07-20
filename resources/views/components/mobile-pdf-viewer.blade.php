@props(['src', 'paper'])

<div class="w-full max-w-md mx-auto mt-4 mb-10 space-y-4">


    <div class="flex justify-between px-4">
        <button id="prevPage" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Prev</button>
        <span id="pageInfo" class="text-sm text-gray-600 self-center">Page <span id="currentPage">1</span> of <span id="totalPages">?</span></span>
        <button id="nextPage" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Next</button>
    </div>

    <div class="flex justify-center items-center min-h-[400px] bg-gray-100 shadow rounded-lg overflow-hidden">
        <canvas id="pdfCanvas" class="w-full h-auto"></canvas>
    </div>


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    const url = @json($src);
    let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        canvas = document.getElementById('pdfCanvas'),
        ctx = canvas.getContext('2d');

    const renderPage = num => {
        pageRendering = true;
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale: 1.5 });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext).promise.then(() => {
                pageRendering = false;
                document.getElementById('currentPage').textContent = pageNum;
            });
        });
    };

    const queueRenderPage = num => {
        if (!pageRendering) renderPage(num);
    };

    const onPrevPage = () => {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    };

    const onNextPage = () => {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    };

    document.addEventListener('DOMContentLoaded', () => {
        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            document.getElementById('totalPages').textContent = pdf.numPages;
            renderPage(pageNum);
        });

        document.getElementById('prevPage').addEventListener('click', onPrevPage);
        document.getElementById('nextPage').addEventListener('click', onNextPage);
    });
</script>
