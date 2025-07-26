
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
<div class="flex justify-center items-center border-2 border-gray-300 rounded-lg">
    <div id="flipbook" class="flipbook border-2 border-gray-300 rounded-lg m-[-50px]">
        <div class="hard">front</div>
        <div class="hard bg-gradient-to-br from-blue-600 to-blue-800">
            <div class="p-6 text-white text-center flex items-center justify-center h-full">
                <div>
                    <h2 class="text-3xl font-bold mb-4">{{ $data->name ?? 'Document' }}</h2>
                    @if($data->description ?? false)
                        <p class="text-blue-100 text-lg">{{ $data->description }}</p>
                    @endif
                    <div class="mt-6">
                        <span class="inline-block bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm">
                            Interactive PDF Viewer
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hard"></div>
        <!-- Pages will be injected here -->
        <div class="hard bg-gradient-to-br from-gray-700 to-gray-900">
            <div class="p-6 text-white text-center">
                <h3 class="text-2xl font-bold mb-4">End</h3>
                <p class="text-gray-300">Thank you for viewing</p>
            </div>
        </div>        
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
        try {
            console.log('Starting PDF render...');
            const container = document.getElementById('flipbook');
            const insertBefore = container.children[container.children.length - 2];

            console.log('Loading PDF from:', pdfUrl);
            const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
            console.log('PDF loaded, pages:', pdf.numPages);

            for (let i = 1; i <= pdf.numPages; i++) {
                console.log(`Rendering page ${i}/${pdf.numPages}...`);
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
                console.log(`Page ${i} added`);
            }

            console.log('Waiting for Turn.js...');
            // Wait for Turn.js to be available before initializing
            await waitUntilTurnJsReady();
            console.log('Turn.js ready, initializing...');

            $('#flipbook').turn({
                width: 900,
                height: 600,
                autoCenter: true,
                elevation: 50,
                gradients: true,
                when: {
                    turned: function(event, page, pageObject) {
                        // Auto-flip the first page after a short delay
                        if (page === 1) {
                            setTimeout(() => {
                                $(this).turn('next');
                            }, 1000); // 1 second delay
                        }
                    }
                }
            });
            
            console.log('Flipbook initialized successfully');
        } catch (error) {
            console.error('Error rendering PDF:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', renderPDFAndInitFlipbook);
</script>

<!-- ✅ Styles -->
<style>
    #flipbook {
        width: 900px;
        height: 600px;
        margin: 0 auto !important;
        border-radius: 8px;
        overflow: hidden;
        position: relative !important;
        transform: none !important;
    }

    .flipbook .page {
        background-color: rgb(255, 255, 255);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        
    }

    .flipbook .hard {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    canvas {
        display: block;
        margin: auto;
        max-width: 100%;
        height: auto;
        
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        #flipbook {
            width: 800px;
            height: 500px;
        }
    }
    
    @media (max-width: 768px) {
        #flipbook {
            width: 100%;
            max-width: 600px;
            height: 400px;
        }
    }
    
    @media (max-width: 480px) {
        #flipbook {
            width: 100%;
            height: 300px;
        }
    }
</style>
