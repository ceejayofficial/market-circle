<?php $current = $_GET['page'] ?? 'overview'; ?>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed lg:static top-0 left-0 h-full w-72 bg-white border-r z-50
           transform -translate-x-full lg:translate-x-0
           transition-transform duration-300 ease-in-out">

    <!-- HEADER -->
    <div class="h-20 flex items-center justify-between px-6 border-b">

        <div class="text-2xl font-bold tracking-tight">
            Market<span class="text-yellow-500">Circle</span>
        </div>

        <button id="closeSidebar" class="lg:hidden text-2xl font-bold">
            ✕
        </button>

    </div>

    <!-- MENU -->
    <nav class="p-4 space-y-2">

        <?php
        function linkItem($label, $page, $current, $icon) {

            $active = $current === $page
                ? "bg-yellow-500 text-black shadow-md"
                : "text-gray-700 hover:bg-gray-100";

            echo "
            <a href='index.php?page=$page'
               class='group flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 hover:-translate-y-0.5 $active'>

                $icon

                <span class='flex-1'>$label</span>

                <span class='opacity-0 group-hover:opacity-100 transition text-xs'>
                    →
                </span>

            </a>";
        }

        /* ICONS */
        $icon_dashboard = '
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 13h8V3H3v10zm10 8h8V11h-8v10zM3 21h8v-6H3v6zm10-18v6h8V3h-8z"/>
        </svg>';

        $icon_listings = '
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>';

        $icon_post = '
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4v16m8-8H4"/>
        </svg>';

        $icon_profile = '
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>';

        $icon_settings = '
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 8v4l3 3"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.4 15a7.97 7.97 0 000-6"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4.6 9a7.97 7.97 0 000 6"/>
        </svg>';

        /* MENU ITEMS */
        linkItem("Dashboard", "overview", $current, $icon_dashboard);
        linkItem("My Listings", "my-items", $current, $icon_listings);
        linkItem("Post Item", "post-item", $current, $icon_post);
        linkItem("Profile", "profile", $current, $icon_profile);
        linkItem("Settings", "settings", $current, $icon_settings);
        ?>

    </nav>

    <!-- LOGOUT -->
    <div class="absolute bottom-0 w-full p-4 border-t">

       <a href="javascript:void(0)" onclick="confirmLogout()"
   class="flex items-center justify-center gap-2 py-3 rounded-xl bg-red-50 text-red-600
          hover:bg-red-100 transition font-medium group">

    Logout
</a>

    </div>

</aside>