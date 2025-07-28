<x-home-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-green-950 to-blue-900 py-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-lg shadow-md">
        <div class="absolute left-45 top-4">
            <img src="{{ asset('img/cbsua-logo.png') }}" class="max-w-[150px] hidden sm:block" alt="CBSUA Logo" />
        </div>
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 mt-5 leading-tight">
                About {{ config('app.name') }}
            </h1>
            <p class="text-lg text-indigo-100">
                Advancing Research Excellence and Collaboration
            </p>
        </div>
        <div class="absolute right-4 top-4">
            <img src="{{ asset('img/pcard-logo.png') }}" class="max-w-[170px] hidden sm:block" alt="PCAARRD Logo" />
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="container mx-auto px-5 sm:px-6 lg:px-8 py-12 mb-5">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 max-w-4xl mx-auto">
            <!-- About the Repository -->
            <h2 class="text-3xl font-bold text-gray-900 mb-6">About the Research Repository</h2>
            <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                <b>{{ config('app.name') }}</b> serves as a centralized platform for the collection, archiving, and dissemination of research outputs. Our mission is to foster a culture of scientific inquiry, promote data-driven decision-making, and facilitate collaboration among researchers, educators, and stakeholders. By providing seamless access to research findings and resources, we aim to accelerate innovation and support the advancement of knowledge in agriculture, aquatic, and natural resources.
            </p>

            <!-- Project Overview -->
            <div class="mt-10 mb-10">
                <h3 class="text-2xl font-bold text-green-800 mb-4">Flagship Project Overview</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    <b>Project Title:</b> PCAARRD Project 1: Survey, Collection, and Characterization of Indigenous Crops in Region V
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    This project aims to systematically survey, collect, and characterize indigenous crops across the Bicol Region. The initiative is designed to preserve genetic diversity, support sustainable agriculture, and provide a scientific basis for future research and development. The collaborative effort is led by distinguished experts and supported by dedicated research staff, ensuring the highest standards of academic rigor and impact.
                </p>
            </div>

            <!-- Leadership & Team -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-indigo-700 mb-4">Project Leadership and Research Team</h3>
                <ul class="list-none text-gray-800 mb-4">
                    <li><span class="font-bold">Program Leader:</span> Allan B. Del Rosario, Ph.D.</li>
                    <li><span class="font-bold">Project Leader:</span> Lilia C. Pasiona</li>
                </ul>
                <div class="mb-2">
                    <span class="font-bold text-gray-700">Study Leaders:</span>
                    <ul class="list-disc list-inside ml-4 mt-2 text-gray-700">
                        <li><span class="font-semibold">Marco Stefan B. Lagman, Ph.D.</span> – Albay Province</li>
                        <li><span class="font-semibold">Rolando P. Oloteo, Ph.D.</span> – Sorsogon Province</li>
                        <li><span class="font-semibold">Jesusa B. Taumatorgo, Ph.D.</span> – Camarines Sur Province</li>
                        <li><span class="font-semibold">Julie Amara M. Bondilles</span> – Project Staff Level III</li>
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="font-bold text-gray-700">Project Staff:</span>
                    <ul class="list-disc list-inside ml-4 mt-2 text-gray-700">
                        <li>Janica M. Intia</li>
                        <li>Joseph Benedict L. Espiritu</li>
                        <li>Miki Angela T. Kurahashi</li>
                        <li>Rhandel Proceso O. Leonor</li>
                        <li>Mark Philip P. Baldon</li>
                        <li>Veberlyn C. Boncodin</li>
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="font-bold text-gray-700">Project Staff and Layout Artist:</span> Francis Gabriel M. Timado
                </div>
            </div>

            <!-- Lead Researcher Profile -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-indigo-700 mb-4">Lead Researcher Profile</h3>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <img src="{{ asset('img/pasiona.png') }}" class="max-w-[170px] rounded shadow" alt="Lilia C. Pasiona" />
                    <div>
                        <p class="text-gray-700 leading-relaxed mb-2">
                            <b>Lilia C. Pasiona</b> is the Director of the Regional Apiculture Center and an Associate Professor V at the Central Bicol State University of Agriculture. Her research focuses on stingless bees, their ecology, and the commercialization of bee products. She holds a Master of Science in Environmental Science from the University of Nueva Caceres and is a faculty member in both undergraduate and graduate programs at CBSUA.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-2">
                            Ms. Pasiona has received national and international recognition for her research, including awards for case presentations and innovative product development. Her expertise extends to crop science, particularly Taro, and she currently leads the flagship project on indigenous crops in Region V.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Institutional Partner -->
            <div class="mb-10">
                <h3 class="text-2xl font-bold text-purple-700 mb-4">Institutional Partner: DOST-PCAARRD</h3>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <img src="{{ asset('img/pcard-logo.png') }}" class="max-w-[170px] rounded shadow" alt="DOST-PCAARRD Logo" />
                    <div>
                        <p class="text-gray-700 leading-relaxed mb-2">
                            The <b>Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (DOST-PCAARRD)</b> is a key partner in this initiative. As a sectoral council under the Department of Science and Technology, PCAARRD is instrumental in formulating policies, coordinating research, and supporting innovation in the agriculture, aquatic, and natural resources sectors.
                        </p>
                        <ul class="list-disc list-inside text-gray-700 mt-2 mb-2">
                            <li>Policy formulation and strategic planning for S&T-based R&D</li>
                            <li>Coordination, evaluation, and monitoring of national R&D efforts</li>
                            <li>Resource allocation and partnership development</li>
                            <li>Capacity building and technology transfer</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            DOST-PCAARRD’s involvement ensures that the research repository aligns with national priorities and contributes to the advancement of science and technology in the Philippines.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 text-center">
                <p class="text-xl font-semibold text-gray-900 mb-4">
                    Join us in advancing research and innovation for a sustainable future.
                </p>
                <a href="/" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-colors duration-200">
                    Explore the Repository
                </a>
            </div>
        </div>
    </main>
</x-home-layout>
