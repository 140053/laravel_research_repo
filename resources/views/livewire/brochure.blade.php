<div>
    {{-- Loading State --}}
    @if ($isLoading)
        <div class="my-10 flex justify-center items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600">Loading brochure...</span>
        </div>
    @elseif ($error)
        {{-- Error State --}}
        <div class="my-10 text-center">
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-red-800 mb-2">Unable to Load Brochure</h3>
                <p class="text-red-600 mb-4">{{ $error }}</p>
                <button wire:click="refreshBrochure" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Try Again
                </button>
            </div>
        </div>
    @elseif ($brochure && $brochure->type == 'pdf')
        {{-- PDF Flipbook --}}
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
        <div class="w-full flex justify-center items-center">
            <div id="flipbook" class="flipbook">
                <div class="hard bg-gradient-to-r from-green-950 to-blue-900">
                    <div class="mt-6">
                        <span class="inline-block bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm">
                            Interactive PDF Viewer
                        </span>
                    </div>
                </div>
                <div class="hard bg-gradient-to-r from-green-950 to-blue-900">
                    <div class="p-6 text-white text-center flex items-center justify-center h-full">
                        <div>
                            <h2 class="text-md font-bold mb-4">{{ $brochure->name }}</h2>
                            @if($brochure->description)
                                <p class="text-blue-100 text-sm">{{ $brochure->description }}</p>
                            @endif
                            
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
            function initializeFlipbook() {
                const pdfUrl = @json($pdfUrl);

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
                        //console.log('Starting PDF render...');
                        const container = document.getElementById('flipbook');
                        if (!container) {
                            console.error('Flipbook container not found');
                            return;
                        }
                        
                        const insertBefore = container.children[container.children.length - 2];

                        //console.log('Loading PDF from:', pdfUrl);
                        const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
                        //console.log('PDF loaded, pages:', pdf.numPages);

                        for (let i = 1; i <= pdf.numPages; i++) {
                            //console.log(`Rendering page ${i}/${pdf.numPages}...`);
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
                            //console.log(`Page ${i} added`);
                        }

                        //console.log('Waiting for Turn.js...');
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
                        
                        //console.log('Flipbook initialized successfully');
                    } catch (error) {
                        console.error('Error rendering PDF:', error);
                    }
                }

                // Only initialize if the component is still in the DOM
                if (document.getElementById('flipbook')) {
                    renderPDFAndInitFlipbook();
                }
            }

            // Initialize on DOM content loaded
            document.addEventListener('DOMContentLoaded', initializeFlipbook);
            
            // Initialize on Livewire updates
            document.addEventListener('livewire:load', initializeFlipbook);
            document.addEventListener('livewire:update', initializeFlipbook);
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
    @elseif ($brochure)
        {{-- Non-PDF Brochure --}}
        <div class="my-10 text-center">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $brochure->name }}</h3>
                <p class="text-gray-600 mb-4">This file type is not supported for flipbook viewing.</p>
                <a href="{{ $pdfUrl }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Download File
                </a>
            </div>
        </div>
    @else
        {{-- No Brochure Available --}}
        <div class="my-10 text-center">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Brochure Available</h3>
                <p class="text-gray-600 mb-4">There is currently no brochure to display.</p>
                <button wire:click="refreshBrochure" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Refresh
                </button>
            </div>
        </div>
    @endif
</div>

