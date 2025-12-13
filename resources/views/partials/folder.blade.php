        {{-- <div class="mt-2">

            <!-- GRID TITLE -->
            <h4 class="text-lg font-semibold text-slate-200 mb-4">Document Categories</h4> --}}

            <!-- 3x3 GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- CATEGORY 1 -->
                <a href="{{ route('documents.category', 'admin') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />
                    <p class="mt-3 font-medium text-slate-200">Admin</p>
                </a>

                <!-- CATEGORY 2 -->
                <a href="{{ route('documents.category', 'personnel-services') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                     <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />
                    <p class="mt-3 font-medium text-slate-200">Personnel Services</p>
                </a>

                <!-- CATEGORY 3 -->
                <a href="{{ route('documents.category', 'recruitment-division') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                     <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />
                    <p class="mt-3 font-medium text-slate-200">Recruitment Division</p>
                </a>

                <!-- CATEGORY 4 -->
                <a href="{{ route('documents.category', 'career-management') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                     <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />
                    <p class="mt-3 font-medium text-slate-200">Career Management</p>
                </a>

                <!-- CATEGORY 5 -->
                <a href="{{ route('documents.category', 'enlisted-personnel-class-advisory') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                     <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />
                    <p class="mt-3 font-medium text-slate-200">Enlisted Personnel Class Advisory</p>
                </a>

                <!-- CATEGORY 6 -->
                <a href="{{ route('documents.category', 'officer-career-advisory') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                     <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />
                    <p class="mt-3 font-medium text-slate-200">Officer Career Advisory</p>
                </a>

            </div>
        {{-- </div> --}}
        {{-- <div class="bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
    </div> --}}