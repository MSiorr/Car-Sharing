<script>
    import MyReservationsRow from "./MyReservationsRow.svelte";

    export let itemUp;
    export let res;
    export let changeVal;
</script>

<div class="lg:w-11/12 w-full mx-auto overflow-auto my-5">
    <h1
        class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-100 text-center my-12"
    >
        {itemUp.toUpperCase()}
    </h1>
    <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
            <tr>
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center rounded-tl"
                    >Lp</th
                >
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center"
                    >Date Start</th
                >
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center"
                    >Date End</th
                >
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center"
                    >Full Price</th
                >
                <th
                    class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center {itemUp ==
                    'declined'
                        ? 'rounded-tr'
                        : null}">Car Info</th
                >
                {#if itemUp == "accepted"}
                    <th
                        class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center"
                        >Res Info</th
                    >
                {/if}
                {#if itemUp != "declined"}
                    <th
                        class="px-4 py-3 title-font tracking-wider font-bold text-gray-900 text-xs sm:text-sm md:text-lg bg-gray-100 text-center rounded-tr"
                        >Action</th
                    >
                {/if}
            </tr>
        </thead>
        <tbody>
            {#each res[itemUp] as item, i}
                <MyReservationsRow {item} {i} {itemUp} {changeVal} />
            {/each}
        </tbody>
    </table>
</div>
