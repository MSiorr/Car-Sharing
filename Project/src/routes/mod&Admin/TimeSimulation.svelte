<script>
    import { checkStatus } from "../../js/app";
    import Loader from "../components/Loader.svelte";

    let schedulderStatus;
    let canRender = false;

    async function getSchedulderStatus() {
        const URL = "./backend/schedulderManager.php";
        let res = await fetch(URL, { method: "GET" });
        res = await res.json();
        return res;
    }

    async function changeStatus() {
        let form = new FormData();
        form.append("action", "changeSchedulder");

        fetch("./backend/schedulderManager.php", {
            method: "POST",
            body: form,
            mode: "no-cors",
        })
            .then((res) => res.json())
            .then((data) => {
                schedulderStatus = getSchedulderStatus();
            });
    }

    checkStatus().then((status) => {
        if (status.logged == true && status.permiss == "admin") {
            canRender = true;
            schedulderStatus = getSchedulderStatus();
        } else {
            location.href = "./#/notFound";
        }
    });
</script>

{#if canRender}
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="xl:w-1/2 lg:w-3/4 w-full mx-auto text-center">
                <p class="leading-relaxed text-lg">
                    <span class="text-2xl text-gray-400">Time simulation</span
                    ><br />
                    One day passes every 10 seconds
                </p>
                {#await schedulderStatus}
                    <p class="mt-12">Data Downloading...</p>
                {:then res}
                    <button
                        on:click={changeStatus.bind(this)}
                        class="w-5/12 py-2 mt-10 rounded-lg text-gray-100 {res.status ==
                        'OFF'
                            ? 'bg-red-600 hover:bg-red-500 '
                            : 'bg-green-500 hover:bg-green-400'}"
                    >
                        {res.status}
                    </button>
                {/await}
            </div>
        </div>
    </section>
{:else}
    <Loader />
{/if}
