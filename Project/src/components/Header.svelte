<script>
    import { store_STATUS } from "../stores/storeone";
    let status = {};
    store_STATUS.subscribe(async (v) => {
        status = await v;
    });

    async function onLogOut() {
        const URL = "./backend/LogOut.php";
        let ress = await fetch(URL, { method: "GET" });
        // location.href = "./#";
        location.reload();
    }
</script>

<header
    id="header"
    class="text-gray-400 bg-gray-900 body-font sticky top-0 z-10"
>
    <div
        class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center"
    >
        <a
            class="flex title-font font-medium items-center text-white mb-4 md:mb-0 cursor-pointer"
            href="./#"
        >
            <img class="w-16" src="./assets/logo.png" alt="logo" />
            <span class="ml-3 text-xl">Exotic&nbsp;Share</span>
        </a>

        <nav
            class="md:ml-auto flex flex-wrap items-center text-base justify-center"
        >
            <a href="#/carList" class="ml-2 mr-2 hover:text-gray-100"
                >Our Cars</a
            >
            {#if status.logged == false}
                <a href="#/register" class="no-underline">
                    <button
                        class="inline-flex items-center mr-5 ml-5 bg-yellow-500 text-black border-0 py-1 px-3 focus:outline-none hover:bg-yellow-400 rounded text-base mt-4 md:mt-0 "
                    >
                        Register
                        <svg
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 ml-1"
                            viewBox="0 0 24 24"
                        >
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </a>
                <a href="#/login" class="no-underline">
                    <button
                        class="inline-flex items-center bg-yellow-500 text-black border-0 py-1 px-3 focus:outline-none hover:bg-yellow-400 rounded text-base mt-4 md:mt-0 "
                        >Login
                        <svg
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 ml-1"
                            viewBox="0 0 24 24"
                        >
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </a>
            {:else}
                <a href="#/myReservations" class="ml-2 mr-2 hover:text-gray-100"
                    >My Reservations</a
                >
                {#if status.permiss != "client"}
                    <a
                        href="#/allReservations"
                        class="ml-2 mr-2 hover:text-gray-100"
                        >All Reservations</a
                    >
                    {#if status.permiss == "admin"}
                        <a
                            href="#/adminPanel"
                            class="ml-2 mr-2 hover:text-gray-100">Admin Panel</a
                        >
                        <a
                            href="#/timeSimulation"
                            class="ml-2 mr-2 hover:text-gray-100"
                            >Time Simulation</a
                        >
                    {/if}
                {/if}
                <p class="text-xl text-white ml-5 mr-5 font-bold sm:mr-1">
                    {status.login}
                </p>
                <button
                    on:click={onLogOut.bind(this)}
                    class="inline-flex items-center bg-yellow-500 text-black border-0 py-1 px-3 focus:outline-none hover:bg-yellow-400 rounded text-base mt-0 md:mt-0 ml-2 mr-2"
                    >Logout
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        class="w-4 h-4 ml-1"
                        viewBox="0 0 24 24"
                    >
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            {/if}
        </nav>
    </div>
</header>
