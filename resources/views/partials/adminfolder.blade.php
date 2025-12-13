use

<!-- 3x3 GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

    <!-- CATEGORY 1 -->
    <a href="{{ route('admin.admincategory', 'admin') }}"
       class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E]
              rounded-lg p-5 flex flex-col items-center justify-center transition">

       <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />

        <p class="mt-3 font-medium text-slate-200">Admin</p>
        <span class="text-xs text-slate-400 mt-1">Upload / Replace</span>
    </a>

    <!-- CATEGORY 2 -->
    <a href="{{ route('admin.admincategory', 'personnel-services') }}"
       class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E]
              rounded-lg p-5 flex flex-col items-center justify-center transition">

       <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />

        <p class="mt-3 font-medium text-slate-200">Personnel Services</p>
    </a>

    <!-- CATEGORY 3 -->
    <a href="{{ route('admin.admincategory', 'recruitment-division') }}"
       class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E]
              rounded-lg p-5 flex flex-col items-center justify-center transition">

       <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />

        <p class="mt-3 font-medium text-slate-200">Recruitment Division</p>
    </a>

    <!-- CATEGORY 4 -->
    <a href="{{ route('admin.admincategory', 'career-management') }}"
       class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E]
              rounded-lg p-5 flex flex-col items-center justify-center transition">

       <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />

        <p class="mt-3 font-medium text-slate-200">Career Management</p>
    </a>

    <!-- CATEGORY 5 -->
    <a href="{{ route('admin.admincategory', 'enlisted-personnel-class-advisory') }}"
       class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E]
              rounded-lg p-5 flex flex-col items-center justify-center transition">

       <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />

        <p class="mt-3 font-medium text-slate-200">
            Enlisted Personnel Class Advisory
        </p>
    </a>

    <!-- CATEGORY 6 -->
    <a href="{{ route('admin.admincategory', 'officer-career-advisory') }}"
       class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E]
              rounded-lg p-5 flex flex-col items-center justify-center transition">

       <x-folder-icon class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition" />

        <p class="mt-3 font-medium text-slate-200">
            Officer Career Advisory
        </p>
    </a>

</div>
