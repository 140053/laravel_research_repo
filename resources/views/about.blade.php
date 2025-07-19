<x-home-layout>
    <!-- Page Title Section -->
    <section class=" relative bg-gradient-to-r from-green-950 to-blue-900 py-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-lg shadow-md">
        <div class="absolute left-45 top-4">
            <img src="{{ asset('img/cbsua-logo.png') }}" class="max-w-[150px] hidden sm:block " alt="cbsua" />
        </div>
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 mt-5 leading-tight">
                About {{ config('app.name')   }}
            </h1>
            <p class="text-lg text-indigo-100">
                Your gateway to comprehensive research knowledge.
            </p>
        </div>
        <div class="absolute right-4 top-4">
            <img src="{{ asset('img/pcard-logo.png') }}" class="max-w-[170px] hidden sm:block " alt="pcard" />
        </div>
    </section>


    <!-- Main Content Area - About Us Details -->
    <main class="container mx-auto px-5 sm:px-6 lg:px-8 py-12 mb-5">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Welcome to {{ config('app.name')   }}!</h2>

            <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                {{ config('app.name')   }} is a centralized research repository designed to empower teams by making user research findings, data, and insights easily accessible, searchable, and actionable. Our mission is to foster a data-driven culture, reduce redundant research efforts, and accelerate informed decision-making across the organization.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
                <!-- Role of Lead Researcher -->
                <div>
                    <div class="flex justify-center content-center">
                        <img src="{{ asset('img/pasiona.png') }}" class="max-w-[170px] " alt="lead" />
                    </div>

                    <h3 class="text-2xl font-semibold text-indigo-700 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Our Lead Researcher:
                        <br>Lilia C. Pasiona
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        <b>Lilia C. Pasiona</b> is the current Director of the Regional Apiculture Center and an Associate Professor V at the Central Bicol State University of Agriculture. With a profound passion for bees and research, her studies primarily focus on stingless bees, encompassing their distribution, ecology, and the commercialization of bee honey, pollen, and propolis products.
                    </p>
                    <p class="text-gray-700 mt-3 leading-relaxed">
                        She holds a Master of Science Degree in Environmental Science from the University of Nueva Caceres and is a faculty member of both the BS Biology Program (College of Arts and Sciences) and the Master of Science in Environmental Science Program (Graduate School) at Central Bicol State University of Agriculture.
                    </p>
                    <p class="text-gray-700 mt-3 leading-relaxed">
                        As an accomplished researcher, Ms. Pasiona has presented her work at numerous conferences, earning significant recognition, including the 1st Place Case Presenter award at the South Intensive Program sponsored by Howest University of Applied Sciences and Vives University of Applied Sciences of Belgium. Her innovative propolis soap and throat spray products were also recognized at the National Agriculture and Fisheries Technology Exhibition as among the best in the non-food category. She is a GADtimpala awardee (2023) for her outstanding performance in gender mainstreaming and effective implementation of gender-responsive programs, and a Junior Chamber International service awardee (2024) for her exceptional support in fostering positive change.
                    </p>
                    <p class="text-gray-700 mt-3 leading-relaxed">
                        Beyond apiculture, her research expertise extends to crop science, particularly focusing on Taro. Her studies "Morphological Characterization of Taro Cultivars in Bicol Region" and "Pre and Post Harvest of TARO Technology in the Bicol Region" both earned her the 2nd Best Paper Presenter Award. Currently, she leads the "Survey, Collection, and Characterization of the Indigenous Crops in Region 5" project, a collaborative effort between CBSUA and DOST-PCAARRD.
                    </p>
                </div>

                <!-- Role of DOST-PCAARRD -->
                <div>
                    <div class="flex justify-center content-center">
                        <img src="{{ asset('img/pcard-logo.png') }}" class="max-w-[170px] " alt="pcard" />
                    </div>
                    <h3 class="text-2xl font-semibold text-purple-700 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Our Partner: DOST-PCAARRD
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Insights Hub is proudly supported by the **Philippine Council for Agriculture, Aquatic and Natural Resources Research and Development (DOST-PCAARRD)**. As one of the sectoral councils under the Department of Science and Technology (DOST), PCAARRD plays a crucial role in:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 mt-3 space-y-2">
                        <li>Formulating policies, plans, and programs for S&T-based R&D in the AANR sector.</li>
                        <li>Coordinating, evaluating, and monitoring national R&D efforts.</li>
                        <li>Allocating government and external funds for R&D and generating resources to support programs.</li>
                        <li>Engaging in active partnerships for joint R&D, human resource development, and technology exchange.</li>
                    </ul>
                    <p class="text-gray-700 mt-4 leading-relaxed">
                        DOST-PCAARRD's involvement ensures that the research within this repository is aligned with national scientific priorities and contributes to significant advancements in the agriculture, aquatic, and natural resources sectors. Their expertise and strategic direction are invaluable to the quality and relevance of the insights shared here.
                    </p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-xl font-semibold text-gray-900 mb-4">
                    Together, we strive to make research more impactful and accessible.
                </p>
                <a href="/" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-colors duration-200">
                    Explore Insights Now
                </a>
            </div>
        </div>
    </main>



</x-home-layout>
