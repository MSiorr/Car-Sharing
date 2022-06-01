<script>
    export let params;
    import { calculateDate } from "../js/app";
    import QrCode from "svelte-qrcode";
    import Loader from "./components/Loader.svelte";

    let rentInfo = getRentInfo(params.id);
    let canRender = false;

    async function getRentInfo(id) {
        let form = new FormData();
        form.append("id", id);
        const URL = "./backend/reservInfo.php";
        let res = await fetch(URL, {
            method: "POST",
            body: form,
            mode: "no-cors",
        });
        res = await res.json();
        if (res.access == false) {
            location.href = "./#";
        } else {
            canRender = true;
        }
        return res;
    }
</script>

{#await rentInfo}
    <Loader />
{:then res}
    {#if canRender}
        <section class="text-gray-600 body-font">
            <div class="px-5 py-2 mx-auto flex flex-col">
                <div class="w-full lg:w-4/6 mx-auto">
                    <div
                        class="h-80 w-full md:w-80 overflow-hidden mx-auto text-center flex justify-center"
                    >
                        <div>
                            <QrCode value={res.data.qrCode} size="320" />
                        </div>
                    </div>
                </div>
                <div
                    class="mx-auto mt-4 text-3xl text-gray-300 justify-center items-center text-center"
                >
                    <h1>
                        <span class="text-4xl mt-2">ACCEPTED:</span>
                        {res.data.acceptTime}
                    </h1>
                    <h1>
                        <span class="text-4xl mt-2">FROM:</span>
                        {res.data.resStart}
                    </h1>
                    <h1>
                        <span class="text-4xl mt-2">TO:</span>
                        {calculateDate(res.data.resStart, res.data.resTime)}
                    </h1>
                    <h1>
                        <span class="text-4xl mt-2">DAYS LEFT:</span>
                        {res.data.daysLeft}
                    </h1>
                </div>
            </div>
        </section>
    {/if}
{/await}
